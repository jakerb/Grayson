<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	namespace App\Console;

	class Console {

		public static function Method() {

		}

		public static function Response($string = String, $success = true, $die = false, $return = false) {
			$prefix = $success ? "\n---> " : "\n--!> ";
			$suffix = "\n" . ($die || !$return ? "\n" : "");

			$string = $prefix . $string . $suffix;;

			if($return) {
				return $string;
			} else {
				echo $string;
			}
			if($die) {
				die();
			}
		}

		public function Error($string = String) {
			self::Response($string, $success = false, $die = true, $return = false);
		}

		public function Prompt($prompt = String) {

			echo self::Response($prompt, $success = true, $die = false, $return = true);
			$handle = fopen ("php://stdin","r");
			$response = fgets($handle);
			return trim($response);
		}

		public static function Export($content = String, $fileName = String, $scope = String) {
			if(file_exists($fileName)) {
				$scope = $scope ? $scope : "File";
				$prompt = strtolower(self::Prompt("$scope exists, do you want to overwrite it? (y/n)"));
				if($prompt !== "y") {
					return self::Response($prompt, $success = false, $die = true);
				}
			}

			return file_put_contents($fileName, $content);
			
			

		}

		public static function Import($variables = Array(), $fileName = String) {
			$prefix = '{{';
			$suffix = '}}';

			$file = file_get_contents("Core/Console/src/templates/$fileName");

			foreach($variables as $index => $var) {
				$file = str_replace(
					array(
						$prefix . $index . $suffix,
						$prefix . '@' . $index . $suffix,
						$prefix . '_' . $index . $suffix,
						$prefix . " $index " . $suffix,
					),
					array(
						$var,
						ucfirst($var),
						strtolower($var),
						$var
					),
					$file
				);
			}

			return $file;
		}

		public function chainResponse($chain = Array()) {
			foreach($chain as $index => $response) {
				self::Response($response['response'], $response['success']);
				if($response['method']) {
					echo $response['method'];
				}
				if(isset($response['sleep'])) {
					usleep($response['sleep'] * 1000000);
				}
			} 
		}

		private static function mapArguments($map = Array(), $args = Array()) {
			$mapCount = 0;
			foreach($map as $index => $counter) {
				if(substr($counter, 0, 1) !== '?') {
					$mapCount++;
				}
			}
			if($mapCount > count($args)) {
				return self::Response('Too few arguments passed. (' . implode(',', $map) . ')', $success = false, $die = true);
			}
			return (object) array_combine($map, array_slice($args, 0, count($map)));
		}

		/*
		 * @info Create Controller
		 */
		private static function __createController($name = String) {
			$name = ucfirst($name);

			self::Export(self::Import(array('route' => $name), "controller.txt"), "Application/Controller/$name.php", "Controller");
			return self::Response("Created Controller for \"$name\".", $success = true, $die = false, $return = true);
		}

		/*
		 * @info Create Model
		 */
		private static function __createModel($name = String) {
			$name = ucfirst($name);

			self::Export(self::Import(array('route' => $name), "model.txt"), "Application/Model/$name.php", "Model");
			return self::Response("Created Model for \"$name\".", $success = true, $die = false, $return = true);
		}

		/*
		 * @info Create Route
		 */
		private static function __createRoute($name = String) {
			$name = ucfirst($name);

			self::Export(self::Import(array('route' => $name), "route.txt"), "Application/Route/$name.php", "Route");
			return self::Response("Created Route for \"$name\".", $success = true, $die = false, $return = true);
		}

		/*
		 * @info Create Migration
		 */
		private static function __createMigration($name = String) {
			$name = ucfirst($name);

			self::Export(self::Import(array('route' => $name), "migration.txt"), "Application/Migration/$name.php", "Migration");
			return self::Response("Created Migration for \"$name\".", $success = true, $die = false, $return = true);
		}

		/*
		 * @info Create View
		 */
		private static function __createView($name = String) {
			$name = strtolower($name);

			self::Export(self::Import(array('route' => $name), "view.txt"), "Application/View/$name.twig", "View");
			return self::Response("Created View for \"$name\".", $success = true, $die = false, $return = true);
		}	

		private static function _MethodList($args = Array()) {
			$directory = scandir("Application/Route/");
			$omit = array('.php', '..', '.', '.DS_Store');
			$count = 0;

			foreach($directory as $index => $route) {
				if(in_array($route, $omit)) { continue; }
				$count++;
				echo self::Response(str_replace($omit, false, $route), $success = true, $die = false, $return = false);
			}

			if(!$count) {
				echo self::Response("You dont have any methods.", $success = false, $die = true, $return = false);
			}

		} 

		private function _MigrationDrop($args = Array()) {
			$args = self::mapArguments(array('methodName'), $args);
			if(strlen($args->methodName) < 1) {
				echo self::Response("Migration not specified.", $success = false, $die = true, $return = false);
			}

			$args->methodName = $method = ucfirst($args->methodName);
			$prompt = self::Prompt("You are about to drop the table for $method, are you sure? (y/n)");
		}

		private function _MigrationRun($args = Array()) {
			$args = self::mapArguments(array('methodName'), $args);
			if(strlen($args->methodName) < 1) {
				echo self::Response("Migration not specified.", $success = false, $die = true, $return = false);
			}

			$args->methodName = $method = ucfirst($args->methodName);
			$prompt = self::Prompt("You are about to create the table for $method which will delete any data already created, are you sure? (y/n)");
		}

		/*
		 * @info Create Method from Method
		 */
		private static function _MethodCreate($args = Array()) {

			$args = self::mapArguments(array('methodName'), $args);
			if(strlen($args->methodName) < 1) {
				echo self::Response("Cannot create Method without a name.", $success = false, $die = true, $return = false);
			}

			$args->methodName = ucfirst($args->methodName);

			self::chainResponse(array(
				array(
					'response' => 'Creating Controller..',
					'success' => true,
					'sleep' => 0.5,
					'method' => self::__createController($args->methodName)
				),
				array(
					'response' => 'Creating Model..',
					'success' => true,
					'sleep' => 0.5,
					'method' => self::__createModel($args->methodName)
				),
				array(
					'response' => 'Creating View..',
					'success' => true,
					'sleep' => 0.5,
					'method' => self::__createView($args->methodName)
				),
				array(
					'response' => 'Creating Route..',
					'success' => true,
					'sleep' => 0.5,
					'method' => self::__createRoute($args->methodName)
				),
				array(
					'response' => 'Creating Migration..',
					'success' => true,
					'sleep' => 0.5,
					'method' => self::__createMigration($args->methodName)
				),
				array(
					'response' => 'Successfully Created Method.',
					'success' => true,
					'die' => true,
					'sleep' => 0.5
				)
			));

		}

		private static function _MethodDelete($args = Array()) {
			$args = self::mapArguments(array('methodName'), $args);
			if(strlen($args->methodName) < 1) {
				echo self::Response("Cannot create Method without a name.", $success = false, $die = true, $return = false);
			}

			$args->methodName = ucfirst($args->methodName);

			$deleted = false;
			$prompt = strtolower(self::Prompt("Are you sure you want to delete \"$args->methodName\"? (y/n)"));
			if($prompt == 'y' || $prompt == 'yes') {
				$name = $args->methodName;
				if(file_exists("Application/Controller/$name.php")) { $deleted = true; unlink("Application/Controller/$name.php"); }
				if(file_exists("Application/Migration/$name.php")) { $deleted = true; unlink("Application/Migration/$name.php"); }
				if(file_exists("Application/Model/$name.php")) { $deleted = true; unlink("Application/Model/$name.php"); }
				if(file_exists("Application/Route/$name.php")) { $deleted = true; unlink("Application/Route/$name.php"); }
				if(file_exists("Application/View/$name.twig")) { $deleted = true; unlink("Application/View/$name.twig"); }

				if($deleted) {
					echo self::Response("Deleted Method \"$name\".", $success = true, $die = true);
				} else {
					echo self::Response("Could not find Method \"$name\".", $success = false, $die = true);
				}
			}

		}

		/*
		 * @info Combine argument to call methods
		 */
		public static function Execute($args = Array()) {
			$userFunction = '_';

			foreach($args as $index => $arg) {
				$userFunction .= ucfirst($arg);
				if(method_exists(get_called_class(), $userFunction)) {
					return self::$userFunction(array_slice($args, ($index+1), count($args)));
				}
			}

			return self::Response("Command not found!", $success = false, $die = true);


		} 

	}

?>