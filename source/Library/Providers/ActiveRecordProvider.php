<?php

namespace Library\Providers;

use Silex\Application,
	Silex\ServiceProviderInterface;

class ActiveRecordProvider implements ServiceProviderInterface
{
	public $app;
	
    function register(Application $app){
        $this -> app = $app;

        $app['ar.init'] = $this -> app -> share(function (Application $app) {
            \ActiveRecord\Config::initialize(function ($cfg) use ($app) {
                $cfg -> set_model_directory($app['ar.model_dir']);
                $cfg -> set_connections($app['ar.connections']);
                $cfg -> set_default_connection($app['ar.default_connection']);
            });
        });
    }

    function boot(Application $app){
        $this -> app['ar.init'];
    }
}