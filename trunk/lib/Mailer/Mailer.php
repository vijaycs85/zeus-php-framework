<?php
	
	class Zeus_Mailer{
		protected
		$headers = array(),
		$recipients = array(),
		$subject = '',
		$message = '';
		
		public function ___construct(){}
		
		public function addHeader($header){
			if(is_string($header) && !isset($header, $this->headers)){
				$this->headers[] = $header;
			}else if(is_array($header)){
				foreach($header as $h){
					$this->addHeader($h);
				}
			}
			return $this;
		}
		
		public function isHTML(){
			return $this->addHeader(array('MIME-Version: 1.0', 'Content-type: text/html; charset=urf-8'));
		}
		
		public function setSender($mail, $name){
			ini_set('sendmail_from', $mail);
			$this->addHeader("From: {$mail} <{$name}>");
			return $this;
		}
		
		public function setSubject($sub){
			$this->subject = $sub;
			return $this;
		}
		
		public function setBody($body){
			$this->message = $body;
			return $this;
		}
		
		public function send(){
			$recipients_separated = implode(',', $this->recipients);
			$headers = ''; 
            foreach($this->headers as $header) { 
               $headers .= "{$header};"; 
            } 
            return mail($recipients_separated, $this->subject, $this->message, $headers); 
		}
		
		public function addRecipient($mail){
			if(!in_array($mail, $this->recipients) && Zeus_String::isMail($mail)){
				$this->recipients[] = $mail;
			}else if(is_array($mail)){
				foreach($mail as $m){
					$this->addRecipient($m);
				}
			}
			return $this;
		}
		
		public function addCC($mail){
			if(Zeus_String::isMail($mail)){
				$this->addHeader("CC: {$mail}");
			}else if(is_array($mail)){
				foreach($mail as $m){
					$this->addCC($m);
				}
			}
			return $this;
		}
		
		public function addBCC($mail){
			if(Zeus_String::isMail($mail)){
				$this->addHeader("BCC: {$mail}");
			}else if(is_array($mail)){
				foreach($mail as $m){
					$this->addBCC($m);
				}
			}
			return $this;
		}
	}
	
?> 