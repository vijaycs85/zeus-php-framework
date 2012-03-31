<?php

/**
 * Comentário
 */
	
	class Zeus_Zip{
		public static function compress(){
			
		}
		
		public static function uncompress($dir, $file){
			$zip = new ZipArchive();
			$zip->open($file);
			$zip->extractTo($dir);
			$zip->close();
			return;
		}
	}
	
?>