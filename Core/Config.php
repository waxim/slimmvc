<?php defined('BP') or exit('No direct script access allowed');

	class Config {
	
		var $_data;
		
		public function get($map){
			$parts = explode("/",$map);
			return $this->_data[$parts[0]][$parts[1]];
		}
		
		public function set($config){ $this->_data = $config; }
	}