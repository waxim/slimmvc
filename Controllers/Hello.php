<?php

/* Auto Document
 *
 * @path: say
 * @description: Say something to the world.
 * @verbs: get, post
 * @arguments: no
 */

/* @method: hello
 * @verb: get, post
 * @description: returns "Hello, world"
*/
	class Say extends Controller {
		
		var $code = null;
		var $args;
		
		public function __construct($args = null){
			parent::__construct();
			if($args){
				$this->args = $args;
			}
		}
		
		public function hello_get(){ return array('return' => 'Hello, world.'); }
		public function hello_post(){ return array('return' => $this->args->name); }
		
		
		public function error_get(){ $this->code = 404; return array('error' => 'Sorry, there was an error.'); } 
		
	}

?>