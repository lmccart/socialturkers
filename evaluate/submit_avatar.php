<?php
	
	//Include database connection details
	require_once('config.php');
	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	
	$table = "turkers_011113"; // update
	

	
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
	$she_description = clean($_POST['she_description']);
	$he_description = clean($_POST['he_description']);
	$_SESSION['TEMP_SHE_DESCRIPTION'] = $she_description;
	$_SESSION['TEMP_HE_DESCRIPTION'] = $he_description;
	$rating = $_POST['rating'];
	$action = $_POST['action'];
	
	$other = clean($_POST['other']);
	$explanation = clean($_POST['explanation']);
		
	//Input Validations
	if($she_description == '') {
		$errmsg_arr[] = 'Please enter a description for the way the woman is feeling.';
		$errflag = true;
	}
	if($he_description == '') {
		$errmsg_arr[] = 'Please enter a description for the way the man is feeling.';
		$errflag = true;
	}
	if($rating == '') {
		$errmsg_arr[] = 'Please enter your rating.';
		$errflag = true;
	}
	if($action == '') {
		$errmsg_arr[] = 'Please enter an action.';
		$errflag = true;
	}  
	if($explanation == '') {
		$errmsg_arr[] = 'Please enter an explanation.';
		$errflag = true;
	}  	
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ./");
		exit();
	}

	
	
	$code = rand_string(10);

	//Create INSERT query
	$qry = "INSERT INTO ".$table."(code, she_description, he_description, rating, action, other, explanation) VALUES('$code', '$she_description', '$he_description', '$rating', '$action', '$other', '$explanation')";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
	
	    unset($_SESSION['TEMP_DESCRIPTION']);
		header("location: ./thankyou.php?code=".$code);
	}else {
		die("Query failed");
	}
	

?>



