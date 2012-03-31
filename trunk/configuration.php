<?php
	if($_SERVER['HTTP_HOST'] == 'zeus' || $_SERVER['HTTP_HOST'] == 'estaleiro.4v.com.br'){
		// configurações quatro ventos
		$database = array(
			'hostname' => 'localhost',
			'username' => 'www',
			'password' => '123456',
			'database' => 'zeus_fw',
			'db_type' => 'mysql',
			'prefix_tables' => 'zeus_'
		);
		$site = array(
			'baseurl' => 'http://zeus/vinicius/zeus_cms/',
			'sitename' => 'Blog'
		);
	}else if($_SERVER['HTTP_HOST'] == 'localhost'){
		// configurações casa
		$database = array(
			'hostname' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'zeus_fw',
			'db_type' => 'mysql',
			'prefix_tables' => 'zeus_'
		);
		$site = array(
			'baseurl' => 'http://localhost/zeus_cms/',
			'sitename' => 'Blog'
		);
	}
?>