<?php 
	require 'config.php';
	if(!isset($_SESSION["user_id"])){
		$error = "A user is not signed in.";
	}
	else{
		$mysqli = new mysqli($host, $user, $pass, $db);
		if($mysqli->connect_errno){
			echo $mysqli->connect_error;
			exit();
		}
		$mysqli->set_charset('utf8');
		$sql = "SELECT name, cost, date FROM orders
				JOIN restaurants
					ON restaurants.id = orders.restaurant_id
				WHERE orders.customer_id = " . $_SESSION["user_id"] . " ORDER BY date DESC";
		$results = $mysqli->query($sql);
		if(!$results){
			echo $mysqli->error;
			exit();
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
		#profile-img{
			width: 50%;
		}
    </style>
	<title>FoodieHub Profile Page</title>
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
						<a class="nav-link active" href="profile.php">Profile</a>
						<a class="nav-link" href="logout.php">Logout</a>
					<?php else: ?>
						<a class="nav-link" href="login.php">Login/Register</a>
					<?php endif; ?>
				</div>
			</div>
		</nav>
	</div>
<?php if(isset($error) && !empty($error)): ?>
	<div class="row justify-content-center mt-5 mb-3">
		<div class="col-md-6">
			<h1 class="sub-header"><?php echo $error ?></h1>
		</div>
	</div>
<?php else: ?>
	<div class="container">
		<div class="row justify-content-center text-center mt-5 mb-3">
			<div class="col-md-6">
				<h1 class="sub-header">
				<?php if(isset($_SESSION["is_admin"])): ?>
					Admin
				<?php endif; ?>
					Profile Page
				</h1>
			</div>
		</div>
		<div class="row justify-content-center text-center mb-4">
		<?php if(isset($_SESSION["is_admin"])): ?>
			<div class="col-12">
				<img class="rounded-circle w-25" id="profile-img" src="https://www.exstrompt.com/wp-content/uploads/2015/07/placeholder-user.jpg">
			</div>
			<div class="col-12 pt-3 pt-lg-5">
				<p>Name: <?php echo $_SESSION["name"] ?></p>
				<p>Email: <?php echo $_SESSION["email"] ?></p>
				<p>Joined <?php echo $_SESSION["date_joined"] ?></p>
			</div>
		<?php else: ?>
			<div class="col-md-5 text-md-right">
				<img class="rounded-circle w-50" id="profile-img" src="https://www.exstrompt.com/wp-content/uploads/2015/07/placeholder-user.jpg">
			</div>
			<div class="col-md-6 text-md-left pt-3 pt-lg-5">
				<p>Name: <?php echo $_SESSION["name"] ?></p>
				<p>Email: <?php echo $_SESSION["email"] ?></p>
				<p>Joined <?php echo $_SESSION["date_joined"] ?></p>
			</div>
		<?php endif; ?>
		</div>
	<?php if(!isset($_SESSION["is_admin"])): ?>
		<hr>
		<div class="row justify-content-center text-center mt-4">
			<div class="col-md-6">
				<h1 class="sub-header">Past Orders</h1>
			</div>
		</div>
		<div class="row text-center mt-3 px-3" id="order-container">
			<table class="table table-bordered mb-5">
				<tr>
					<th>Restaurant Name</th>
					<th>Total</th>
					<th>Order Date</th>
				</tr>
			<?php while($row = $results->fetch_assoc()): ?>
				<tr>
					<td><?php echo $row["name"] ?></td>
					<td><?php echo $row["cost"] ?></td>
					<td><?php echo $row["date"] ?></td>
				</tr>  
			<?php endwhile; ?>
			</table>
		</div>
	<?php endif; ?>
	</div>
<?php endif; ?>
	<footer class="footer">
		<div class="container">
			<span class="text-muted">© 2020 FoodieHub, Inc.</span>
		</div>
	</footer>
	<!-- JavaScript Tags !-->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>