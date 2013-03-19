<?php
/*
 * This is an ugly, ugly file that is super fragile.
 * its aim is to build docs for all controllers.
 *
 * it breaks in almost every situation,
 * but I'm a firm beleiver that its the thought
 * that counts. So, at least I tried to help you.
 * amiright? But seriously, improvements to come.
*/
	function extract_value($str){ $desc = explode(":",$str); return trim($desc[1]); }
	
	function doc_controller($file){ 
		$source = file_get_contents($file);
		
		$expr = "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/"; 
		preg_match_all($expr, $source, $matches);
		
		$lines = array();
		foreach($matches[0] as $m){
			$exp = explode("*",$m);
			array_push($lines,$exp);
		}
		
		$controller = $lines[0];
		$path = extract_value($controller[3]);
		$description = extract_value($controller[4]);
		$verbs = extract_value($controller[5]);
		$arguments = extract_value($controller[6]);
		
		echo "<h1>Controller</h1>";
		echo "Path: http://localhost.com/".$path."<br />";
		echo "Description: ".$description."<br />";
		echo "Verbs: ".$verbs."<br />";
		echo "Arguments: ".$arguments."<br />";
		
		$has_args = (strtolower($arguments) == "yes") ? 1 : 0;
		
		echo "<h3>Methods</h3>";
		
		unset($lines[0]);
		
		foreach($lines as $methods){
			if(isset($methods[2])){
				echo "Method: ".extract_value($methods[1])."<br />";
				echo "Description: ".extract_value($methods[3])."<br />";
				echo "Verb: ".extract_value($methods[2])."<br />";
				if($has_args & count($methods) > 5){ echo "Arguments: ".extract_value($methods[4])."<br />"; }
				echo "<br /><br />";
			}
		}
		echo "<hr />";
	}
	
	foreach (glob("../Controllers/*.php") as $filename) { 
		doc_controller($filename);
	}
?>