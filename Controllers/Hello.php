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
		
		public function __construct(){
			parent::__construct();
		}
		
		public function hello_get(){ return array('return' => 'Hello, world.'); }
		public function hello_post(){ return $this->hello_get(); }
		
		public function error_get(){ $this->code = 404; return array('error' => 'Sorry, there was an error.'); } 
		
	}

?>