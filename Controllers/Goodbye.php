<?php

/* Auto Document
 *
 * @path: goodbye
 * @description: Say goodbye to the world.
 * @verbs: get
 * @arguments: none
 */

/* @method: do
 * @verb: get
 * @description: returns "Goodbye world."
*/

	class Say extends Controller {
		
		//var $verb = "get";
		var $arguments;
		
		public function __construct($args = array()){
			parent::__construct();
			$this->arguments = $args;
		}
		
		public function hello_get(){ return array('return' => 'Hello, world.'); }
		public function hello_post(){ return array('return' => 'Hello, post world.'); }
		
	}

?>