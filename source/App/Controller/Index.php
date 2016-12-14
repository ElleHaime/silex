<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	App\Model\Slider,
	App\Model\News,
	Library\BaseController, 
	Library\Utils\Misc as _U;
	

class Index extends BaseController implements ControllerProviderInterface
{
	public $section 		= 'index';

	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
	}

	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\Index::index') -> bind('home');
		
		return $factory;
	}
	
	
	public function index(Application $app)
	{
		$this -> loadWrapper($app);
		
		$this -> renderBatch['slider'] = (new Slider()) -> setApp($app) -> getSlider();
		$this -> renderBatch['news'] = (new News()) -> setApp($app) -> getAll(['order' => ['sort' => 'DESC'], 'limit' => ['number' => 10]]);
		
		return $app['twig'] -> render('index/index.twig', $this -> renderBatch);
	}
}