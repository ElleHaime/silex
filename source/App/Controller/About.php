<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	App\Model\Slider,
	Library\BaseController, 
	Library\Utils\Misc as _U;
	

class About extends BaseController implements ControllerProviderInterface
{
	public $section 	= 'about';
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> renderBatch['settings']['navigation'] = [['url' => '/about', 'title' => 'О нас']];
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\About::about') -> bind('about');
		$factory -> get('/corporate', 'App\Controller\About::corporate') -> bind('corporate');
	
		return $factory;
	}
	
	
	public function about(Application $app)
	{
		$this -> loadWrapper($app);
		return $app['twig'] -> render('about/about.twig', $this -> renderBatch);
	}
	
	
	public function corporate(Application $app, Request $request)
	{
		$this -> loadWrapper($app);
		$this -> renderBatch['settings']['navigation'][] = ['url' => $request -> getRequestUri(), 'title' => 'Корпоративным клиентам'];
		return $app['twig'] -> render('about/corporate.twig', $this -> renderBatch);
	}
	
}