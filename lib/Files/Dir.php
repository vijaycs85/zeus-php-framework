<?php

/**
 * Comentário
 */
	
	class Zeus_Dir{
		public static function listFiles($dir, $recursive = false, $multidimension = false, $files = array()){
			if(!file_exists($dir))
				return false;
			$ff = scandir($dir);
			if($recursive){
				foreach($ff as $f){
					if(is_dir($dir.DS.$f) && $f != '.' && $f != '..'){
						$files = self::listFiles($dir.DS.$f, $recursive, $multidimension, $files);
					}else if($f != '.' && $f != '..'){
						$files[] = $dir.DS.$f;
					}
				}
			}else{
				foreach($ff as $f){
					$files[] = $dir.DS.$f;
				}
			}
			return $files;
		}
		
		public static function create($dir, $m = 0755){
			return mkdir($dir, $m, true);
		}
		
		public static function remove($dir){
			chmod($dir, 0777);
			if(count(scandir($dir))){
				foreach(scandir($dir) as $file){
					if($file != '.' && $file != '..'){
						if(is_file($dir.DS.$file)){
							unlink($dir.DS.$file);
						}else if(is_dir($dir.DS.$file)){
							self::remove($dir.DS.$file);
						}
					}
				}
			}
			return rmdir($dir);
		}
		
		public static function move($from, $to){
			return rename($from, $to);
		}
	}
	
?>