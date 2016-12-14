<?php 

namespace App\Controller\Admin;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Library\BaseController, 
	Library\Utils\Misc as _U;
	

class Event extends BaseController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
	
		$factory -> get('/', 'App\Controller\Admin\Event::index')
			-> bind('admin.event');
	
		return $factory;
	}

	
	public function index(Application $app)
	{
		return $app['twig'] -> render('protected/event/list.twig');
	}
}