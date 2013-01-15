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
	
	
	$table = "turkers_011413"; // update
	

	
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
	$question = $_SESSION['QUESTION'];
	$answer = $_POST['answer'];
	$_SESSION['TEMP_ANSWER'] = $answer;
	$explanation = $_POST['explanation'];
	$_SESSION['TEMP_EXPLANATION'] = $explanation;
		
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
	if (isset($_SESSION['QUESTION'])) {
		if($answer == '') {
			$errmsg_arr[] = 'Please enter an answer.';
			$errflag = true;
		}  
		if($explanation == '') {
			$errmsg_arr[] = 'Please enter an explanation.';
			$errflag = true;
		}  
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
	$qry = "INSERT INTO ".$table."(code, she_description, he_description, rating, question, answer, explanation) VALUES('$code', '$she_description', '$he_description', '$rating', '$question', '$answer', '$explanation')";
	$result = mysql_query($qry);

	//Check whether the query was successful or not
	if($result) {
	
		if ($answer) send_msg($answer);
	
	    unset($_SESSION['TEMP_SHE_DESCRIPTION']);
	    unset($_SESSION['TEMP_HE_DESCRIPTION']);
	    unset($_SESSION['TEMP_ANSWER']);
	    unset($_SESSION['TEMP_EXPLANATION']);
	    unset($_SESSION['QUESTION']);
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
		
		//$tweetmsg = '@sotur1 '.$msg; // add time for distinct msgs
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
		  'status' => $msg
		));
		mail('6173088817@messaging.sprintpcs.com', '', $msg);  
		//mail('laurmccarthy@gmail.com', '', $msg);  
	}
	

?>



