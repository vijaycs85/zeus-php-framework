<?php

/**
 * Comentário
 */
	
	class Zeus_Database extends Zeus_Class{
		
		public function __construct($str){
			$exp = explode(':', $str);
			$database = $exp[0];
			import('Database.database.'.$database);
			$this->extend(new $database($exp[1]));
			return;
		}
		
	}
	
?>