<?php

error_reporting(E_ALL & ~E_NOTICE);


if (!defined('ROOT_PATH')) {
	define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');
}
if (!defined('VENDOR_PATH')) {
	define('VENDOR_PATH', ROOT_PATH . 'vendor/');
}
if (!defined('APP_PATH')) {
	define('APP_PATH', ROOT_PATH . 'source/App/');
}
if (!defined('LIB_PATH')) {
	define('LIB_PATH', ROOT_PATH . 'source/Library/');
}
if (!defined('IMG_PATH')) {
	define('IMG_PATH', ROOT_PATH . 'web/img/');
}
if (!defined('CONF_PATH')) {
	define('CONF_PATH', ROOT_PATH . 'config/config.php');
}
if (!defined('DB_CONF_PATH')) {
	define('DB_CONF_PATH', ROOT_PATH . 'config/database.php');
}
if (!defined('ROUTE_CONF_PATH')) {
	define('ROUTE_CONF_PATH', ROOT_PATH . 'config/routing.php');
}

$loader = require_once VENDOR_PATH . 'autoload.php';
require_once LIB_PATH . 'Db/ActiveRecord/ActiveRecord.php';
require_once LIB_PATH . 'Application.php';

try {
	$app = new Application(['loader' => $loader]);
	$app -> run();
} catch (Exception $e) {
	throw $e;
}