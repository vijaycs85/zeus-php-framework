<?php
	
	class Zeus_String{
		public static function noAccent($str){
			$com = array(
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�'
			);
			$sem = array(
				'a', 'a', 'a', 'a', 'a',
				'A', 'A', 'A', 'A', 'A',
				'e', 'e', 'e', 'e',
				'E', 'E', 'E', 'E',
				'i', 'i', 'i', 'i',
				'I', 'I', 'I', 'I',
				'o', 'o', 'o', 'o', 'o',
				'O', 'O', 'O', 'O', 'O',
				'u', 'u', 'u', 'u',
				'U', 'U', 'U', 'U',
				'c', 'C'
			);
			return str_replace($com, $sem, $str);
		}
		
		public static function noIAccent($str){
			$com = array(
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�',
				'�', '�', '�', '�', '�',
				'�', '�', '�', '�',
				'�'
			);
			$sem = array(
				'a', 'a', 'a', 'a', 'a',
				'e', 'e', 'e', 'e',
				'i', 'i', 'i', 'i',
				'o', 'o', 'o', 'o', 'o',
				'u', 'u', 'u', 'u',
				'c'
			);
			return str_ireplace($com, $sem, $str);
		}
		
		public static function toAlias($str){
			$de = array(
				'+', '\\', "/", ' ', '_'
			);
			$para = array(
				'-', '-', '-', '-', '-'
			);
			$str = str_replace($de, $para, strtolower(Zeus_String::noIAccent($str)));
			$str = preg_replace('/[^a-z0-9\-]/i', '', $str);
			return $str;
		}
		
		public static function isMail($str){
			return is_string($str) && preg_match('/^[a-zA-Z0-9\-_\.]{3,}\@[a-zA-Z0-9\-_\.]{2,}[a-zA-Z0-9]{1,4}$/i', $str)
		}
	}
	
?>