<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	class Config {

		function __construct() {
			$this->config = array();
		}

		public function add($parameters) {
			if(!empty($this->config)) {
				foreach($parameters as $index => $object) {
					$this->config[$index] = $object;
				}
			} else {
				$this->config = $parameters;
			}
			
		}

	}