<?php

class User extends Controller {

    var $user_idx;
    var $code;
	
    public function __construct($args = array()){ 
		if(count($args) < 1){ 
			return $this->error();
		} else { 
			$this->user_idx = $args[0];  
		}
	}

    public function show_get(){ 
        if($this->user_idx < 11){ 
            return $this->error();
        } else { 
            return "Showing info for the user ".$this->user_idx; 
        }
	}

    public function error(){
        $this->code = 500;
        return array("error" => "Sorry, there was an error processing your request.");
    }
}