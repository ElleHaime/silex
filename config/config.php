<?php

$appConfig = [
	'debug' => true,
	'locale' => 'en',
	'charset' => 'UTF-8',
	'logfile' => ROOT_PATH . 'logs/main.log',
	'orm_proxy_dir' => ROOT_PATH . 'var/orm',
	
	'upload' => [
		'mediaPath' => IMG_PATH . 'media/',
		'eventPath' => IMG_PATH . 'event/',
		'sliderPath' => IMG_PATH . 'slider/',
		'trainingPath' => IMG_PATH . 'training/',
		'newsPath' => IMG_PATH . 'news/',
		'tempPath' => IMG_PATH . 'temp/',
	],

	'webUrl' => [
		'trainingPath' => '/img/training/',
		'mediaPath' => '/img/media/',
		'eventPath' => '/img/event/',
		'sliderPath' => '/img/slider/',
		'newsPath' => '/img/news/'
	]
];