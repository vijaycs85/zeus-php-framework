<?php

/**
 * Comentário
 */
	
	class Zeus_Error{
		
		public static
		
		/**
		 * Array que armazena os erros
		 * @access: public
		 */
		$error = array(),
		
		/**
		 * Informações padrões
		 * @access: public
		 */
		$defaults = array(
			'line' => '',
			'file' => '',
			'message' => '',
			'datestamp' => ''
		);
		
		/**
		 * Raise: adiciona uma nova mensagem de erro
		 * @param: error(mixed), mensagem de erro ou array assossiativo contendo as configurações da mensagem de erro
		 * @access: public
		 * @return: void
		 */
		public static function raise($error){
			if(!is_array($error)){
				self::$error[] = Zeus_Array::merge(self::$defaults, array('message' => $error));
			}else{
				self::$error[] = Zeus_Array::merge(self::$defaults, $error);
			}
			Zeus_Event::execute('error.raise');
			return;
		}
		
		/**
		 * Get Errors: retorna o array com todas as mensagens de erro geradas até o momento
		 * @access: public
		 * @return: array
		 */
		public static function getErrors(){
			return self::$error;
		}
		
		/**
		 * Get String: retorna uma lista(ul, li) contendo as mensagens de erro e suas configurações
		 * @access: public
		 * @return: string
		 */
		public static function getString(){
			$str = '<ul>';
			foreach(self::$error as $e){
				$str .= "
					<li>
						<span data-type=\"{$e['type']}\" class=\"type\">
							{$e['type']}
						</span>
						<span data-datestamp=\"{$e['datestamp']}\" class=\"datestamp\">
							{$e['datestamp']}
						</span>
						<span data-message=\"{$e['message']}\" class=\"message\">
							{$e['message']}
						</span>
						<span data-file=\"{$e['file']}\" class=\"file\">
							{$e['file']}
						</span>
						<span data-line=\"{$e['line']}\" class=\"line\">
							{$e['line']}
						</span>
					</li>
				";
			}
			$str .= '</ul>';
			return $str;
		}
		
		/**
		 * Get Log: retorna uma string contendo as mensagens de erro em forma de log, pronto para ser adicionado em um arquivo .log
		 * @access: public
		 * @return: string
		 */
		public static function getLog(){
			$log = '';
			foreach(self::$error as $e){
				$log .= "{$e['type']} [{$e['datestamp']}] - {$e['message']} in {$e['file']} on line {$e['line']}\n";
			}
			return $log;
		}
		
	}
	
?>