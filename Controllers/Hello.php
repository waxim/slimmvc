<?php

	class Say extends Controller {
		
		var $verb = "get";
		
		public function __construct(){
			parent::__construct();
		}
		
		public function index(){
			return $this->hello_get();
		}
		
		public function hello_get(){ return array('return' => 'Hello, world.'); }
		
		
		public function something(){ return "hello, something"; }
		public function walk(){ return "hello, walk"; }
		
	}

?>