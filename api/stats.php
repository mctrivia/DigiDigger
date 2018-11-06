<?php
	require_once('~server.php');
	ignore_user_abort(true);
	set_time_limit(0);
	
	//get data
	echo file_get_contents(SERVER."stats.json");