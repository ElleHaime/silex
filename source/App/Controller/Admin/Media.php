<?php

namespace App\Controller\Admin;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\File\UploadedFile,
	Symfony\Component\HttpKernel\HttpKernelInterface,
	Library\BaseController,
	App\Model\EventMedia as MediaModel,
	Library\Utils\Misc as _U,
	Library\Utils\Image as _I;


class Media extends BaseController implements ControllerProviderInterface
{
	public $section = 'media';
	public $errors 	= [];
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> baseModel = '\App\Model\EventMedia';
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
	
		$factory -> match('/uploadTemp', 'App\Controller\Admin\Media::uploadTemp')
				 -> method('GET|POST')
				 -> bind('admin.media.uploadTemp');
	
		return $factory;
	}

		
	public function uploadTemp(Application $app, Request $request)
	{
		if ($request -> getMethod() == 'POST') {
			$image = $request -> files -> get('image1'); 

			if (!is_null($image)) {
				$tempImg = (new _I()) -> setApp($app) -> saveTempImage($image);
				$tempImg ? $result = $tempImg : $result = 'error';
			} else {
				$result = 'fail';
			}
		}
		return $app -> json($result, 200, array('Content-Type' => 'application/json'));
	}
}	