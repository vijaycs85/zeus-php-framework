<?php

/**
 * Comentário
 */
	
	class Zeus_Request{
		/**
		 * Get var: pega uma variável global de forma segura
		 * @param: var(string), indice a ser pego
		 * @param: default(mixed), valor padrão caso o indice não exista
		 * @param: method(string), metodo para pegar @var
		 * @param: type(string), tipo de variável a ser retornado
		 * @access: public
		 * @return: mixed
		 */
		public static function getVar($var, $default = '', $method = 'request', $type = ''){
			$get;
			switch(strtolower($method)){
				case 'post':
					$get = $_POST;
				break;
				case 'get':
					$get = $_GET;
				break;
				case 'request':
					$get = $_REQUEST;
				break;
				case 'cookie':
					$get = $_COOKIE;
				break;
				case 'session':
					$get = $_SESSION;
				break;
			}
			switch($type){
				case 'string':
					return isset($get[$var]) ? addslashes((string) $get[$var]) : $default;
				break;
				case 'int':
					return isset($get[$var]) ? (int) $get[$var] : $default;
				break;
				case 'double':
					return isset($get[$var]) ? (double) $get[$var] : $default;
				break;
				case 'float':
					return isset($get[$var]) ? (float) $get[$var] : $default;
				break;
				case 'bool':
					return isset($get[$var]) ? (bool) $get[$var] : $default;
				break;
				case 'array':
					return isset($get[$var]) ? (array) $get[$var] : $default;
				break;
				default:
					return isset($get[$var]) ? $get[$var] : $default;
				break;
			}
			return false;
		}
	}
	
?>