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
	
	
	$table = "turkers_010812"; // update
	
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
	$_SESSION['TEMP_DESCRIPTION'] = $description;
	$rating = $_POST['rating'];
	$action = $_POST['action'];
	
	$stay = clean($_POST['stay']);
	$say = clean($_POST['say']);
	$ask = clean($_POST['ask']);
	$act = clean($_POST['act']);
	$leave = clean($_POST['leave']);
	
	
		
	//Input Validations
	if($description == '') {
		$errmsg_arr[] = 'Please enter a description.';
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
	
	if($action == 'stay' && $stay == '') {
		$errmsg_arr[] = 'Please add a stay explanation.';
		$errflag = true;
	} else if($action == 'say' && $say == '') {
		$errmsg_arr[] = 'Please add what to talk about.';
		$errflag = true;
	} else if($action == 'act' && $act == '') {
		$errmsg_arr[] = 'Please add how to act.';
		$errflag = true;
	} else if($action == 'ask' && $ask == '') {
		$errmsg_arr[] = 'Please add what to ask.';
		$errflag = true;
	} else if($action == 'leave' && $leave == '') {
		$errmsg_arr[] = 'Please add a leave explanation.';
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
	$qry = "INSERT INTO ".$table."(code, description, rating, action, stay_reason, say, act, ask, leave_reason) VALUES('$code', '$description', '$rating', '$action', '$stay', '$say', '$act', '$ask', '$leave')";
	$result = mysql_query($qry);
	
	// Send say or ask
	if ($action == 'say') {
		send_msg("SAY ".$say);
	} else if ($action == 'ask') {
		send_msg("ASK ".$ask);
	} else if ($action == 'act') {
		send_msg("ACT ".$act);
	} 
	//Check whether the query was successful or not
	if($result) {
		do_check($table);
	
	    unset($_SESSION['TEMP_DESCRIPTION']);
		header("location: ./thankyou.php?code=".$code);
	}else {
		die("Query failed");
	}
	
	function do_check($t) {
		$total_qry = "SELECT * FROM ".$t;
		$total_res = mysql_query($stay_qry);
		
		$leave_qry = "SELECT * FROM ".$t." WHERE action='leave'";
		$leave_res = mysql_query($leave_qry);
		
		if ($total_res && $leave_res) {
			$total = mysql_num_rows($total_res);
			$leave = mysql_num_rows($leave_res);
			if ($total > 20) { 
				if ($leave / $total > 0.75) {
					send_msg("LEAVE");
				}
			}
		}
		//return $leave."-".$stay."-".$total."=".$leave/$total;
	}
	
	function send_msg($msg) {
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => CONSUMER_KEY,
		  'consumer_secret' => CONSUMER_SECRET,
		  'user_token'      => USER_TOKEN,
		  'user_secret'     => USER_SECRET,
		));
		
		$tweetmsg = '@sotur1 '.$msg;
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
		  'status' => $tweetmsg
		));
		
	
		//mail('6173088817@messaging.sprintpcs.com', '', $msg);  
		mail('laurmccarthy@gmail.com', '', $msg);  
	}
?>



