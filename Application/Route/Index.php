<?php

	/*
	 * Index
	 */

	$app->get('/', function($request, $response, $args) {
		return $this->get('app')->view->render('index.twig', array('mode' => $this->production_mode, 'grayson' => $this->grayson));
	});
	
	/* End of Route */	

?>