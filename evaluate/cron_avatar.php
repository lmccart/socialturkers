
<?php

	
	//Include database connection details
	require_once('config.php');
	require('/home/lleemac/socialturkers.com/tmhOAuth/tmhOAuth.php');
	require('/home/lleemac/socialturkers.com/tmhOAuth/tmhUtilities.php');

	session_start();
	
	
	$table = "turkers_011113"; // update
	
	
	$qry = "SELECT * FROM ".$table." WHERE timestamp BETWEEN DATE_SUB(NOW() , INTERVAL 10 MINUTE) AND NOW()";
	$res = mysql_query($qry);
	
	if ($res) {
		$vals = array("advance" => 0, "back" => 0, "side" => 0, "question" => 0, "agree" => 0, "disagree" => 0, "smile" => 0, "laugh" => 0, "challenge" => 0, "other" => 0);
		while($row = mysql_fetch_array($res)){
			$vals[$row['action']]++;
		}
	}

	
	// only send msg if someone has voted
	if (max(array_values($vals)) == 0) {
		send_msg('none');
	} else {
		$max_action = array_search(max($vals), $vals);
		send_msg(strtoupper($max_action));
	}


	function send_msg($msg) {
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => CONSUMER_KEY,
		  'consumer_secret' => CONSUMER_SECRET,
		  'user_token'      => USER_TOKEN,
		  'user_secret'     => USER_SECRET,
		));
		
		$tweetmsg = '@sotur1 '.$msg.' '.time(); // add time for distinct msgs
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
		  'status' => $tweetmsg
		));
		
		echo($msg);
	
		mail('6173088817@messaging.sprintpcs.com', '', $msg);  
		//mail('laurmccarthy@gmail.com', '', $msg);  
	}
?>
<header>
<meta http-equiv="refresh" content="600">
</header>
