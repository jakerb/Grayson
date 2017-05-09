<?php

	/*
	 * @name 	Grayson
	 * @author 	Jake Bown <jakebown@gmail.com>
	 * @version 1.0.0
	 */

	class Migration {
	
		public function add($table = String, $data = Array()) {
			if(!isset($loader->migration)) {
				$loader->migration = array();
			}

			$loader->migration[$table] = $data();
		}
	
	}