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
	define('MY_CORE', BP."Core".TRAIL."MY".TRAIL);
	
	define('HELPERS_PATH', BP."Helpers".TRAIL);
	define('CONFIG_PATH', BP."Config".TRAIL);
	define('CONTROLLERS_PATH', BP."Controllers".TRAIL);
	define('VIEWS_PATH', BP."Views".TRAIL);
	define('MODELS_PATH', BP."Models".TRAIL);
	define('EVENTS_PATH', BP."Events".TRAIL);

/*
 * -------------------------------------------------------------------
 *  Function to include all files with a given extention from a directory
 *
 *  require_dir will include files inside a scope so variables will be private
 *  to avoid problems non 'class' or 'function' files are included manually.
 *  by adding them to 'dir'
 * -------------------------------------------------------------------
 */
	
	$dirs = array();
	function require_dir($dir,$ext = "php"){ foreach (glob($dir."*.".$ext) as $filename) { include $filename; } }
	
/*
 * -------------------------------------------------------------------
 *  Include all our required files
 * -------------------------------------------------------------------
 */
	# Start with our config and then core as everything should extend these
	require_dir(CORE);
	require_dir(MY_CORE);
	
	# To ensure we can use configs within Slim
	# we need to globalize them.
	global $config;
	
 	# Trigger our first event
	Events::trigger("first_event",'','');
 
	# And the everything else
	$dirs[] = EVENTS_PATH;
	$dirs[] = CONFIG_PATH;
	$dirs[] = CONTROLLERS_PATH;
	$dirs[] = MODELS_PATH;
	$dirs[] = VIEWS_PATH;
	$dirs[] = HELPERS_PATH;
	
	# Include our files
	foreach ($dirs as $dir) { 
		foreach (glob($dir."*.php") as $filename) { 
			require_once($filename);
		}
	}
	
	# Trigger after_includes event
	Events::trigger("after_includes",'','');
/*
 * -------------------------------------------------------------------
 *  Start our system class
 * -------------------------------------------------------------------
 */
	$system = new System();
/*
 * -------------------------------------------------------------------
 *  Set our view
 * -------------------------------------------------------------------
 */	
	if($config['sys']['override_view'] && isset($_REQUEST['format'])){ $system->setView($_REQUEST['format']); }
	else { $system->setView($config['sys']['view']); }
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
 *  Load our routes and hooks - GET, POST, DELETE, PUT
 * -------------------------------------------------------------------
 */ 
	if($app->request()->getMethod()){

		Events::trigger("before_request",'','');
			
			// no key: api.thing.com/say/hello/
			// key: api.thing.com/key/say/hello/

			if($config['keys']['enabled']){ $map = "/:key/:controller(/:method)(/)(:everything_else+)"; }
			else { $map = "/:controller(/:method)(/)(:everyting_else+)"; }
			
			$app->map($map , function(){
				# As this function is anon we have to
				# call our $app and $system into scope.
				global $app,$system,$config;
				
				# Get the args we are passed
				# 0 => $controller, 1 => $method = "index", 2 => array of values.
				# if keys 0 => key , 1 => $controller, 2 => $method = "index", 3 => array of values
				$args = func_get_args();
				if($config['keys']['enabled']){
					$key = $args[0];
					$controller = $args[1];
					if(isset($args[2])){ $method = $args[2]; }
					else { $method = "index"; }
					if(isset($args[3])){
						$arguments = $args[3];
					} else { $arguments = null; }
					
				} else {
					$key = null;
					$controller = $args[0];
					if(isset($args[1])){ $method = $args[1]; }
					else { $method = "index"; }
					
					if(isset($args[2])){
						$arguments = $args[2];
					} else { $arguments = null; }
				}
				
				# If we have a key, validate it.
				if($key){ 
					$check = $system->key($key,$config['keys']['model']);
					if(!$check){ return $app->response()->status(403); }
				}
				
				# Get our 'verb' from SLIM
				$verb = strtolower($app->request()->getMethod());
				
								
				# If we're a get request, accept variables.
				# If we're not but we've been send arguments, 404.
				if($verb == "get"){
					if($arguments){ $system->setArgs($arguments); }
				} else if($arguments){
					return $app->response()->status(404);
				}
				
				# Set our $controller, $method and $verb on system.
				$system->setPath(array(0 => $controller, 1=> $method, 3 => $verb));
				
				# Fetch our view
				$res = $system->get($controller,$method);
				$view = $system->view();
				
				# Get Silm's response methods
				$resp = $app->response();
				
				# Set the 'view' headers if we have them
				if(isset($view->headers)){
					foreach($view->headers as $key => $value){ $resp[$key] = $value; }
				}
				
				# Display the content or 404
				if($res){ 
					$resp->body($view->display($res));
				} else { return $app->response()->status(404); }  
			})->via("GET","POST","PUT","DELETE");
			
			Events::trigger("after_request",'','');
		
		if($config['sys']['404']){
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