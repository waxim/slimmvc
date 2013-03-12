<?php

	class Say extends Controller {
		
		var $verb = "get";
		
		public function __construct(){ parent::__construct(); }
		
		public function index(){
			return $this->hello();
		}
		
		public function hello(){ return array('return' => 'Hello, world.'); }
		
	}

?>