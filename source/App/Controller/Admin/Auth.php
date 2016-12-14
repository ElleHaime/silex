<?php 

namespace App\Controller\Admin;

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
		
		$factory -> post('/login_check', 'App\Controller\Admin\Auth::loginCheck')
            -> bind('admin.login-check');
		
		$factory -> get('/logout', 'App\Controller\Admin\Auth::logout') 
			-> bind('admin.logout');
		
		$factory -> get('/change_password', 'App\Controller\Admin\Auth::changePassword') 
			-> bind('admin.change-password');
	
		return $factory;
	}
	
	
	public function loginCheck(Application $app, Request $request)
	{
	}
	
	
	public function changePassword(Application $app, Request $request)
	{
		return;
	}
	
	
	public function logout(Application $app, Request $request)
	{
		_U::dump($request -> request);
		die();
	}
}