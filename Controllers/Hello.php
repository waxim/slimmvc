<?php

	class Say extends Controller {
	
		public function __construct(){
			parent::__construct();
		}
		
		public function hello(){ return "hello, world"; }
		public function something(){ return "hello, something"; }
		public function walk(){ return "hello, walk"; }
		
	}

?>