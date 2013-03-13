<?php

	class Db {
		
		var $host;
		var $user;
		var $pass;
		var $db;
		
		public function query(){}
		
		public function select(){}
		public function update(){}
		public function insert(){}
		
		public function result(){}
		public function asArray(){}
		public function asObject(){}
		public function numRows(){}
		
		
		private function _makeSafe(){}
		private function _connect(){}
		
	}

?>