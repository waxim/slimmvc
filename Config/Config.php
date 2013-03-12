<?php
	
	$config['sys']['view'] = "json";
	$config['sys']['override_view'] = 1;
	$config['sys']['404'] = 1;
	
	$config['db']['enabled'] = 0;
	$config['db']['driver'] = 'mysqli';
	$config['db']['server'] = 'localhost';
	$config['db']['port'] = '3306';
	$config['db']['name'] = 'api';
	$config['db']['user'] = 'root';
	$config['db']['pass'] = '';
	$config['db']['prefix'] = 'api_';
	
	$config['keys']['enabled'] = 0;
	$config['keys']['model'] = array('Keys','validate'); # is_array = (class, method) - is_string = array of keys
	$config['keys']['url'] = 1;
	$config['keys']['variable'] = ""; # the $_REQUEST var the key is in.
	
	$config['log']['enabled'] = 0;
	$config['log']['model'] = array("Log","save");