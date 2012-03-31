<?php

/**
 * Comentário
 */
	
	abstract class Zeus_File{
		protected
		
		/**
		 * Files: array com os arquivos a serem tratados na classe
		 * @access: protected
		 */
		$files = array(),
		
		/**
		 * Configuration: configurações da classe
		 * @access: protected
		 */
		$configuration = array(
			/**
			 * tamanho máximo de arquivos que a classe poderá tratar
			 * 0 = ilimitado
			 */
			'maxSize' => 0,
			/**
			 * Extenções com quais a classe poderá trabalhar
			 * Null = todas as extenções
			 */
			'extensions' => null
		);
		
		/**
		 * __construct: Construtor
		 * @param: url(mixed), string ou array contendo o caminho de arquivos
		 * @access: public
		 * @return: void;
		 */
		public function __construct($url = ''){
			if($url != ''){
				$this->addFile($url);
			}
			return $this;
		}
		
		/**
		 * Se Config: edita as configurações da classe
		 * @param: k(string), propriedade a ser alterada
		 * @param: v(mixed), valor da propriedade
		 * @access: protected
		 * @return: void
		 */
		protected function setConfig($k, $v = null){
			$this->configuration[$k] = $v;
			return;
		}
		
		/**
		 * Get Num Files: retorna o número de arquivos registrados em @files
		 * @info: ideal para quando se quer tratar todos os arquivos
		 * @exemplo:
		 * 				for($i = 0; $i < Zeus_File::getNumFiles(); $i++){
		 *					echo Zeus_File::getSize($i);
		 *				}
		 * @access: public
		 * @return: int
		 */
		public function getNumFiles(){
			return count($this->files);
		}
		
		/**
		 * Set File: Edita a url de um arquivo
		 * @info: Ideal para quando o arquivo é renomeado ou movido
		 * @param: url(string), novo caminho para o arquivo
		 * @param: i(int), indice do arquivo em @files a ser substituido
		 * @access: public
		 * @return: bool
		 */
		public function setFile($url, $i = 0){
			if(!isset($this->files[$i]))
				return false;
			$this->files[$i]['url'] = $url;
			return true;
		}
		
		/**
		 * Add File: adiciona um ou mais arquivos à @files
		 * @param: url(mixed), caminho ou array com caminhos dos arquivos a serem adicionados
		 * @access: public
		 * @return: void
		 */
		public function addFile($url){
			if(is_string($url)){
				if(!$this->is_set($url)){
					if(file_exists($url)){
						if($this->is_valid($url)){
							$this->files[] = array('url' => $url);
						}else{
							//throw new Exception("O arquivo {$url} não é válido!");
						}
					}else{
						//throw new Exception("O arquivo {$url} não existe!");
					}
				}else{
					//throw new Exception("O arquivo {$url} já foi adicionado!");
				}
			}else if(is_array($url)){
				foreach($url as $u){
					$this->addFile($u);
				}
			}
			return $this;
		}
		
		/**
		 * Is Valid: verifica se um arquivo é valido
		 * @param: url(string), caminho para o arquivo a ser verificado
		 * @access: public
		 * @return: bool
		 */
		public function is_valid($url){
			if($this->configuration['maxSize'] > 0 && filesize($url) > $this->configuration['maxSize'])
				return false;
			if(!is_null($this->configuration['extensions']) && !in_array(strtolower(pathinfo($url, PATHINFO_EXTENSION)), $this->configuration['extensions']))
				return false;
			return true;
		}
		
		/**
		 * Is Set: verifica se o arquivo já foi adiciona ao array @files
		 * @param: url(string), arquivo a ser verificado
		 * @access: public
		 * @return: bool
		 */
		public function is_set($url){
			foreach($this->files as $file){
				if($file['url'] == $url)
					return true;
			}
			return false;
		}
		
		/**
		 * Get Name: retorna o nome do arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: string
		 */
		public function getName($i = 0){
			if(!isset($this->files[$i]['name'])){
				$this->files[$i]['name'] = pathinfo($this->files[$i]['url'], PATHINFO_FILENAME);
			}
			return $this->files[$i]['name'];
		}
		
		/**
		 * Get File: pega o nome e extensão do arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: string
		 */
		public function getFile($i = 0){
			if(!isset($this->files[$i]['file'])){
				$this->files[$i]['file'] = pathinfo($this->files[$i]['url'], PATHINFO_BASENAME );
			}
			return $this->files[$i]['file'];
		}
		
		/**
		 * Get Ext: pega a extensão do arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: string
		 */
		public function getExt($i = 0){
			if(!isset($this->files[$i]['ext'])){
				$this->files[$i]['ext'] = pathinfo($this->files[$i]['url'], PATHINFO_EXTENSION);
			}
			return $this->files[$i]['ext'];
		}
		
		/**
		 * Get Size: pega o tabanho(e bites) do arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: numeric
		 */
		public function getSize($i = 0){
			if(!isset($this->files[$i]['size'])){
				$this->files[$i]['size'] = filesize($this->files[$i]['url']);
			}
			return $this->files[$i]['size'];
		}
		
		/**
		 * Get Path: pega o diretório do arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: string
		 */
		public function getPath($i = 0){
			if(!isset($this->files[$i]['path'])){
				$this->files[$i]['path'] = pathinfo($this->files[$i]['url'], PATHINFO_DIRNAME);
			}
			return $this->files[$i]['path'];
		}
		
		/**
		 * Duplicate: duplica o arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: bool
		 */
		public function duplicate($i = 0){
			if(!isset($this->files[$i]))
				return false;
			$j = 2;
			$file = $this->getPath($i).DS.$this->getName().'_'.$j.'.'.$this->getExt();
			while(file_exists($file)){
				$j++;
				$file = $this->getPath($i).DS.$this->getName().'_'.$j.'.'.$this->getExt();
			}
			return copy($this->files[$i]['url'], $file) ? $file : false;
		}
		
		/**
		 * Rename: renomei o arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: bool
		 */
		public function rename($name, $i = 0){
			if(!isset($this->files[$i]))
				return false;
			if(rename($this->files[$i]['url'], $this->getPath($i).DS.$name.'.'.$this->getExt())){
				$this->setFile($this->getPath($i).DS.$name.'.'.$this->getExt($i), $i);
				return true;
			}
			return false;
		}
		
		/**
		 * Delete: deleta o arquivo @i em @files
		 * @param: i(int), indíce do arquivo no array @files
		 * @access: public
		 * @return: bool
		 */
		public function delete($i = 0){
			if(!isset($this->files[$i]))
				return false;
			if(unlink($this->files[$i]['url'])){
				unset($this->files[$i]);
				return true;
			}else{
				return false;
			}
		}
		
		/**
		 * Reload: elimina todas as propriedades do arquivo salva na classe
		 * @param: i(int), indice o arquivo em @file
		 * @access: pubic
		 * @return: bool
		 */
		public function reload($i = 0){
			if(!isset($this->files[$i]))
				return false;
			$url = $this->files[$i]['url'];
			foreach($this->files[$i] as $k => $v){
				unset($this->files[$i][$k]);
			}
			$this->files[$i] = array('url' => $url);
			return $this;
		}
		
	}
	
?>