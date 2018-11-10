<?php
	require_once('~server.php');
	ignore_user_abort(true);
	set_time_limit(0);
	
	//get data
	$fileName=SERVER."stats.json";
	if (file_exists('../stats.json')) $fileName='../stats.json';
	echo file_get_contents($fileName);