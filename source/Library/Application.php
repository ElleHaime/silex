<?php 

use Silex\Application as BaseApplication,
	Silex\Provider\DoctrineServiceProvider,
	Silex\Provider\FormServiceProvider,
	Silex\Provider\SecurityServiceProvider,
	Silex\Provider\ServiceControllerServiceProvider,
	Silex\Provider\SessionServiceProvider,
	Silex\Provider\SwiftmailerServiceProvider,
	Silex\Provider\TranslationServiceProvider,
	Silex\Provider\UrlGeneratorServiceProvider,
	Silex\Provider\ValidatorServiceProvider,
	Silex\Provider\TwigServiceProvider,
	Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder,
	Library\Providers\ActiveRecordProvider;


class Application extends BaseApplication
{
	protected $appConfig	= null;
	protected $dbConfig	= null;
	protected $fbConfig	= null;
	protected $loader		= null;
	protected $nsConfig	= null;
	
	
	public function __construct(array $values = array())
	{
		if (!isset($values['loader'])) {
			throw new \Exception('Loader should be setted');
			return false;
		}
		$this -> loader = $values['loader'];
		
		$this -> initConfig();
		$initialParams = ['debug' => $this -> appConfig -> debug,
						  'locale' => $this -> appConfig -> locale,
						  'charset' => $this -> appConfig -> charset,
						  'fbAppId' => $this -> fbConfig -> appId,
						  'fbAppSecret' => $this -> fbConfig -> appSecret,
						  'appConfig' => $this -> appConfig];
		
		parent::__construct($initialParams);

		$this -> registerNamespaces();
		$this -> registerProviders();
		$this -> registerTwigLayouts();
		$this -> mountSecurityLayer();
		$this -> mountControllers();
		$this -> boot();
	}
	
	
	public function initConfig()
	{
		include_once(CONF_PATH);
		include_once(DB_CONF_PATH);
		include_once(ROUTE_CONF_PATH);
		
		$this -> appConfig = json_decode(json_encode($appConfig), FALSE);
		$this -> fbConfig = json_decode(json_encode($fbConfig), FALSE);
		$this -> dbConfig = $dbConfig;
		$this -> nsConfig = $nsConfig;
	}
	
	
	public function mountControllers()
	{
#TODO: refactor to routing on annotations
		$this -> mount('/', new App\Controller\Index());
		$this -> mount('/training', new App\Controller\Training());
		$this -> mount('/news', new App\Controller\News());
		$this -> mount('/contact', new App\Controller\Contact());
		$this -> mount('/about', new App\Controller\About());
		$this -> mount('/media', new App\Controller\Media());
		$this -> mount('/login', new App\Controller\Auth());
		$this -> mount('/admin', new App\Controller\Admin\Index());
		$this -> mount('/admin/auth', new App\Controller\Admin\Auth());
		$this -> mount('/admin/event', new App\Controller\Admin\Event());
		$this -> mount('/admin/news', new App\Controller\Admin\News());
		$this -> mount('/admin/training', new App\Controller\Admin\Training());
		$this -> mount('/admin/media', new App\Controller\Admin\Media());
	}
	
	
	public function registerNamespaces()
	{
		if (empty($this -> nsConfig)) {
			throw new \Exception('Namespaces not defined');
			return false;
		}
		
		foreach ($this -> nsConfig as $namespace => $path) {
			$this -> loader -> add($namespace, $path);
		}
	}
	
	public function registerProviders()
	{
		$this -> register(new DoctrineServiceProvider(), ['db.options' => $this -> dbConfig]);
		$this -> register(new FormServiceProvider());
		$this -> register(new ValidatorServiceProvider());
		$this -> register(new ServiceControllerServiceProvider());
		$this -> register(new UrlGeneratorServiceProvider());
		$this -> register(new TwigServiceProvider(), ['twig.path' => APP_PATH . 'View', 'auto_reload' => true]);
		$this -> register(new SessionServiceProvider());
		$this -> register(new SecurityServiceProvider());
		$this -> register(new ActiveRecordProvider(), [
								'ar.model_dir' => APP_PATH . 'Model',
								'ar.connections' =>  [
									'live' => 'mysql://' . $this -> dbConfig['user'] . ':' . $this -> dbConfig['password'] . '@' . $this -> dbConfig['host'] .'/' . $this -> dbConfig['dbname'] . '?charset=utf8' 
								],
								'ar.default_connection' => 'live'
							]); 
		
		$this['twig'] = $this -> share($this -> extend('twig', function($twig, $app) {
			$twig -> addExtension(new Twig_Extensions_Extension_Text($app));
			return $twig;
		}));
	}
	
	
	public function mountSecurityLayer()
	{
		$this['security.firewalls'] = [
			'login' => [
					'pattern' => '^/login$',
			],
			'admin' => [
				'pattern' => '^/admin(/.+)?',
				'form' => ['login_path' => '/login', 
						   'check_path' => '/admin/auth/login_check',
						   'default_target_path' => '/admin',
						   'always_use_default_target_path' => true],
				'logout' => ['logout_path' => '/admin/auth/logout', 'invalidate_session' => true],
				'users' => $this -> share(function() {
                	return new Library\Providers\UserProvider($this['db'], $this);
            	})
			]
		];
            	
		$this['security.access_rules'] = [
			['^/admin(/.+)?', 'ROLE_ADMIN'],
			['^/login', 'IS_AUTHENTICATED_ANONYMOUSLY']
		];
		
		return;
	}
		
	
	public function registerTwigLayouts()
	{
		$this -> before(function () {
			$this['twig'] -> addGlobal('wrapper', $this['twig'] -> loadTemplate('layout/wrapper.twig'));
			$this['twig'] -> addGlobal('stuff', $this['twig'] -> loadTemplate('layout/stuff.twig'));
			$this['twig'] -> addGlobal('header', $this['twig'] -> loadTemplate('layout/header.twig'));
			$this['twig'] -> addGlobal('footer', $this['twig'] -> loadTemplate('layout/footer.twig'));
			$this['twig'] -> addGlobal('sidepanel', $this['twig'] -> loadTemplate('layout/sidepanel.twig'));
			$this['twig'] -> addGlobal('navigation', $this['twig'] -> loadTemplate('layout/navigation.twig'));
			
			$this['twig'] -> addGlobal('admin_wrapper', $this['twig'] -> loadTemplate('protected/layout/wrapper.twig'));
			$this['twig'] -> addGlobal('admin_sidepanel', $this['twig'] -> loadTemplate('protected/layout/sidepanel.twig'));
			$this['twig'] -> addGlobal('admin_notifications', $this['twig'] -> loadTemplate('protected/layout/notifications.twig'));
		});
	}
}
