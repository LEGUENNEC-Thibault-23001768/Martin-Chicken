<?php
	$db_addr = "";
	$db_login = "";
	$db_pass = "";
	$db_name = "";

	try {
		$db_conn = mysqli_connect($db_addr,$db_login, $db_pass, $db_name);
		
	} catch (Exception $e) {
		//echo "". $e->getMessage();
	}


	echo "ee";
?>