<?php

	class AdminModel {

		function __construct() {
			return $this;
		}

		function __destruct() {
		
		}

		public function getModules() {
			$ignore = array('.', '..', '.DS_Store');
			$modules = array();

			foreach(scandir("Plugins/Admin/Modules") as $index => $module) {
				if(!in_array($module, $ignore)) {
					$modules[] = $module;
				}
			}

			return $modules;
		}

		public function Update($parameters = array()) {
			return $parameters;
		}

		public function Get($parameters = array()) {
			return $parameters;
		}

		public function Put($parameters = array()) {
			return $parameters;
		}

		public function Delete($parameters = array()) {
			return $parameters;
		}



	}