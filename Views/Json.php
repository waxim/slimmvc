<?php defined('BP') or exit('No direct script access allowed');


	Class View_json {
	
		public function display($data){
			return json_encode($data);
		}
	
	}

?>