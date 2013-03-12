<?php defined('BP') or exit('No direct script access allowed');

/*
 * -------------------------------------------------------------------
 *  Database Settings
 * -------------------------------------------------------------------
 */

	$config['db']['enabled'] = 0;
	$config['db']['driver'] = 'mysqli';
	$config['db']['server'] = 'localhost';
	$config['db']['port'] = '3306';
	$config['db']['name'] = 'api';
	$config['db']['user'] = 'root';
	$config['db']['pass'] = '';
	$config['db']['prefix'] = 'api_';