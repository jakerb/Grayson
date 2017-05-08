<?php

	/*
	 * View
	 */

	$app->get('/test', function($request, $response, $args) {
		return $this->get('app')->view->render('test.twig');
	});
	

	/*
	 * RESTful Endpoints
	 */
	$app->group('/test', function() {

		$this->get('/get', function ($request, $response, $args) { 
			$app = $this->get('app'); 
			return $app->controller->test->_invoke($app)->Get($request);  
		})->setName('test-get');

		$this->post('/update', function ($request, $response, $args) { 
			$app = $this->get('app'); 
			return $app->controller->test->_invoke($app)->Update($request);  
		})->setName('test-update');

		$this->post('/put', function ($request, $response, $args) { 
			$app = $this->get('app'); 
			return $app->controller->test->_invoke($app)->Put($request);  
		})->setName('test-put');

		$this->post('/delete', function ($request, $response, $args) {  
			$app = $this->get('app');
			return $app->controller->test->_invoke($app)->Delete($request);  
		})->setName('test-delete');

	});

?>