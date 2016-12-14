<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	App\Model\Event,
	Library\BaseController, 
	Library\Utils\Misc as _U;
	

class Media extends BaseController implements ControllerProviderInterface
{
	public $section 	= 'media';
	
	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> renderBatch['settings']['navigation'] = [['url' => '/media', 'title' => 'Медиа']];
	}
	
	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\Media::index') -> bind('media');
		$factory -> get('/{eventId}/photo', 'App\Controller\Media::photo') -> bind('photo');
		$factory -> get('/video/{trainingName}', 'App\Controller\Media::video') -> bind('video');
	
		return $factory;
	}
	
	
	public function index(Application $app)
	{
		$this -> loadWrapper($app);
		
		$this -> renderBatch['media'] = (new Event()) -> setApp($app) -> getAllMedia();
		return $app['twig'] -> render('media/index.twig', $this -> renderBatch);
	}
	
	
	
	public function photo(Application $app, Request $request, $eventId)
	{
		$this -> loadWrapper($app);
		$this -> renderBatch['media'] = (new Event()) -> setApp($app) -> getEventMedia($eventId);
		$this -> renderBatch['event_media'] = $this -> renderBatch['media'] -> event_media;
		$this -> renderBatch['settings']['navigation'][] = ['url' => $request -> getRequestUri(), 'title' => $this -> renderBatch['media'] -> training -> name];
		
		return $app['twig'] -> render('media/photo.twig', $this -> renderBatch);
	}
	
	
	
	public function video(Application $app, Request $request)
	{
		$this -> loadWrapper($app);
		return $app['twig'] -> render('about/about.twig', $this -> renderBatch);
	}
}