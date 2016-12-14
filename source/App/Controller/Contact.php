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
	

class Contact extends BaseController implements ControllerProviderInterface
{
	public $section 			= 'contact';
	public $contactFormFields 	= ['user_name', 'user_email', 'user_subject', 'user_body'];
	public $types		 		= ['social' => [ 
										'subtype' => ['facebook', 'vk', 'instagram']
									],
									'phone' => [ 
										'subtype' => ['mobile']
									],
									'location' => [ 
										'subtype' => ['address', 'coordinates']
									],
									'email',
									'messenger' => [
										'subtype' => ['skype']
									]];

	
	public function __construct()
	{
		$this -> renderBatch['settings']['section'] = $this -> section;
		$this -> renderBatch['settings']['navigation'] = [['url' => '/contact', 'title' => 'Контакты']];
	}

	
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\Contact::index') -> bind('contact');
		$factory -> post('/send', 'App\Controller\Contact::sendMessage');
		
		return $factory;
	}
	
	
	public function index(Application $app)
	{
		$this -> loadWrapper($app);
		return $app['twig'] -> render('contact/index.twig', $this -> renderBatch);
	}
	
	
	public function sendMessage(Application $app, Request $request)
	{
		$test = mail('svrazina@gmail.com', 
					 'ostc.com.ua:: ' . $request -> request -> get('user_subject'), 
					 $request -> request -> get('user_body'),
					 "From: " . $request -> request -> get('user_name') . " " . $request -> request -> get('user_email') . " \r\n");

		return $app -> json(['result' => 'OK'], 200, array('Content-Type' => 'application/json'));
	}
}