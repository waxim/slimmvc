<?php
	
	class Access {
	
		public function access(){
			echo System::controller();
		}
		
	}
	
	Events::register("before_controller",array(new Access,"access"));
	
?>