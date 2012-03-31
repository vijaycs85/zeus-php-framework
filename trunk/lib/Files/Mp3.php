<?php
	
	class Zeus_MP3 extends Zeus_File{
		function __construct($url = ''){
			$this->setConfig('extensions', array('mp3'));
			parent::__construct($url);
		}
		
		/**
		 * Get id3: pega todas as tags de um arquivo e retorna a passada em @tag
		 * @param: tag(string), tag a ser retornada
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getId3($tag, $i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3'])){
				$filesize = $this->getSize($i);
				$file = fopen($this->files[$i]['url'], 'r');
				if(!$file){
					Zeus_Error::raise("Zeus_Mp3::getId3(), fopen(): Erro ao abrir o arquivo");
					return false;
				}
				fseek($file, -125, SEEK_END);
				$this->files[$i]['id3']['title'] = trim((fread($file, 30)));
				$this->files[$i]['id3']['artist'] = trim((fread($file, 30)));
				$this->files[$i]['id3']['album'] = trim((fread($file, 30)));
				$this->files[$i]['id3']['year'] = trim((fread($file, 30)));
				$this->files[$i]['id3']['genre'] = trim((fread($file, 30)));
				fclose($file);
			}
			return $this->files[$i]['id3'][$tag];
		}
		
		/**
		 * Get Title: pega a tag title
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getTitle($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3']['title'])){
				$this->files[$i]['id3']['title'] = $this->getId3('title', $i);
			}
			return $this->files[$i]['id3']['title'];
		}
		
		/**
		 * Get Artist: pega a tag artist
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getArtist($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3']['artist'])){
				$this->files[$i]['id3']['artist'] = $this->getId3('artist', $i);
			}
			return $this->files[$i]['id3']['artist'];
		}
		
		/**
		 * Get Album: pega a tag album
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getAlbum($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3']['album'])){
				$this->files[$i]['id3']['album'] = $this->getId3('album', $i);
			}
			return $this->files[$i]['id3']['album'];
		}
		
		/**
		 * Get Year: pega a tag year
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getYear($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3']['year'])){
				$this->files[$i]['id3']['year'] = $this->getId3('year', $i);
			}
			return $this->files[$i]['id3']['year'];
		}
		
		/**
		 * Get Genre: pega a tag genre
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: string
		 */
		public function getGenre($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['id3']['genre'])){
				$this->files[$i]['id3']['genre'] = $this->getId3('genre', $i);
			}
			return $this->files[$i]['id3']['genre'];
		}
		
		/**
		 * Get Bitrate: pega a taxa de bits
		 * @param: id(int), indice do arquivo a serem pegas as informaчѕes
		 * @access: public
		 * @return: int
		 */
		public function getBitrate($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			// OBS: mщtodo genщrico, falta cria-lo
			if(!isset($this->files[$i]['bitrate'])){
				$this->files[$i]['bitrate'] = 192;
			}
			return $this->files[$i]['bitrate'];
		}
		
		/**
		 * Get Duration: pega a duraчуo do сudio
		 * @access: public
		 * @return: string
		 */
		public function getDuration($i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			if(!isset($this->files[$i]['duration'])){
				$seconds = $this->getSize($i)/(($this->getBitrate($i)*1024)/8);
				$this->files[$i]['duration'] = sprintf("%d:%02d", ($seconds/60), ($seconds%60));
			}
			return $this->files[$i]['duration'];
		}
		
		/**
		 * Set Property: edita tags do arquivo
		 * @param: prop(mixed), nome da tag a ser editada, ou um array associativo.
		 * 		   tendo como chave, o nome da propriedade; e valor, o valor da tag
		 * @param: val(string), Opcional. Necessсrio apenas no caso de @prop ser uma string
		 * @access: public
		 * @return: string
		 */
		public function setProperty($prop, $val = null, $i = 0){
			if(!isset($this->files[$i])){
				Zeus_Error::raise("Zeus_Mp3: O indice {$i} nуo estс definido em \Zeus_Files::files");
				return false;
			}
			// OBS: mщtodo incompleto, fala implementar a funчуo de editar
			$prop_list = array('title', 'artist', 'genre', 'year', 'album');
			if(is_array($prop)){
				$i = $val == null ? 0 : $val;
				foreach($prop as $p => $v){
					if(in_array($p)){
						$this->setProperty($p, $v, $i);
					}else if(is_string($v)){
						foreach($v as $p => $v){
							$this->setProperty($p, $v, $i);
						}
					}
				}
				return true;
			}else if(is_string($prop)){
				if(is_null($val))
					return false;
				/**
				 * Criar aqui a funчуo de editar as tags
				 */
				return true;
			}
			return false;
		}
	}
	
?>