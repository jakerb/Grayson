<?php

	class AdminController {

		function __construct() {
			return $this;
		}

		function __destruct() {

		}

		public function _invoke($app = false) {
			$this->app = $app;
			return $this;
		}

		public function Post($parameters = array()) {
			return $this->app->model->admin->Post($parameters);
		}

		public function Get($parameters = array()) {
			return $this->app->model->admin->Get($parameters);
		}

		public function Put($parameters = array()) {
			return $this->app->model->admin->Put($parameters);
		}

		public function Delete($parameters = array()) {
			return $this->app->model->admin->Delete($parameters);
		}



	}