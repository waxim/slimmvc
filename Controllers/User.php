<?php

	class User extends Controller {
		
		var $arguments;
		
		public function __construct($args = array()){
			if(!isset($args[0])){ return false; }
			else {	
				$this->arguments = $args;
				parent::__construct();
			}
		}
		
		public function get_get(){
			if($this->arguments[0] == 1){ echo "Alan Cole"; die; }
			else if($this->arguments[0] == 2){ echo "Tom Jones"; die; }
			else if($this->arguments[0] == 3){ echo "Frank Turner"; die; }
		}
	
	}