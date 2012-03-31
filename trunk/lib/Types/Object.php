<?php
	
	class Zeus_Object{
		/**
		 * Merge: agrupa dois objetos
		 * @param: default(object), base para a combinação
		 * @param: customs(object), valores a serem modificados em default
		 * @access: public
		 * @return: array
		 */
		public static function merge($defaults, $customs){
			if(is_object($defaults) && is_object($customs)){
				foreach($customs as $k => $v){
					$defaults->$k = $v;
				}
			}
			return $defaults;
		}
		
		/**
		 * To object: transforma um object em array
		 * @param: obj(object), object a ser transformado em array
		 * @access: public
		 * @return: object
		 */
		public static function toArray($obj){
			$arr = $obj;
			if(is_object($obj)){
				$arr = array();
				foreach($obj as $k => $v){
					$arr[$k] = is_object($v) ? self::toArray($v) : $v;
				}
			}
			return $arr;
		}
	}
	
?>