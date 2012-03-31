<?php

/**
 * Comentário
 */
	
	class Zeus_Document{
		public static
		
		/**
		 * Title: Título da página
		 * @access: public
		 */
		$title = '',
		
		/**
		 * Component: HTML do componente
		 * @access: public
		 */
		$component = '',
		
		/**
		 * Message: mensagens geradas pelo componente
		 * @access: public
		 */
		$message = array('type' => '', 'text' => ''),
		
		/**
		 * Header: HTML dentro de <head></head>
		 * @access: public
		 */
		$header = '',
		
		/**
		 * Toolbar: barra de ferramentas do administrador
		 * @access: public
		 */
		$toolbar = '';
		
		/**
		 * setToolbar
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function setToolbar($str){
			self::$toolbar = $str;
			return;
		}
		
		/**
		 * addToToolbar
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function addToToolbar($str){
			self::$toolbar .= $str;
			return;
		}
		
		/**
		 * getToolbar
		 * @access: public
		 * @return: string
		 */
		public static function getToolbar(){
			return self::$toolbar;
		}
		
		/**
		 * setTitle
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function setTitle($str){
			self::$title = $str;
			return;
		}
		
		/**
		 * addToTitle
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function addToTitle($str){
			self::$title .= $str;
			return;
		}
		
		/**
		 * getTitle
		 * @access: public
		 * @return: string
		 */
		public static function getTitle(){
			return self::$title;
		}
		
		/**
		 * setHeader
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function setHeader($str){
			self::$header = $str;
			return;
		}
		
		/**
		 * addToHeader
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function addToHeader($str){
			self::$header .= $str;
			return;
		}
		
		/**
		 * getHeader
		 * @access: public
		 * @return: string
		 */
		public static function getHeader(){
			return self::$header;
		}
		
		/**
		 * setComponent
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function setComponent($str){
			self::$component = $str;
			return;
		}
		
		/**
		 * addToComponent
		 * @param: str(string)
		 * @access: public
		 * @return: void
		 */
		public static function addToComponent($str){
			self::$component .= $str;
			return;
		}
		
		/**
		 * getComponent
		 * @access: public
		 * @return: string
		 */
		public static function getComponent(){
			return self::$component;
		}
		
		/**
		 * setMessage
		 * @param: str(string)
		 * @param: var(string)
		 * @access: public
		 * @return: void
		 */
		public static function setMessage($str, $var = 'text'){
			self::$message[$var] = $str;
			return;
		}
		
		/**
		 * addToMessage
		 * @param: str(string)
		 * @param: var(string)
		 * @access: public
		 * @return: void
		 */
		public static function addToMessage($str, $var = 'text'){
			self::$message[$var] .= $str;
			return;
		}
		
		/**
		 * getMessage
		 * @param: var(string)
		 * @access: public
		 * @return: void
		 */
		public static function getMessage($var = 'text'){
			return self::$message[$var];
		}
		
		/**
		 * addScript
		 * @param: str(string), url, codigo javascript ou código javascript dentro da tag script
		 * @access: public
		 * @return: void
		 */
		public static function addScript($str){
			if(preg_match('/^(https?\:\/\/)/i', $str)){
				self::addToHeader("<script type=\"text/javascript\" src=\"{$str}\"></script>");
			}else if(preg_match('/^(<script)(<\/script>)$/i', $str)){
				self::addToHeader($str);
			}else{
				self::addToHeader("<script type=\"text/javascript\">{$str}</script>");
			}
			return;
		}
		
		/**
		 * addStyle
		 * @param: str(string), url, codigo css ou código css dentro da tag script
		 * @access: public
		 * @return: void
		 */
		public static function addStyle($str){
			if(preg_match('/^(https?\:\/\/)/i', $str)){
				self::addToHeader("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$str}\" />");
			}else if(preg_match('/^(<style|<link)(<\/style>|\/>|>)$/i', $str)){
				self::addToHeader($str);
			}else{
				self::addToHeader("<style type=\"text/css\">{$str}</style>");
			}
			return;
		}
		
	}
	
?>