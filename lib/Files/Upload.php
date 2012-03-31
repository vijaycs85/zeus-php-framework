<?php

/**
 * Comentário
 */
	
	class Zeus_Upload{
		
		private $extensions = array(),
				$maxSize,
				$baseDir = 'uploads',
				$files = array();
		
		public function __construct($files){
			if(is_array($files['name'])){
				for($i = 0; $i < count($files['name']); $i++){
					$this->files[$i]['name'] = $files['name'][$i];
					$this->files[$i]['type'] = $files['type'][$i];
					$this->files[$i]['tmp_name'] = $files['tmp_name'][$i];
					$this->files[$i]['error'] = $files['error'][$i];
					$this->files[$i]['size'] = $files['size'][$i];
				}
			}else{
				$this->files[] = $files;
			}
			return;
		}
		
		public function upload(){
			$names = array();
			foreach($this->files as $file){
				if(!$this->isValid($file)){
					Zeus_Error::raise("zUpload::upload(): Arquivo inválido {$file['name']}!");
				}else{
					$file['name'] = $this->toValidName($file['name']);
					$prefix = '';
					while(file_exists($this->baseDir.DS.$prefix.$file['name'])){
						$prefix .= rand(0, 9);
					}
					if(move_uploaded_file($file['tmp_name'], $this->baseDir.DS.$prefix.$file['name'])){
						$names[] = $file['name'];
					}else{
						Zeus_Error::raise("Upload::upload(): Erro ao fazer upload de {$file['name']}!");
					}
				}
			}
			return $names;
		}
		
		public function isValid($file){
			if($file['size'] > 2097152 || $file['error'] || (count($this->extensions) > 0 && !in_array($file['type'], $this->extensions))){
				return false;
			}
			return true;
		}
		
		public function toValidName($old){
			import('functions.toFileName');
			return toFileName($old);
		}
		
		public function addExtension($ext){
			if(is_array($ext)){
				foreach($ext as $e){
					$this->addExtension($e);
				}
			}else{
				$this->extensions[] = $ext;
			}
			return;
		}
		
		public function resetExtension(){
			$this->extensions = array();
			return;
		}
		
		public function setMaxSize($size){
			$this->maxSize = $size;
			return;
		}
		
		public function setBaseDir($dir){
			$this->baseDir = $dir;
			return;
		}
		
		
		
	}
	
?>