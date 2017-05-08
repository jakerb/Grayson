<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	class Grayson {

		function __construct($loader = Array()) {

			foreach($loader as $namespace => $object) {
				if($namespace == 'helper') {
					foreach(array_filter(array_keys((array) $object)) as $index => $helper) {
						$this->$helper = $loader[$namespace]->$helper;
					}
				}

				$this->$namespace = $object;
				
			}

		}	

	}