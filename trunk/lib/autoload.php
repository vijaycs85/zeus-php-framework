<?php
	
	/**
	 * Autoload: inclui uma classe caso ela seja chamada sem existir
	 * @param: class(string), classe a ser incluída
	 * @access: global
	 * @return: void
	 */
	function __autoload($class){
		global $_CLASSES;
		if(array_key_exists($class, $_CLASSES)){
			if(file_exists($_CLASSES[$class])){
				require_once $_CLASSES[$class];
			}else{
				Zeus_Error::raise("Autoload: o arquivo da classe {$class} definido em \$_CLASSES não está correto!");
			}
		}else{
			Zeus_Error::raise("Autoload: a classe {$class} não está definida em \$_CLASSES!");
		}
	}
	
?>