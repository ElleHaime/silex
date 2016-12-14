<?php 

namespace App\Controller;

use Silex\Application,
	Silex\ControllerProviderInterface,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Library\BaseController,
	Library\Utils\Misc as _U,
	App\Model\User;
	

class Auth extends BaseController implements ControllerProviderInterface
{
	public function connect(Application $app)
	{
		$factory = $app['controllers_factory'];
		$factory -> get('/', 'App\Controller\Auth::login')
			-> before(function(Request $request, Application $app) {
// 						_U::dump($app['security'] -> isGranted('IS_AUTHENTICATED_FULLY'));
					  })
			-> bind('login');
	
		return $factory;
	}
	
	public function login(Application $app, Request $request)
	{
		return $app['twig'] -> render('auth/login.twig', ['last_error' => $app['security.last_error']($request),
									        			   'last_username' => $app['session'] -> get('_security.last_username')]);		
	}
}