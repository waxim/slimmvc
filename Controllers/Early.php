<?php

	class Early extends Controller {
		
		var $verb = "get";
		
		public function __construct(){ parent::__construct(); }
		
		public function requestinfo(){
			print_r(System::getArgs());
			return array('error' => 'cURL error'); 
		}
		
	}

?>