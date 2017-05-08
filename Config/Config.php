<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	//Set Twig
	$loader->view = new Twig_Environment(new Twig_Loader_Filesystem('Application/View/'));


	//Set Config
	$loader->config->add(array(
		'app' => $loader,
		'settings' => [
	        'displayErrorDetails' => true
	    ]
	));