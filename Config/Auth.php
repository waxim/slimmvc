<?php defined('BP') or exit('No direct script access allowed');

/*
 * -------------------------------------------------------------------
 *  HTTP Basic Auth Settings
 * -------------------------------------------------------------------
 */
	
	$config['http_auth']['enabled'] = 1;
	$config['http_auth']['model'] = array('Http_auth','validate');