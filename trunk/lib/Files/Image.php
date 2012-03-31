<?php
	
	class Zeus_Image extends Zeus_File{
		
		public function __construct($url = ''){
			$this->setConfig('extensions', array('gif', 'jpg', 'png', 'jpeg'));
			return parent::__construct($url);
		}
		
		public function __destruct(){
			for($i = 0; $i < $this->getNumFiles(); $i++){
				$this->destroy($i);
			}
		}
		
		/**
		 * Get Width: retorna a largura do arquivo
		 * @param: i(int), indice do arquivo em parent::$files a ser pega a infomação
		 * @access: public
		 * @return: int
		 */
		public function getWidth($i = 0){
			if(!isset($this->files[$i]['width'])){
				 list($this->files[$i]['width'], $h) = getimagesize($this->files[$i]['url']);
			}
			return $this->files[$i]['width'];
		}
		
		/**
		 * Get Height: retorna a altura do arquivo
		 * @param: i(int), indice do arquivo em parent::$files a ser pega a infomação
		 * @access: public
		 * @return: int
		 */
		public function getHeight($i = 0){
			if(!isset($this->files[$i]['height'])){
				 list($w, $this->files[$i]['height']) = getimagesize($this->files[$i]['url']);
			}
			return $this->files[$i]['height'];
		}
		
		/**
		 * Create: carrega a imagem na memória
		 * @access: protected
		 * @return: bool
		 */
		public function create($i = 0){
			switch($this->getExt($i)){
				case 'jpg':
				case 'jpeg':
					$this->files[$i]['create'] = imagecreatefromjpeg($this->files[$i]['url']);
				break;
				case 'png':
					$this->files[$i]['create'] = imagecreatefrompng($this->files[$i]['url']);
				break;
				case 'gif':
					$this->files[$i]['create'] = imagecreatefromgif($this->files[$i]['url']);
				break;
				default:
					Zeus_Error::raise("Zeus_Image::create(): problema ao criar a imagem. Tipo desconhecido!");
					return false;
				break;
			}
			return true;
		}
		
		/**
		 * Resize: redimensiona uma imagem
		 * @param: w(int), nova largura da imagem
		 * @param: h(int), nova altura da imagem
		 * @param: i(int), indice do arquivo em @files a ser redimensionado
		 * @param: t(string), tipo de redimensionamento a ser aplicado
		 *		   @value: simple, redimensiona para os tamanhos passados em @w, e @h
		 * 		   @value: max, redimensiona relativamente, não deixando que a largura nem altura
		 * 				   ultrapassem @w ou @h, respectivamente
		 * 		   @value: fill, redimensiona relativamente e completa com uma cor o restante da imagem
		 * 		   @value: byWidth, redimensiona relativamente, não deixando que a largura ultrapasse @w
		 * 		   @value: byHeight, redimensiona relativamente, não deixando que a altura ultrapasse @h
		 * 		   @value: width, redimensiona apenas a largura
		 * 		   @value: height, redimensiona apenas a altura
		 * @access: public
		 * @return: bool
		 */
		public function resize($w, $h, $i = 0, $t = 'simple'){
			if(!isset($this->files[$i]))
				return false;
			if(!$this->create($i))
				return false;
			switch($t){
				case 'simple':
					return $this->resizeSimple($w, $h, $i);
				break;
				case 'byWidth':
					return $this->resizeByWidth($w, $h, $i);
				break;
				case 'byHeight':
					return $this->resizeByHeight($w, $h, $i);
				break;
				case 'max':
					return $this->resizeMax($w, $h, $i);
				break;
				default:
					Zeus_Error::raise("Zeus_Image::resize(): Modo de redimensionamento não reconhecido! {$t}");
				break;
			}
			return false;
		}
		
		/**
		 * Resize Simple: redimensiona para os tamanhos passados em @w, e @h
		 * @param: w(int), nova largura da imagem
		 * @param: h(int), nova altura da imagem
		 * @param: i(int), indice do arquivo em @files a ser redimensionado
		 * @access: protected
		 * @return: false | object
		 */
		protected function resizeSimple($w, $h, $i = 0){
			$this->files[$i]['create_tc'] = imagecreatetruecolor($w, $h);
			if(!imagecopyresampled($this->files[$i]['create_tc'], $this->files[$i]['create'], 0, 0, 0, 0, $w, $h, $this->getWidth($i), $this->getHeight($i)))
				return false;
			return $this;
		}
		
		/**
		 * Resize Max: redimensiona relativamente, não deixando que a largura nem altura
		 * @param: w(int), largura máxima para a imagem
		 * @param: h(int), altura máxima para a imagem
		 * @param: i(int), indice do arquivo em @files a ser tratado
		 * @access: protected
		 * @return: bool
		 */
		protected function resizeMax($width, $height, $i = 0){
			$porcentagem = ($width*100)/$this->file_width;
			$new_height = ($this->file_height*$porcentagem)/100;
			if($new_height > $height){
				$porcentagem = ($height*100)/$this->file_height;
				$width = ($this->file_width*$porcentagem)/100;
			}else{
				$height = $new_height;
			}
			$this->create_tc = imagecreatetruecolor($width, $height);
			@imagecopyresampled($this->create_tc, $this->create, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height);
		}
		
		/**
		 * Resize By Width: redimensiona relativamente, não deixando que a largura ultrapasse @w
		 * @param: w(int), largura máxima para a imagem
		 * @param: h(int), altura para a imagem
		 * @param: i(int), indice do arquivo em @files a ser tratado
		 * @access: protected
		 * @return: bool
		 */
		protected function resizeByWidth($width){
			$porcentagem = ($width*100)/$this->file_width;
			$height = ($this->file_height*$porcentagem)/100;
			$this->create_tc = imagecreatetruecolor($width, $height);
			@imagecopyresampled($this->create_tc, $this->create, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height);
		}
		
		/**
		 * Resize By Height: redimensiona relativamente, não deixando que a altura ultrapasse @h
		 * @param: w(int), largura para a imagem
		 * @param: h(int), altura máxima para a imagem
		 * @param: i(int), indice do arquivo em @files a ser tratado
		 * @access: protected
		 * @return: bool
		 */
		protected function resizeByHeight($height){
			$porcentagem = ($height*100)/$this->file_width;
			$width = ($this->file_height*$porcentagem)/100;
			$this->create_tc = imagecreatetruecolor($width, $height);
			@imagecopyresampled($this->create_tc, $this->create, 0, 0, 0, 0, $width, $height, $this->file_width, $this->file_height);
		}
		
		/**
		 * Crop: corta um pedaço da imagem
		 * @param: w(int), largura do corte
		 * @param: h(int), altura do corte
		 * @param: t(int), distancia do topo
		 * @param: l(int), distancia da esquerda
		 * @param: i(int), indice do arquivo em @files a ser cortado
		 * @access: public
		 * @return: false | object
		 */
		public function crop($w, $h, $t = 0, $l = 0, $i = 0){
			if(!isset($this->files[$i]))
				return false;
			if(!$this->create())
				return false;
			$this->files[$i]['create_tc'] = imagecreatetruecolor($w, $h);
			if(!imagecopyresampled($this->files[$i]['create_tc'], $this->files[$i]['create'], 0, 0, $l, $t, $w, $h, $w, $h))
				return false;
			return $this;
		}
		
		/**
		 * Flip: inverte uma imagem
		 * @param: d(string), direção a inverter
		 * @param: i(int), indice da imagem em @files a ser invertida
		 * 		   @value: horizontal
		 * 		   @value: vertical
		 * @access: public
		 * @return: false | object
		 */
		public function flip($d = 'horizontal', $i = 0){
			if(!$this->create($i))
				return false;
			switch($d){
				case 'horizontal':
					return $this->flipH($i);
				break;
				case 'vertical':
					return $this->flipV($i);
				break;
			}
			return false;
		}
		
		/**
		 * Flip vertical: inverte uma imagem horizontalmente
		 * @param: i(int), indice da imagem em @files a ser invertida
		 * @access: protected
		 * @return: false | object
		 */
		protected function flipH($i = 0){
			$this->files[$i]['create_tc'] = imagecreatetruecolor($this->getWidth($i), $this->getHeight($i));
			for($j = 0; $j < $this->getWidth($i); $j++){
				if(!imagecopy($this->files[$i]['create_tc'], $this->files[$i]['create'], $j, 0, $this->getWidth($i)-$j-1, 0, 1, $this->getHeight($i)))
					return false;
			}
			return $this;
		}
		
		/**
		 * Flip vertical: inverte uma imagem verticalmente
		 * @param: i(int), indice da imagem em @files a ser invertida
		 * @access: protected
		 * @return: false | object
		 */
		protected function flipV($i = 0){
			$this->files[$i]['create_tc'] = imagecreatetruecolor($this->getWidth($i), $this->getHeight($i));
			for($j = 0; $j < $this->getHeight($i); $j++){
				if(!imagecopy($this->files[$i]['create_tc'], $this->files[$i]['create'], 0, $j, 0, $this->getHeight($i)-$j-1, $this->getWidth($i), 1))
					return false;
			}
			return $this;
		}
		
		/**
		 * Save: salva a imagem no seu arquivo original ou no caminho passado em @file
		 * @param: file(mixed), caminho em que o arquivo deve ser salvo,
		 * 		   ou null para ser salvo em seu arquivo original
		 * @param: q(int), qualidade da imagem a ser salva, entre 0 e 100
		 * @param: i(int), indice da imagem em @files a ser salva
		 * @access: public
		 * @return: bool
		 */
		public function save($file = null, $q = 100, $i = 0){
			switch($this->getExt($i)){
				case 'jpg':
				case 'jpeg':
					imagejpeg($this->files[$i]['create_tc'], is_null($file) ? $this->files[$i]['url'] : $file, $q);
					return $this;
				break;
				case 'png':
					imagepng($this->files[$i]['create_tc'], is_null($file) ? $this->files[$i]['url'] : $file, $q);
					return $this;
				break;
				case 'gif':
					imagegif($this->files[$i]['create_tc'], is_null($file) ? $this->files[$i]['url'] : $file, $q);
					return $this;
				break;
			}
			return false;
		}
		
		/**
		 * Render: mostra a imagem no navegador
		 * @param: q(int), qualidade da imagem a ser mostrada
		 * @param: i(int), indice da imagem em @files a ser exibida
		 * @access: public
		 * @return: bool
		 */
		public function render($q = 100, $i = 0){
			switch($this->getExt($i)){
				case 'jpg':
				case 'jpeg':
					header('Content-type: image/'.$this->getExt($i));
					imagejpeg($this->files[$i]['create_tc'], null, $q);
					return $this;
				break;
				case 'png':
					header('Content-type: image/png');
					imagepng($this->files[$i]['create_tc'], null, $q);
					return $this;
				break;
				case 'gif':
					header('Content-type: image/gif');
					imagegif($this->files[$i]['create_tc'], null, $q);
					return $this;
				break;
			}
			return false;
		}
		
		/**
		 * Destroy: elimina a imagem da memória
		 * @param: i(int), index da imagem a ser eliminada da memória em @files
		 * @access: public
		 * @return: bool
		 */
		public function destroy($i = 0){
			if(!isset($this->files[$i]))
				return false;
			return imagedestroy($this->files[$i]['create_tc']);
		}
	}
	
?>