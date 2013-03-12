<?php

	class Early extends Controller {
		
		var $verb = "get";
		
		public function __construct(){ parent::__construct(); }
		
		public function requestinfo(){
			return array('error' => 'cURL error'); 
		}
		
	}

?>