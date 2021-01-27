<?php
    require 'config.php';
    if(!isset($_POST["name"]) || empty($_POST["name"]) || !isset($_POST["image_url"]) || empty($_POST["image_url"]) || !isset($_POST["id"]) || empty($_POST["id"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$stmt = $mysqli->prepare("UPDATE restaurants SET name = ?, image_url = ? WHERE id = ?");
		$stmt->bind_param("ssi", $_POST["name"], $_POST["image_url"], $_POST["id"]);
		$stmt->execute();
		if($stmt->affected_rows != 1){
			echo "error";
		}
		$stmt->close();
		$mysqli->close();
	}
?>