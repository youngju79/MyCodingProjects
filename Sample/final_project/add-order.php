<?php 
	require 'config.php';
	if(!isset($_POST["restaurant_id"]) || empty($_POST["restaurant_id"]) || !isset($_POST["total"]) || empty($_POST["total"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		date_default_timezone_set('America/Los_Angeles');
		$stmt = $mysqli->prepare("INSERT INTO orders(customer_id, restaurant_id, date, cost) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("iisd", $_SESSION["user_id"], $_POST["restaurant_id"], date('Y-m-d H:i:s'), $_POST["total"]);
		$stmt->execute();
		if($stmt->affected_rows != 1){
			echo "error";
		}
		$stmt->close();
		$mysqli->close();
	}
?>