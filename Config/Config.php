<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	//Set Twig
	$loader->view = new Twig_Environment(new Twig_Loader_Filesystem('Application/View/'));

	//Set Admin Twig
	$loader->admin = new Twig_Environment(new Twig_Loader_Filesystem('Plugins/Admin/'));

	//Set Config
	$loader->config->add(array(
		'app' => $loader,
		'production_mode' => false,
		'grayson' => [
			'version' => '1.0.2'
		],
		'settings' => [
	        'displayErrorDetails' => true
	    ]
	));