<?php
    require 'config.php';
    if(!isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["password"]) || empty($_POST["password"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$sql = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "' AND password = '" . $_POST["password"] . "'";
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
		$user = $results->fetch_assoc();
		if($mysqli->affected_rows == 1){
			$_SESSION["email"] = $user["email"];
			$_SESSION["name"] = $user["name"];
			$_SESSION["user_id"] = $user["id"];
			$_SESSION["date_joined"] = $user["date_joined"];
			if($user["admin"] == 1){
				$_SESSION["is_admin"] = $user["admin"];
			}
		}
		else{
			echo "error";
		}
		$mysqli->close();	
	}
?>