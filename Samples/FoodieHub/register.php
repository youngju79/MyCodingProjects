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
		  	background-color: #f5f5f5;
		}
    </style>
	<title>FoodieHub Register Page</title>
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
					<a class="nav-link" href="home.php">Home</a>
					<?php if(isset($_SESSION["email"])): ?>
						<a class="nav-link" href="profile.php">Profile</a>
						<a class="nav-link" href="logout.php">Logout</a>
					<?php else: ?>
						<a class="nav-link active" href="login.php">Login/Register</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
	<div class="container">
		<div class="row justify-content-center mt-5">
			<div class="col-8 col-lg-5 mt-5" id="form-container">
				<form id="register-form" class="my-4">
					<h1 class="h3 mb-3 font-weight-normal">Create account</h1>
					<div id="error-msg"></div>
					<div class="form-row mb-3">
						<div class="col-md-6">
							<label for="inputfName">First Name</label>
							<input type="text" id="inputfName" name="fname" class="form-control" autofocus>
						</div>
						<div class="col-md-6">
							<label for="inputlName">Last Name</label>
							<input type="text" id="inputlName" name="lname" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail">Email</label>
						<input type="email" id="inputEmail" name="email" class="form-control">
					</div>
					<div class="form-group">
						<label for="inputPassword">Password</label>
						<input type="password" id="inputPassword" name="password" class="form-control">
					</div>
					<a class="text-secondary" href="login.php">Already have an account?</a>
					<button class="btn btn-lg btn-warning btn-block my-3" type="submit">Create your account</button>
				</form>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<span class="text-muted">© 2020 FoodieHub, Inc.</span>
		</div>
	</footer>
	<!-- JavaScript Tags !-->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
		};
		document.querySelector("#register-form").onsubmit = function(event){
			let email = document.querySelector("#inputEmail").value.trim();
			let password = document.querySelector("#inputPassword").value.trim();
			let fname = document.querySelector("#inputfName").value.trim();
			let lname = document.querySelector("#inputlName").value.trim();
			if(email.length == 0 || password.length == 0 || fname.length == 0 || lname.length == 0){
				document.querySelector("#error-msg").innerHTML = "Please fill in all the required information.";
			}
			else{
				let data = "email=" + email + "&password=" + password + "&fname=" + fname + "&lname=" + lname;
				ajaxPost("register-confirmation.php", data, function(results){
					if(results == "error"){
						document.querySelector("#error-msg").innerHTML = "This email address is already taken.";
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