<?php

namespace App\Controller\Admin;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\File\UploadedFile,
	Symfony\Component\HttpKernel\HttpKernelInterface,
	Library\BaseController,
	App\Model\Training as TrainingModel,
	App\Model\TrainingImage as TrainingImage,
	App\Form\Training as TrainingForm,
	Library\Utils\Misc as _U,
	Library\Utils\Image as _I;


class Training extends BaseController implements ControllerProviderInterface
{
	public $section = 'training';
	public $errors 	= [];
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> baseModel = '\App\Model\Training';
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
	
		$factory -> get('/', 'App\Controller\Admin\Training::index')
				 -> bind('admin.training.list');
	
		$factory -> match('/edit/{trainingId}', 'App\Controller\Admin\Training::edit')
				 -> method('GET|POST')
				 -> value('trainingId', false)
				 -> bind('admin.training.edit');
	
		$factory -> match('/delete', 'App\Controller\Admin\Training::delete')
				 -> method('GET|POST')
				 -> bind('admin.training.delete');
	
		$factory -> match('/updateStatus', 'App\Controller\Admin\Training::updateStatus')
				 -> method('GET|POST')
				 -> bind('admin.training.upstatus');
	
		return $factory;
	}
	

	public function edit(Application $app, Request $request, $postId = false)
	{
		$form = (new TrainingForm($app)) -> buildForm();
		$this -> renderBatch['form'] = $form -> createView();
	
		if (!is_null($request -> get('formTraining')['id'])) $postId = $request -> get('formTraining')['id'];
	
		$postId ? $model = TrainingModel::find((int)$postId) : $model = new TrainingModel();
		$model -> setApp($app);
		$this -> renderBatch['post'] = $model;
	
		if ($request -> getMethod() == 'POST') {
// _U::dump($request -> get('formPost'), true);
// _U::dump($request -> get('formImageUploaded'), true);
// _U::dump($request -> files -> get('header_big'), true);
// _U::dump($request -> files -> get('header_small'), true);

			$dataRaw = $request -> get('formPost');
			$data = $form -> submit($request -> get('formPost')) -> getData();
			$this -> errors = $this -> getFormErrors($form);
//_U::dump($data, true);	
			if (empty($this -> errors)) {
				// process data
				$model -> name = $data['name'];
				$model -> url_name = $data['url_name'];
				$model -> status = $data['status'];
				
				// process images from textarea fields
// 				$model -> intro = _I::parseImagesInText($data['intro_hidden'], 
// 														$app['appConfig'] -> upload -> tempPath, 
// 														$app['appConfig'] -> upload -> trainingPath . $model -> url_name . '/', 
// 														$app['appConfig'] -> webUrl -> trainingPath . $model -> url_name . '/', 
// 														$request -> get('formImageUploaded'));
				
				$model -> description = _I::parseImagesInText($data['description_hidden'], 
														$app['appConfig'] -> upload -> tempPath, 
														$app['appConfig'] -> upload -> trainingPath . $model -> url_name. '/', 
														$app['appConfig'] -> webUrl -> trainingPath . $model -> url_name. '/', 
														$request -> get('formImageUploaded'));
_U::dump($model -> description);
				try {
					$model -> save();
					
					if ($request -> files -> has('header_big')) 
						(new TrainingImage()) -> saveImage($request -> files -> gas('header_big'), $model -> url_name, false, 'header_big');
					if ($request -> files -> has('header_small')) 
						(new TrainingImage()) -> saveImage($request -> files -> gas('header_small'), $model -> url_name, false, 'header_small');
					
					return $app -> redirect($app['url_generator'] -> generate('admin.news.list'));
					
				} catch(\Exception $e) {
					$this -> errors = $model -> errors;
				}
			}
		}
	
		if ($postId) {
			$this -> renderBatch['postId'] = $postId;
		}
		$this -> renderBatch['errors'] = $this -> errors;
	
		return $app['twig'] -> render('protected/training/edit.twig', $this -> renderBatch);
	}
}