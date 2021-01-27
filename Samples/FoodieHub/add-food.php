<?php 
	require 'config.php';
	if(!isset($_POST["food_name"]) || empty($_POST["food_name"]) || !isset($_POST["food_price"]) || empty($_POST["food_price"]) || !isset($_POST["restaurant_id"]) || empty($_POST["restaurant_id"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$stmt = $mysqli->prepare("INSERT INTO foods(name, price, restaurant_id) VALUES (?, ?, ?)");
		$stmt->bind_param("sdi", $_POST["food_name"], $_POST["food_price"], $_POST["restaurant_id"]);
		$stmt->execute();
		if($stmt->affected_rows != 1){
			echo "error";
		}
		$stmt->close();
		$mysqli->close();
	}
?>