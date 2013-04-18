<?php

class Number extends Controller {

    var $code;
	var $number;
	var $verb = "get";
	
    public function __construct($args = array()){ 
		if(count($args) < 1){ 
			return $this->error();
		} else { 
			$this->number = $args[0];  
		}
	}

    public function info(){
        return array('network' => '02 Telephonica','last_contact' => '00-00-00 00:00:00');
	}

    public function error(){
        $this->code = 500;
        return array("error" => "Sorry, there was an error processing your request.");
    }
}