<?php defined('BP') or exit('No direct script access allowed');

function redirect($url){
	header("Location: $url");
	die;
}

?>