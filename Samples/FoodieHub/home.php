<?php 
	require 'config.php';
	$mysqli = new mysqli($host, $user, $pass, $db);
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}
	$mysqli->set_charset('utf8');
	$sql = "SELECT * FROM restaurants";
	$results = $mysqli->query($sql);
	if(!$results){
		echo $mysqli->error;
		exit();
	}
	$mysqli->close();
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
    	#header{
    		width: 100%;
    		min-height: calc(100vh - 63px);
    		background: linear-gradient(
					      rgba(0, 0, 0, 0.3),
					      rgba(0, 0, 0, 0.3)
					    ), url(food.jpg);
    		background-size: cover;
    		background-position: left;
    	}
    	#title{
    		text-align: center;
    		line-height: 740px;
    		font-family: 'Courgette', cursive;
    		font-size: 5em;
    		color: white;
    		text-shadow: 2px 1px 4px black;
    	}
		.img-container{
			position: relative;
			height: 160px;
			width: auto;
			overflow: hidden;
		}
		.img-container img{
			box-shadow: 0px 0px 1px grey;
			border-radius: 4px;
		}
		.img-container .overlay{
			background-color: rgba(0, 0, 0, 0.6);
			color: white;
			position: absolute;
			top: 0px;
			right: 0px;
			bottom: 0px;
			left: 0px;
			opacity: 0;
			transition: opacity 1s 0s;
		}
		.img-container:hover .overlay{
			opacity: 1;
		}
		.img-container p{
			position: absolute;
			top: 40px;
			text-align: center;
			width: 100%;
			font-size: 3em;
			transform: scale(1);
			transform: rotate(-15deg);
			transition: transform 1s 0s;
			font-family: 'Courgette', cursive;
			overflow: hidden;
		}
		.img-container:hover p{
			transform: scale(0.8);
		}
    </style>
	<title>FoodieHub Home Page</title>
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
	<div id="header" class="rellax">
		<div id="title">
			<span>FoodieHub</span>
		</div>
	</div>
	<div class="container text-center">
		<div class="row justify-content-center mt-5 mb-3">
			<div class="col-8 col-md-5">
				<h1 class="sub-header">All Restaurants</h1>
			</div>
		</div>
		<div class="row pb-5 px-3 px-sm-0" id="restaurant-container">
		<?php while($row = $results->fetch_assoc()): ?>
			<div class="col-6 col-md-4 col-lg-3 my-4">
				<div class="img-container mb-2">
					<a href="restaurant.php?restaurant_id=<?php echo $row["id"] ?>">
						<img class="img-fluid" src="<?php echo $row["image_url"] ?>" alt="restaurant-pic">
						<div class="overlay">
							<p><?php echo $row["name"] ?></p>
						</div>
					</a>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
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
</body>
</html>