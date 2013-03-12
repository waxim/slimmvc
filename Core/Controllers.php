<?php defined('BP') or exit('No direct script access allowed');

	class Controller {
		
		public function __construct(){
			Events::trigger("before_controller",'','');
		}
		
	}

?>