<?php defined('BP') or exit('No direct script access allowed');

/*
 * -------------------------------------------------------------------
 *  API Key settings
 * -------------------------------------------------------------------
 */
	
	$config['keys']['enabled'] = 1;
	$config['keys']['model'] = array('Keys','validate'); # is_array = (class, method) - is_string = array of keys
	$config['keys']['url'] = 1;
	$config['keys']['variable'] = ""; # the $_REQUEST var the key is in.