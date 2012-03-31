<?php

/**
 * Comentário
 */
	
	class Zeus_Event{
		public static $events = array();
		
		/**
		 * execute
		 * Executa um evento
		 * @evt: {string} evento a ser executado
		 */
		public static function execute($evt){
			if(isset(self::$events[$evt])){
				foreach(self::$events[$evt] as $e){
					$params = array();
					for($i = 1; $i < count($e); $i++){
						$params[] = $e[$i];
					}
					call_user_func_array($e[0], $params);
				}
			}
			return;
		}
		
		/**
		 * addEvent
		 * Adiciona um evento
		 * @evt: {string} evento no qual a função @fn será executada
		 * @fn: {string} função a ser executada no evento @evt
		 * [@params: {string} parametros que serão passados à função @fn]
		 */
		public static function addEvent($evt, $fn){
			if(!isset(self::$events[$evt])){
				self::$events[$evt] = array();
			}
			$fn = array($fn);
			if(func_num_args() > 2){
				for($i = 2; $i < func_num_args(); $i++){
					$fn[] = func_get_arg($i);
				}
			}
			self::$events[$evt][] = $fn;
			return;
		}
		
		/**
		 * removeEvent
		 * Remove um evento
		 * @evt: {string} evento a ser removido
		 */
		public static function removeEvent($evt){
			if(isset(self::$events[$evt])){
				unset(self::$events[$evt]);
			}
			return;
		}
	}
	
?>