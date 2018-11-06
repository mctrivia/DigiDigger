<?php
	session_start();
	require_once('~server.php');

	//make sure pkey is present
	if (!isset($_GET['pkey'],$_GET['address'])) {
		echo json_encode(array(
			"error"=>	"Missing Input"
		));die();	
	}
	$pkey=$_GET['pkey'];
	$address=$_GET['address'];	
	
	//get data
	$site=SITE_WALLET;
	$ch=curl_init(SERVER."fund.php?pkey={$pkey}&address={$address}&site={$site}");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch,CURLOPT_COOKIE,"PHPSESSID={$_COOKIE['PHPSESSID']}; path=/");
	echo curl_exec($ch);
	curl_close($ch);