<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>

	<style>
		body {
			background-color: black;
			color: white;
			margin: 0px;
			padding: 0px;
			font-family: "Helvetica", sans-serif;
		}
		p {
			margin: 0px;
			padding: 0px;
		}
		h1 {
			padding-top: 100px;
			text-align: center;
		}
		h2 {
			text-align: center;
		}
		a {
			color: gray;
			text-decoration: none;
			transition: all 200ms;
		}
		a:hover {
			color: white;
		}
		#login-container {
			width: 300px;
			height: 400px;
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -200px;
			margin-left: -150px;
		}
		form label {
			width: 300px;
			color: lightgray;
		}
		#username, #password {
			color: white;
			font-size: 1.3em;
			background-color: black;
			border: none;
			border-bottom: 1px solid lightgray;

			padding: 0px;
			margin-bottom: 30px;

			outline: none;
			-webkit-appearance: none;
			-webkit-box-shadow: none;
			box-shadow: none;

			height: 38px;
			width: 300px;
		}
		#username:focus, #password:focus {
			border-bottom: 2px solid white;
		}
		form button {
			color: white;
			width: 90px;
			height: 40px;
			font-size: 1.2em;
			background-color: black;
			border: 2px solid white;
			transition: all 200ms;
		}
		form button:hover {
			background-color: white;
			color: black;
		}
	</style>
	
	<script>
	
	function validate(){
		
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "Login?username=" + document.regis.username.value + "&password=" + document.regis.password.value , false);
		xhttp.send();
		if (xhttp.responseText.trim().length > 0) {
			
			document.getElementById("youGoofed").innerHTML = xhttp.responseText;
			return false; 
		}
		
		
		return true;
	}
function validate2(){
		
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "Login?username=guest&password=guest" , false);
		xhttp.send();
		if (xhttp.responseText.trim().length > 0) {
			
			document.getElementById("youGoofed").innerHTML = xhttp.responseText;
			return false; 
		}
		
		
		return true;
	}
	
	</script>
</head>

<body>
	<h1>SilC Road</h1>
	<div id="login-container">
		<h2>Login</h2> <br>
		
		<h3 id="youGoofed"></h3>
		<form name="regis" method="GET" action="homepage.jsp" onsubmit="return validate();">
			<label for="username">Username</label> <br>
			<input id="username" type="text" name="username" required> <br>
			<label for="password">Password</label> <br>
			<input id="password" type="password" name="passowrd" required>
			<button type="submit" name="login" value="login">LOGIN</button>
		</form>
		<br>
		<p>Don't have an account yet? <a href="register.jsp">REGISTER</a></p>
		<p>Or log in as a guest? <a href="Login?username=guest&password=guest"> GUEST</a> </p>

	</div> <!-- #login-container -->
</body>
</html>