<?php

	require 'vendor/autoload.php';
	require 'Bootstrap/Bootstrap.php';
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	use App\Kernel as Kernel;

	$loader = new Grayson(Kernel\Kernel::loadMethods());

	require 'Config/Config.php';

	$app = new \Slim\App($loader->config->config);

	//Load Routes
	foreach($loader->routes as $route) { require $route; }

	$app->run();

?>