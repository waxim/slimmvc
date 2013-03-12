<?php defined('BP') or exit('No direct script access allowed');

	class System {
		
		private $_view;
		private $_controller;
		private $_method;
		
		public function setPath($ar){

			$this->_controller = $ar[0]; 
			$this->_method = $ar[1];
			return true;
		}

		public function setView($view = 'json'){
			$v = "View_".$view;
			if(class_exists($v)){
				$this->_view = new $v;
			} else { $this->_view = null; }
		}
		
		public function controller(){ return $this->_controller; }
		public function method(){ return $this->_method; }
		
		public function get($controller,$method){
			if(class_exists($controller)){
				$route = new $controller;
				if($method == null){ $method == "index"; }
				$routes = get_class_methods($route);
				if(in_array($method,$routes)){
					return call_user_func(array($route, $method));
				} else { return false; }
			} else { return false; }
		}
		
		public function show($data){
			if($this->_view){
				echo $this->_view->display($data);
			} else { return false; }
			#if($this->_view == 'json'){ echo json_encode($data); }
			#else { echo $data;}
		}
	
	}