<?php

namespace App\Controller\Admin;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\File\UploadedFile,
	Symfony\Component\HttpKernel\HttpKernelInterface,
	Library\BaseController,
	App\Model\News as NewsModel,
	App\Form\News as NewsForm,
	Library\Utils\Misc as _U,
	Library\Utils\Image as _I;


class News extends BaseController implements ControllerProviderInterface
{
	public $section = 'news';
	public $errors 	= [];
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> baseModel = '\App\Model\News';
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];

		$factory -> get('/', 'App\Controller\Admin\News::index')
				-> bind('admin.news.list');
		
		$factory -> match('/edit/{postId}', 'App\Controller\Admin\News::edit')
				-> method('GET|POST')
				-> value('postId', false)
				-> bind('admin.news.edit');
		
		$factory -> match('/delete', 'App\Controller\Admin\News::delete')
				-> method('GET|POST')
				-> bind('admin.news.delete');
		
		$factory -> match('/updateStatus', 'App\Controller\Admin\News::updateStatus')
				-> method('GET|POST')
				-> bind('admin.news.upstatus');
		

		return $factory;
	}
	
	
	public function edit(Application $app, Request $request, $postId = false)
	{
		$form = (new NewsForm($app)) -> buildForm();
		$this -> renderBatch['form'] = $form -> createView();
		
		if (!is_null($request -> get('formNewsPost')['id'])) $postId = $request -> get('formNewsPost')['id'];
		
		$postId ? $model = NewsModel::find((int)$postId) : $model = new NewsModel();
		$this -> renderBatch['post'] = $model;
		
		if ($request -> getMethod() == 'POST') {
			$data = $form -> submit($request -> get('formNewsPost')) -> getData();
			$this -> errors = $this -> getFormErrors($form);
		
			if (empty($this -> errors)) {
				// process data
				$logo = $request -> files -> get('logo');
				if (!is_null($logo)) {
					if (!is_null($data['logo'])) {
						$model -> setApp($app) -> deleteLogo($data['logo']);
					}
					$data['logo'] = $model -> setApp($app) -> genFileName($logo);
				}
		
				foreach ($data as $key => $value) {
					$model -> $key = $value;					
				}

				try {
					$model -> save();
					if (!is_null($logo)) {
						$model -> saveLogo($logo, $data['logo']);
					} 
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
		
		return $app['twig'] -> render('protected/news/edit.twig', $this -> renderBatch);
	}

}