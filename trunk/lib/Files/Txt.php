<?php

/**
 * Comentário
 */
	
	class Zeus_Txt extends Zeus_File{
		
		protected $op;
		
		public function open($p){
			$this->op = fopen($this->file, $p);
			return $this->op;
		}
		
		public function write($str){
			return fwrite($this->op, $str);
		}
		
		public function close(){
			return fclose($this->op);
		}
		
	}
	
?>