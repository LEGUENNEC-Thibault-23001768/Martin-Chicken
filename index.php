<?php

	$db_addr = "mysql-martin-chicken.alwaysdata.net";
	$db_login = "374927";
	$db_pass = "lechatrouge";
	$db_name = "martin-chicken_db";


	try {
		$conn = new mysqli($db_addr, $db_login, $db_pass, $db_name);
	} catch (mysqli_sql_exception $e) {
		die("". $e->getMessage());
	}

	var_dump($conn);

	$sql = "SHOW TABLES FROM `" . $db_name . "`";
	
	$result = $conn->query($sql);

	if(!$result){
		die('MySQL error: ' . mysqli_error($conn));
	}

	while ($row = $result->fetch_row()) {
		var_dump($row);
		//echo "- {$row[0]}\n </br>";
	}

	$result->close();
	$conn->close();
?>