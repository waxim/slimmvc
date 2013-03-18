<?php

	// wget boostrap unzip to this folder.
	
	// read all controllers and build docs array.
	
	// get segment html, foreach segment
	
	if (!defined('T_ML_COMMENT')) {
	   define('T_ML_COMMENT', T_COMMENT);
	} else {
	   define('T_DOC_COMMENT', T_ML_COMMENT);
	}
	
	$source = file_get_contents('../Controllers/Hello.php');
	$tokens = token_get_all($source);
	
	//print_r($tokens);
	
	foreach ($tokens as $token) {
	   if (is_array($token)){
		   list($id, $text) = $token;
		   if($id == T_COMMENT){
				echo $text;
				$fields = explode("*",$text);
				print_r($fields);
				$regexp = "/\@.*\:\s.*\r/";
				preg_match_all($regexp, $text, $matches);
				print_r($matches);
		   }
	   }
	}

?>