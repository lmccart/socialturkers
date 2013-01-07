<?php
	
	//Include database connection details
	require_once('config.php');
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
	
		return $str;
	}
	
	//Sanitize the POST values
	$description = clean($_POST['description']);
	$rating = $_POST['rating'];
	$action = $_POST['action'];
	
	$code = rand_string(10);
	

	//Create INSERT query
	$qry = "INSERT INTO turkers_010712(code, description, rating, action) VALUES('$code', '$description', '$rating', '$action')";
	$result = mysql_query($qry);
	
	
	//Check whether the query was successful or not
	if($result) {
		header("location: ./thankyou.php?code=".$code);
	}else {
		die("Query failed");
	}
?>
