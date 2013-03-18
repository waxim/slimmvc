<?php

	class Db {
		
		var $host;
		var $user;
		var $pass;
		var $db;
		var $prefix;
		
		var $last_query;
		var $connection;
		
		
		# $DB = new Db($config['db']);
		public function __construct($con = null){
			$this->user = $con['user'];
			$this->pass = $con['pass'];
			$this->name = $con['name'];
			$this->host = $con['host'];
			$this->prefix = $con['prefix'];
			
			$this->connection = new mysqli($this->host, $this->user, $this->pass, $this->name);
		}
		
		# $DB->query("SELECT * FROM keys WHERE idx > 12 LIMIT 12"); 
		# let me shout this at you THIS FUNCTION HAS NO SANITATION
		# DO NOT PASS IT USER SUMITTED VALUES!!!!
		public function query($query){
			if($this->connection){
				$this->last_query = $this->connection->query($query);
			} else { return false; }
		}
		
		# $DB->select("*","keys",array('limit' => 12, 'where' => "idx > 12");
		public function select(){}
		
		# $DB->update(array('idx' => 12, 'key' => thing"),"keys",array('where' => 'idx = 12'));
		public function update(){}
		
		# $DB->insert(array('idx' => 'value'),"table");
		public function insert(){}
		
		# $DB->delete("keys",array("where" => "idx = 12","limit" => '12'));
		public function delete(){ }
		
		# $DB->result()->asArray();
		#			   ->asObject();
		#			   ->first();
		#			   ->last();
		public function result(){}
		public function asArray(){}
		public function asObject(){}
		public function numRows(){}
		
		
		private function _makeSafe(){}
		
	}

?>