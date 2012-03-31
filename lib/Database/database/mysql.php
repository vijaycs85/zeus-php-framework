<?php

/**
 * Comentário
 */
	
	class mysql{
	
		private
		/*
		 * @_query
		 */
		$_query = '',
		
		/*
		 * @_link : database connection link
		 */
		$_link,
		
		/*
		 * @hostname {string} : database hostname
		 */
		$hostname,
		
		/*
		 * @username {string} : database user name
		 */
		$username,
		
		/*
		 * @password {string} : database user password
		 */
		$password,
		
		/*
		 * @database {string} : database name
		 */
		$database,
		
		/*
		 * @prefix: {array} prefix to tables
		 */
		$prefix = array();
		
		/*
		 * @__construct : constructor method
		 */
		public function __construct($str = ''){
			if($str != ''){
				$this->set('info', $str);
				return $this->connect();
			}
			return $this;
		}
		
		/*
		 * @connect {bool} : method connect with database
		 */
		public function connect(){
			$this->_link = mysql_connect($this->hostname, $this->username, $this->password);
			if($this->_link){
				$select = mysql_select_db($this->database);
				if($select){
					mysql_set_charset('utf8');
					return true;
				}else{
					Zeus_Error::raise(array(
						'message' => mysql_error(),
						'file' => __FILE__,
						'line' => __LINE__
					));
				}
			}else{
				Zeus_Error::raise(array(
					'message' => mysql_error(),
					'file' => __FILE__,
					'line' => __LINE__
				));
			}
			return false;
		}
		
		/*
		 * @disconnect : method close connection with database
		 */
		public function disconnect(){
			return mysql_close($this->_link);
		}
		
		public function setPrefix($prefix){
			if(is_array($prefix)){
				$this->prefix = $prefix;
			}
			return;
		}
		
		public function addPrefix($mask, $prefix){
			if(!isset($this->prefix[$mask])){
				$this->prefix[$mask] = $prefix;
			}
			return;
		}
		
		public function resetPrefix(){
			$this->prefix = array();
		}
		
		public function removePrefix($prefix){
			if(isset($this->prefix[$prefix])){
				unset($this->prefix[$prefix]);
			}
			return;
		}
		
		/*
		 * @set : set configs to database class
		 * @var {string} : setting type
		 * @str {string} : value to setting
		 */
		public function set($var, $str){
			switch($var){
				case 'info':
					$str = explode(';', $str);
					foreach($str as $s){
						$data = explode('=', $s);
						$this->$data[0] = $data[1];
					}
				break;
			}
			return $this;
		}
		
		public function antiInject($str){
			return mysql_escape_string($str);
		}
		
		/*
		 * @setQuery : set a query
		 * @param[0] {string} : string to execute query
		 * @param[1+] {string} : value to properties in query
		 * Query demo: zDatabase::setQuery("SELECT * FROM #__views WHERE name = $1", 'front-end');
		 */
		public function setQuery($q){
			$this->_queryString = $q;
			if(count($this->prefix)){
				foreach($this->prefix as $k => $v){
					$this->_queryString = str_replace($k, $v, $this->_queryString);
				}
			}
			if(func_num_args()){
				for($i = 1; $i < func_num_args(); $i++){
					$this->_queryString = (string) str_replace('[:'.$i.']', $this->antiInject(func_get_arg($i)), $this->_queryString);
				}
			}
			return;
		}
		
		/*
		 * @query {bool} : execute a query seted and prepared in setQuery method
		 */
		public function query(){
			$this->_query = mysql_query($this->_queryString);
			if($this->_query)
				return true;
			Zeus_Error::raise(array(
				'message' => mysql_error($this->_link),
				'line' => __LINE__,
				'file' => __FILE__,
				'datestamp' => date('Y-m-d H:i:s')
			));
			return false;
		}
		
		/*
		 * @getNumRows {int} : return num rows of query method
		 */
		public function getNumRows(){
			return $this->query() ? mysql_num_rows($this->_query) : 0;
		}
		
		/*
		 * @loadObject : return an object with first result to query method
		 */
		public function loadObject(){
			if($this->_query == '')
				$this->query();
			return mysql_fetch_object($this->_query);
		}
		
		/*
		 * @loadObjectList : return an object with all results to query method
		 */
		public function loadObjectList(){
			if($this->_query != '')
				$this->query();
			$obj = array();
			while($var = mysql_fetch_object($this->_query)){
				$obj[] = $var;
			}
			return $obj;
		}
		
	}
	
?>