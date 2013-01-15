<?php

	require_once('config.php');
	
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
    
    $from = $_REQUEST['From'];
    $question = clean($_REQUEST['Body']);

    
	$table = "turkers_011413_questions"; 
	
	$qry = "INSERT INTO ".$table."(number, question) VALUES('$from', '$question')";
	$res = mysql_query($qry);
	
?>