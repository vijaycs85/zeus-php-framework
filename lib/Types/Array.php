<?php
	
	class Zeus_Array{
		/**
		 * Merge: agrupa dois arrays
		 * @param: default(array), base para a combinação
		 * @param: customs(array), valores a serem modificados em default
		 * @access: public
		 * @return: array
		 */
		public static function merge($defaults, $customs){
			if(is_array($defaults) && is_array($customs)){
				foreach($customs as $k => $v){
					$defaults[$k] = $v;
				}
			}
			return $defaults;
		}
		
		/**
		 * To object: transforma um array em objeto
		 * @param: arr(array), array a ser transformado em objeto
		 * @access: public
		 * @return: object
		 */
		public static function toObject($arr){
			$obj = $arr;
			if(is_array($arr)){
				$obj = new stdClass();
				foreach($arr as $k => $v){
					$obj->$k = is_array($v) ? self::toObject($v) : $v;
				}
			}
			return $obj;
		}
	}
	
?>