<?php defined('BP') or exit('No direct script access allowed');
	
	#  Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
	
	class Http_auth {
		public function validate($info){
			if($info['user'] == "user" && $info['pw'] == "password"){ return true; }
			else { return false; }
		}

	}