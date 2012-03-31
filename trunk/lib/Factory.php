<?php

	class Zeus_Factory{
		public static
		
		/**
		 * Instances: guarda instancias de classes para evitar multiplas chamadas de uma mesma classe
		 * @access: public
		 */
		$instances = array();
		
		/**
		 * Get DBO: retorna a instancia da classe Zeus_Database
		 * @access: public
		 * @return: object
		 */
		public static function getDBO(){
			if(!isset(self::$instances['database'])){
				$c = self::getConfig('database');
				self::$instances['database'] = new Zeus_Database("{$c['db_type']}:hostname={$c['hostname']};username={$c['username']};password={$c['password']};database={$c['database']}");
				$db = self::$instances['database']->addPrefix('#__', $c['prefix_tables']);
			}
			return self::$instances['database'];
		}
		
		/**
		 * Get Config: Retorna todas as configurações, ou no caso de @str ter sido informado,
		 *			   retorna as propriedades correspondentes a @str
		 * @param: str(string), especifica um tipo de configuração a ser retornado
		 * @access: public
		 * @return: mixed
		 */
		public static function getConfig($str = ''){
			if(!isset(self::$instances['config']))
				self::$instances['config'] = new Zeus_Config();
			$config = self::$instances['config'];
			if($str != '')
				return $config->$str;
			return $config;
		}
		
		public static function getMailer(){
			if(!isset(self::$instances['mailer']))
				self::$instances['mailer'] = new Zeus_Mailer();
			return self::$instances['mailer'];
		}
	}
	
?>