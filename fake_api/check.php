<?php
	session_start();
	require_once('~server.php');
	ignore_user_abort(true);
	set_time_limit(0);
	
	//validate input
	if (!isset($_GET['wallet'],$_GET['x'],$_GET['y'])) {
		echo json_encode(array(
			"error"=>	"Missing Input"
		));die();		
	}
	$x=$_GET['x'];
	if (!is_numeric($x)) {
		echo json_encode(array(
			"error"=>	"x out of range"
		));die();
	}
	$x=$x+0;
	if (($x<0)||($x>511)) {
		echo json_encode(array(
			"error"=>	"x out of range"
		));die();
	}
	
	$y=$_GET['y'];
	if (!is_numeric($y)) {
		echo json_encode(array(
			"error"=>	"y out of range"
		));die();
	}
	$y=$y+0;
	if (($y<0)||($y>511)) {
		echo json_encode(array(
			"error"=>	"y out of range"
		));die();
	}
	$address=$_GET['wallet'];	
	
	//get data
	$ch=curl_init(SERVER."stats.json");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch,CURLOPT_COOKIE,"PHPSESSID={$_COOKIE['PHPSESSID']}; path=/");
	$data=json_decode(curl_exec($ch),true);
	curl_close($ch);
	
	$odds=$data['odds'];
	$index=-1;
	$offset=rand(0,1023);
	do {
		$index++;
		$offset-=$odds[$index];
	} while ($offset>0);
	if ($index==0) {
		echo "0";
	} else {
		echo pow(10,$index/10)/100000000;
	}