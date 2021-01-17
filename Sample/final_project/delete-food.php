<?php 
	require 'config.php';
	if(!isset($_POST["food_id"]) || empty($_POST["food_id"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$stmt = $mysqli->prepare("DELETE FROM foods WHERE id=?");
		$stmt->bind_param("i", $_POST["food_id"]);
		$stmt->execute();
		if($stmt->affected_rows != 1){
			echo "error";
		}
		$stmt->close();
		$mysqli->close();
	}
?>