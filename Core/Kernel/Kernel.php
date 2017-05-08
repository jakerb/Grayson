<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	namespace App\Kernel;

	class Kernel {

		public static function loadRoutes() {
			$types = array(
				'Route'
			);

			$routes = array();

			foreach($types as $i => $scope) {
				foreach(glob("Application/$scope/*.php") as $index => $filename) {
					$routes[] = $filename;
				}
			}

			return $routes;
		}

		public static function loadMethods() {

			$types = array(
				'Controller',
				'Model',
				'Helper'
			);

			$Scope = (object) array();

			foreach($types as $i => $scope) {
				foreach(glob("Application/$scope/*.php") as $index => $filename) {
					preg_match_all("/\/([A-Z].*).php/", $filename, $find);
					if(isset($find[1][0])) {

						$find = explode('/', $find[1][0]);
						$assign = ucfirst($find[0]);
						$_assign = strtolower($assign);
						$name = ucfirst($find[1]);
						$_name = strtolower($name);

						require $filename;

						if(!isset($Scope->$_assign)) {
							$Scope->$_assign = (object) array();
						} 

						$class = strtolower($name) .($assign !== 'Helper' ? $assign : '');


						if(class_exists($class)) {
							$Scope->$_assign->$_name = new $class();
						}
					}
				}
			}

			$Scope->routes = self::loadRoutes();

			return (array) $Scope;
		}
	}