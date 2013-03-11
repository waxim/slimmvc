<?php defined('BP') or exit('No direct script access allowed');

	class Controller {
		
		private function __construct(){
			Events::trigger("before_controller",'','');
		}
		
	}

?>