<?php defined('BP') or exit('No direct script access allowed');

	class System {
		
		private $_view;
		private $_controller;
		private $_method;
		private $_verb;
		private $_args;
		
		var $db;
		
		var $config;
		
		# Pass our 'sub classes' to system
		public function __construct(){
			$this->db = new Db;
			$this->config = new Config;
		}
		
		public function setPath($ar){
			$this->_controller = $ar[0]; 
			$this->_method = $ar[1];
			$this->_verb = $ar[3];
			return true;
		}
		
		public function setArgs($args){
			if(is_array($args)){
				$this->_args = $args;
			}
		} 
		
		public function setView($view = 'json'){
			$v = "View_".$view;
			if(class_exists($v)){
				$this->_view = new $v;
			} else { $this->_view = new View_json; }
		}
		
		public function controller(){ return $this->_controller; }
		public function method(){ return $this->_method; }
		
		public function get($controller,$method){
			if(class_exists($controller)){
				if(isset($this->_args) && is_array($this->_args)){
					$route = new $controller($this->_args);
				} else { $route = new $controller; }
				if($method == null){ $method == "index"; }
				
				if(!isset($route->verb)){ $method_verb = $method."_".$this->_verb; }
				else if($route->verb == $this->_verb){ $method_verb = $method; } 
				else { return false; }
				
				$routes = get_class_methods($route);
				if(in_array($method_verb,$routes)){
					$this->controller = $route;
					return call_user_func(array($route, $method_verb));
				} else { return false; }
			
			} else { return false; }
		}
		
		public function view(){
			return $this->_view;
		}
		
		public function show($data){
			if($this->_view){
				echo $this->_view->display($data);
			} else { return false; }
		}
		
		public function key($key,$model = null){
			if($model){
				if(is_array($model)){
					return call_user_func(array($model[0], $model[1]),$key);
				} else {
					$keys = explode("|",$model);
					if(in_array($key,$keys)){ return true; }
					else { return false; }
				}
			} else {
				return false;
			}
		}
		
		public function auth($auth,$model = null){
			if($model){
				if(is_array($model)){
					return call_user_func(array($model[0], $model[1]),$auth);
				} else { return false; }
			} else { return false; }
		}
		
	
	}