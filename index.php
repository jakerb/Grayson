<?php

	require 'vendor/autoload.php';
	require 'Bootstrap/Bootstrap.php';

	use App\Kernel as Kernel;

	$loader = new Grayson(Kernel\Kernel::loadMethods());

	require 'Config/Config.php';

	$app = new \Slim\App($loader->config->config);

	//Load Routes
	foreach($loader->routes as $route) { require $route; }

	$app->run();

?>