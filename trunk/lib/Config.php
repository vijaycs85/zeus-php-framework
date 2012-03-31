<?php

/**
 * Comentário
 */

	class Zeus_Config{
		public $database = array(),
			   $site = array();
		
		public function __construct(){
			require BASE_PATH.DS.'configuration.php';
			$this->database = Zeus_Array::merge(array(
				'hostname' => 'localhost',
				'username' => 'root',
				'password' => '',
				'db_type' => 'mysql'
			), $database);
			$this->site = Zeus_Array::merge(array(
				'baseurl' => 'http://localhost/',
				'sitename' => 'Zeus Ecommerce'
			), $site);
		}
	}
	
?>