<?php

/* Auto Document
 *
 * @path: say
 * @description: Say something to the world.
 * @verbs: get, post
 * @arguments: none
 */

/* @method: hello
 * @verb: get
 * @description: returns "Hello, world" for posts requests
*/

/* @method: hello
 * @verb: post
 * @description: returns "Hello, world" for get requests
*/
	class Say extends Controller {
		
		//var $verb = "get";
		var $arguments;
		
		public function __construct($args = array()){
			parent::__construct();
			$this->arguments = $args;
		}
		
		public function index(){
			return $this->hello();
		}
		
		public function hello_get(){ return array('return' => 'Hello, world.'); }
		public function hello_post(){ return array('return' => 'Hello, post world.'); }
		
	}

?>