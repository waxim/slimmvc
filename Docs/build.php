<html>
<head>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
</head>
<body>
<?php
	
		
	function extract_value($str){ $desc = explode(":",$str); return trim($desc[1]); }
	
	function doc_controller($file){ 
		$source = file_get_contents($file);
		
		$expr = "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/"; 
		preg_match_all($expr, $source, $matchs); //capture the comments 
		
		$lines = array();
		foreach($matchs[0] as $m){
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
		
		echo "<h3>Functions</h3>";
		
		unset($lines[0]);
		
		//var_dump($lines);
		
		foreach($lines as $methods){
			if(isset($methods[2])){
				echo "Method: ".extract_value($methods[1])."<br />";
				echo "Description: ".extract_value($methods[3])."<br />";
				echo "Verb: ".extract_value($methods[2])."<br />";
				echo "<br /><br />";
			}
		}
		echo "<hr />";
	}
	
	foreach (glob("../Controllers/*.php") as $filename) { 
		doc_controller($filename);
	}
?>
</body>
</html>