<?php
	
	abstract class Zeus_Class{
		
		private
		
		/**
		 * Classes que estão sendo extendidas
		 * @access: private
		 */
		$_extends = array();
		
		/**
		 * Extend: Extende uma nova classe
		 * @param: obj(object), instancia da classe a ser extendida
		 * @access: public
		 * @return: void
		 */
		public function extend($obj){
			if(!in_array($obj, $this->_extends)){
				$this->_extends[] = $obj;
			}
			return;
		}
		
		/**
		 * __call: Quando a classe filha chama um método que não a pertence,
		 * 		   faz uma busca nas classes extendidas e retorna o primeiro método
		 *		   com o mesmo nome do que o que foi chamado
		 * @param: method(string), metodo que será aplicado
		 * @param: params(array), parametros a serem passados ao método
		 * @access: public
		 * @return: object
		 */
		public function __call($method, $params){
			foreach($this->_extends as $ext){
				if(method_exists($ext, $method)){
					return call_user_func_array(array($ext, $method),$params);
				}
			}
			return;
		}
		
		/*
		 * __get: Quando a classe filha chama uma propriedade que não a pertence,
		 * 		  faz uma busca nas classes extendidas e retorna a primeira propriedade
		 *		  com o mesmo nome do que a que foi chamada. Semelhante ao __call
		 * @param: var(string), propriedade está sendo chamada
		 * @access: public
		 * @return: mixed
		 */
		public function __get($var){
			foreach($this->_extends as $ext){
				if(property_exists($ext,$var)){
					return $ext->$var;
				}
			}
			return;
		}
		
	}
	
?>