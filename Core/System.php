<?php

	class System {
		
		private static $_view;
		private static $_controller;
		private static $_method;
		
		public static function setPath($ar){
			if(isset($ar[0])){ self::$_controller = $ar[0]; }
			if(isset($ar[1])){ self::$_method = $ar[1]; }
			return true;
		}
		
		public static function setView($view = 'json'){
			self::$_view = $view;
		}
		
		public static function controller(){ return self::$_controller; }
		public static function method(){ return self::$_method; }
		
		public static function get($controller,$method){
			if(class_exists($controller)){
				return true;
			} else { return false; }
		}
		
		public static function show($data){
			if(self::$_view == 'json'){ echo json_encode($data); }
			else { echo $data;}
		}
	
	}