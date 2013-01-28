<?php
	
	//Include database connection details
	require_once('config.php');
	require('../tmhOAuth/tmhOAuth.php');
	require('../tmhOAuth/tmhUtilities.php');

	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	
	$table = "turkers_012613"; // update
	

	
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
	$chosen_line = clean($_POST['chosen_line']);
	$suggested_line = clean($_POST['suggested_line']);
	$_SESSION['TEMP_LINE'] = $suggested_line;
	
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
	if (isset($_SESSION['LINES'])) {
		if($chosen_line == '') {
			$errmsg_arr[] = 'Please vote for a question from the list for the woman to ask.';
			$errflag = true;
		}  
	}
	
	if ($suggested_line == '') {
		$errmsg_arr[] = 'Please suggest a new question for the woman to ask.';
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

	// insert into responses
	$qry = "INSERT INTO ".$table."(code, she_description, he_description, rating, chosen_line, suggested_line) VALUES('$code', '$she_description', '$he_description', '$rating', '$chosen_line', '$suggested_line')";
	$result = mysql_query($qry);
	
	// insert suggested line
	$suggested_qry = "INSERT INTO ".$table."_questions(suggested_line) VALUES('$suggested_line')";
	$suggested_result = mysql_query($suggested_qry);

	// update chosen line
	$chosen_qry = "UPDATE ".$table."_questions SET votes=votes+1 WHERE suggested_line='$chosen_line'";
	$chosen_result = mysql_query($chosen_qry);
	
	// check if line ready to be used
	$ready_qry = "SELECT * FROM ".$table."_questions WHERE suggested_line='$chosen_line' AND votes > 3";
	$ready_result = mysql_query($ready_qry);
	
	if ($ready_result && mysql_num_rows($ready_result) > 0) {
		send_msg($suggested_line);
	} 

	//Check whether the query was successful or not
	if($result) {
	
		if ($answer) send_msg($answer);
	
	    unset($_SESSION['TEMP_SHE_DESCRIPTION']);
	    unset($_SESSION['TEMP_HE_DESCRIPTION']);
	    unset($_SESSION['TEMP_LINE']);
		header("location: ./thankyou.php?code=".$code);
	}else {
		die("Query failed");
	}
	
	
	
	function send_msg($msg) {
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => CONSUMER_KEY,
		  'consumer_secret' => CONSUMER_SECRET,
		  'user_token'      => USER_TOKEN,
		  'user_secret'     => USER_SECRET,
		));
		
		$tweetmsg = $msg; // add time for distinct msgs
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
		  'status' => $tweetmsg
		));
		mail('6173088817@messaging.sprintpcs.com', '', $msg);  
		//mail('laurmccarthy@gmail.com', '', $msg);  
	}
	

?>



