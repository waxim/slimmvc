<?php

/*
 * -------------------------------------------------------------------
 *  Set all of our globals
 * -------------------------------------------------------------------
 */
	# The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	# Define all paths
	define('BP', "./");
	define('TRAIL', "/");
	define('CORE', BP."Core".TRAIL);
	
	define('HELPERS_PATH', BP."Helpers".TRAIL);
	define('CONTROLLERS_PATH', BP."Controllers".TRAIL);
	define('MODELS_PATH', BP."Models".TRAIL);
	define('EVENTS_PATH', BP."Events".TRAIL);

/*
 * -------------------------------------------------------------------
 *  Function to include all files with a given extention from a directory
 * -------------------------------------------------------------------
 */

	function require_dir($dir,$ext = "php"){ foreach (glob($dir."*.".$ext) as $filename) { include $filename; } }
	
/*
 * -------------------------------------------------------------------
 *  Include all our require files
 * -------------------------------------------------------------------
 */
	# Start with our config and then core as everything should extend these
	require_dir(CORE);
	
	# To ensure we can use configs within Slim
	# we need to globalize them.
	global $config;
	
 	# Trigger our first event
	Events::trigger("first_event",'','');
 
	# And the everything else
	require_dir(EVENTS_PATH);
	
	require_dir(CONTROLLERS_PATH);
	require_dir(MODELS_PATH);
	require_dir(HELPERS_PATH);
 
	# Trigger after_includes event
	Events::trigger("after_includes",'','');
/*
 * -------------------------------------------------------------------
 *  Start our system class
 * -------------------------------------------------------------------
 */
$system = new System();	
$system->setView($config['view']);
/*
 * -------------------------------------------------------------------
 *  Bootstrap our API loader (from Slim) 
 * -------------------------------------------------------------------
 */
	
	require_once(BP."Api/Bootstrap.php");
/*
 *  From this point on we can reference $app which is a Slim instance.
 *  Slim isn't static so we can't maintain coding styles. Messy ahead. 
 * -------------------------------------------------------------------
 *  Load our routes and hooks - GET
 * -------------------------------------------------------------------
 */ 
 
if($app->request()->isGet()){

	Events::trigger("before_get",'','');
		
		// no key: api.thing.com/say/hello/
		// key: api.thing.com/key/say/hello/
		
		$app->get("/:controller" , function($controller){
			global $app,$system;
			$res = $system->get($controller,null);
			if($res){ $system->show($res); }
			else { $app->response()->status(404); }
		});
		
		$app->get("/:controller/:method" , function($controller,$method){
			# As this function is anon we have to
			# call our $app and $system into scope.
			global $app,$system;
			
			# Set our $controller and $method on system.
			$system->setPath(array(0 => $controller, 1=> $method));
			
			# Fetch our view
			$res = $system->get($controller,$method);
			if($res){ $system->show($res); }
			
			# This breaks our neatness a little but its a sure fire way
			# to dump out of Slim with dirtying our other classes.
			else { return $app->response()->status(404); }  
		});
		
		Events::trigger("after_get",'','');
	
	if($config['404_on_error']){
		$app->get('/',function() { global $app; return $app->response()->status(404); }); # 404 no standard requests
	}
}	

	
/*
 * -------------------------------------------------------------------
 *  Finally let slim do its thing.
 * -------------------------------------------------------------------
 */
 
 $app->run();

# End of index.php
?>