<?php

/**
 * Comentário
 */
	
	!class_exists('Zeus_Error') ? import('Error') : '';
	
	/**
	 * Import:    importa arquivos do framework, semelhande ao import do Java
	 *
	 * @param:    file(string), Arquivo a ser importado.
	 *		      Caso este arquivo esteja dentro de um diretório em /lib/,
	 *		      Este diretório deverá ser separado por '.' no lugar de '/'
	 *		      E caso queira incluir todos os arquivos de um diretório,
	 *		      deve-se seguir o exemplo: import('Dir.*')
	 *
	 * @exemplos: para um arquivo no diretório base do framework(lib): import('File');
	 *			  para um arquivo em um subdiretório : import('Dir.File')
	 *			  para todos os arquivos de um subdiretorio: import('Dir.*')
	 *
	 * @access:   global
	 * @return:   void
	 */
	function import($file, $base = ''){
		$base = $base == '' ? BASE_PATH.DS.'lib'.DS : $base;
		if(is_array($file)){
			foreach($file as $f){
				import($f, $base);
			}
		}else{
			$pts = explode('.', $file);
			if($pts[count($pts)-1] == '*'){
				$base = $base.DS;
				for($i = 0; $i < count($pts)-1; $i++){
					$base .= $pts[$i];
				}
				!class_exists('Zeus_Dir') ? import('Files.Dir') : '';
				$_file = Zeus_Dir::listFiles($base, true, false);
				foreach($_file as $f){
					if(is_dir($f)){
						import('*', $f);
					}else if(file_exists($f) && !is_dir($f)){
						require_once $f;
					}else{
						Zeus_Error::raise("Import: O aqruivo {$f} não existe!");
					}
				}
			}else{
				$f = $base;
				for($i = 0; $i < count($pts); $i++){
					$f .= DS.$pts[$i];
				}
				if(is_dir($f)){
					import($file.'.*');
				}else if(file_exists($f.'.php')){
					require_once $f.'.php';
				}else{
					Zeus_Error::raise("Import: O aruivo {$f}.php não existe!");
				}
			}
		}
	}
	
?>