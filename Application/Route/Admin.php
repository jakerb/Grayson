<?php

	/*
	 * View
	 */

	$app->get('/admin', function($request, $response, $args) {
		$app = $this->get('app');
		return $app->admin->render(
			'Layout/dashboard.twig', 
			array(
				'modules' => $this->get('app')->model->admin->getModules()
			)
		);
	});
	

	/*
	 * RESTful Endpoints
	 */
	$app->group('/admin', function() {

		$this->get('/get', function ($request, $response, $args) {  
			$app = $this->get('app');
			$response->withJson($app->controller->admin->_invoke($app)->Get($request));
			return $response;  
		})->setName('admin-get');

		$this->post('/update', function ($request, $response, $args) { 
			$app = $this->get('app'); 
			$response->withJson($app->controller->admin->_invoke($app)->Update($request));
			return $response;  
		})->setName('admin-update');

		$this->post('/put', function ($request, $response, $args) { 
			$app = $this->get('app'); 
			$response->withJson($app->controller->admin->_invoke($app)->Put($request));
			return $response;  
		})->setName('admin-put');

		$this->post('/delete', function ($request, $response, $args) {
			$app = $this->get('app');  
			$response->withJson($app->controller->admin->_invoke($app)->Delete($request));
			return $response;  
		})->setName('admin-delete');

	});

	/* End of Route */

?>