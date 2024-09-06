<?php
	include "database.php";

	$conn = Database::getInstance();

	//var_dump($conn);

	$sql = "SHOW TABLES FROM `" . DB_NAME . "`";
	
	$result = $conn->query($sql);

	if(!$result){
		die('MySQL error: ' . mysqli_error($conn));
	}

	while ($row = $result->fetch_row()) {
		//var_dump($row);
		//echo "- {$row[0]}\n </br>";
	}

	$result->close();
	$conn->close();

	phpinfo();
	var_dump($_SERVER);
	
?>