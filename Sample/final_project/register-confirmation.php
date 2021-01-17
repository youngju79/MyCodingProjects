<?php 
	require 'config.php';
	if(!isset($_POST["email"]) || empty($_POST["email"]) || !isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["fname"]) || empty($_POST["fname"]) || !isset($_POST["lname"]) || empty($_POST["lname"])){
		echo "error";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$sql = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "'";
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
		$user = $results->fetch_assoc();
		if($mysqli->affected_rows == 1){
			echo "error";
		}
		else{
			date_default_timezone_set('America/Los_Angeles');
			$name = $_POST["fname"] . " " . $_POST["lname"];
			$stmt = $mysqli->prepare("INSERT INTO users(name, email, password, date_joined) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss", $name, $_POST["email"], $_POST["password"], date('Y-m-d'));
			$stmt->execute();
			if($stmt->affected_rows == 1){
				$_SESSION["email"] = $_POST["email"];
				$_SESSION["name"] = $name;
				$sql = "SELECT * FROM users WHERE email = '" . $_POST["email"] . "'";
				$results = $mysqli->query($sql);
				$user = $results->fetch_assoc();
				if($mysqli->affected_rows != 1){
					echo "error";
				}
				$_SESSION["user_id"] = $user["id"];
				$_SESSION["date_joined"] = $user["date_joined"];
				if($user["admin"] == 1){
					$_SESSION["is_admin"] = $user["admin"];
				}
			}
			else{
				echo "error";
			}
			$stmt->close();
		}
		$mysqli->close();
	}
?>