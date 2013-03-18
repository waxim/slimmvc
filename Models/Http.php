<?php defined('BP') or exit('No direct script access allowed');
	
	#  Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
	
	class Http_auth {
		public function validate($info){
			if($info['user'] == "Aladdin" && $info['pw'] == "open sesame"){ return true; }
			else { return false; }
		}

	}