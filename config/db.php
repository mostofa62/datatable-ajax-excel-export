<?php 
	//date_default_timezone_set("Asia/Kuala_Lumpur");
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbName = "backoffice";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbName);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

?>