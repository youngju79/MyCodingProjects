<?php 
	require 'config.php';
	if(!isset($_GET["restaurant_id"]) || empty($_GET["restaurant_id"])){
		$error = "Restaurant is invalid.";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$sql = "SELECT * FROM restaurants WHERE id =" . $_GET["restaurant_id"];
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
		}
		$restaurant = $results->fetch_assoc();
		if(!$restaurant){
			$error = "Restaurant is invalid.";
		}
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
   	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    
    <style>
		body{
		  	background-color: #f5f5f5
		}
    </style>
	<title>FoodieHub Update Restaurant Page</title>
</head>
<body>
	<div id="red-container">
		<nav class="navbar sticky-top navbar-expand-md navbar-dark">
			<a class="navbar-brand" id="brand" href="home.php">FoodieHub</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<div class="navbar-nav ml-auto">
					<a class="nav-link active" href="home.php">Home</a>
					<?php if(isset($_SESSION["email"])): ?>
						<a class="nav-link" href="profile.php">Profile</a>
						<a class="nav-link" href="logout.php">Logout</a>
					<?php else: ?>
						<a class="nav-link" href="login.php">Login/Register</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
	<div class="container">
	<?php if(isset($error) && !empty($error)): ?>
		<div class="row justify-content-center mt-5 mb-3">
			<div class="col-md-6">
				<h1 class="sub-header"><?php echo $error ?></h1>
			</div>
		</div>
	<?php else: ?>
		<div class="row justify-content-center mt-5">
			<div class="col-8 col-lg-5 mt-5" id="form-container">
				<form id="update-form" class="my-4">
					<h1 class="h3 mb-3 font-weight-normal">Edit Restaurant Information</h1>
					<div id="error-msg"></div>
					<div class="form-group">
						<label for="inputName">Name</label>
						<input type="text" id="inputName" class="form-control" value="<?php echo $restaurant["name"] ?>" autofocus>
					</div>
					<div class="form-group">
						<label for="inputUrl">Image URL</label>
						<input type="text" id="inputUrl" class="form-control" value="<?php echo $restaurant["image_url"] ?>">
					</div>
					<input type="hidden" id="inputID" value="<?php echo $restaurant["id"] ?>">
					<button class="btn btn-lg btn-primary btn-block my-3" type="submit">Update</button>
				</form>
			</div>
		</div>
	<?php endif; ?>
	</div>
	<footer class="footer">
		<div class="container">
			<span class="text-muted">© 2020 FoodieHub, Inc.</span>
		</div>
	</footer>
	<!-- JavaScript Tags !-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script>
		function ajaxPost(endpointUrl, data, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('POST', endpointUrl, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE){
					if (xhr.status == 200){
						returnFunction(xhr.responseText);
					} 
					else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send(data);
		}
		document.querySelector("#update-form").onsubmit = function(event){
			let name = document.querySelector("#inputName").value.trim();
			let url = document.querySelector("#inputUrl").value.trim();
			let id = document.querySelector("#inputID").value.trim();
			if(name.length == 0 || url.length == 0){
				document.querySelector("#error-msg").innerHTML = "Please fill in all the required information.";
			}
			else{
				let data = "name=" + name + "&image_url=" + url + "&id=" + id;
				ajaxPost("edit-confirmation.php", data, function(results){
					if(results == "error"){
						alert("There has been an error. Must change values")
					}
					else{
						window.location.replace("home.php");
					}
				})
			}
			event.preventDefault();
		}
	</script>
</body>
</html>