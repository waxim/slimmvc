<?php

	class Say extends Controller {
	
		private function __construct(){
			parent::__construct();
		}
		
		public function hello(){ return "hello, world"; }
		
	}

?>