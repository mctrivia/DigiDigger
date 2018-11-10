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
	
	//get data just in case you sent funds so they don't get burnt.
	$site=SITE_WALLET;
	try {	//we don't care if there is an error there shouldn't be funds anyways
		$ch=curl_init(SERVER."fund.php?pkey={$pkey}&address={$address}&site={$site}");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch,CURLOPT_COOKIE,"PHPSESSID={$_COOKIE['PHPSESSID']}; path=/");
		curl_close($ch);
	} catch (Exception $e) {
	}
	echo "100";