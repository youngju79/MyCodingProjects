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
		$sql2 = "SELECT * FROM foods WHERE restaurant_id =" . $_GET["restaurant_id"];
		$results = $mysqli->query($sql);
		$results2 = $mysqli->query($sql2);
		if(!$results || !$results2){
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
    	.sub-header{
    		font-size: 2.5em;
    	}
		#cart{
			padding: 20px;
			box-shadow: 0px 0px 1px black;
			border-radius: 4px;
			background-color: white;
		}
		.trash-button{
			margin-left: 5px;
			width: 17px;
		}
		.trash-button:hover{
			cursor: pointer;
		}
		.hidden{
			display: none;
		}
		#menu th{
			border: none;
		}
    </style>
	<title>FoodieHub Restaurant Page</title>
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
	<div class="container-lg text-center">
	<?php if(isset($error) && !empty($error)): ?>
		<div class="row justify-content-center mt-5 mb-3">
			<div class="col-md-6">
				<h1 class="sub-header"><?php echo $error ?></h1>
			</div>
		</div>
	<?php else: ?>
		<div class="row justify-content-center mt-5 mb-3">
			<div class="col-8">
				<div id="success-alert" class="alert alert-success alert-dismissible fade show hidden" role="alert">
					<strong>Success!</strong> The order has been placed.
					<button id="dismiss-btn" type="button" class="close">
				    	<span>&times;</span>
					</button>
				</div>
			</div>
		</div>
	<?php if(isset($_SESSION["is_admin"])): ?>
		<div class="row justify-content-center px-3 px-lg-0 pt-4">
			<div class="col-md-8">
	<?php else: ?>
		<div class="row justify-content-between px-3 px-lg-0 pt-4">
			<div class="col-md-7">
	<?php endif; ?>
				<table class="table table-striped table-hover" id="menu">
					<thead>
						<tr>
							<th>
							<?php if(isset($_SESSION["is_admin"])): ?>
								<a href="edit-restaurant.php?restaurant_id=<?php echo $restaurant["id"] ?>" class="btn btn-outline-primary my-2">Edit</a>
							<?php endif; ?></th>
							<th>
								<h1 id="restaurant" class="sub-header my-2" data-id="<?php echo $restaurant["id"] ?>"><?php echo $restaurant["name"] ?></h1>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php if(isset($_SESSION["is_admin"])): ?>
						<tr>
							<td><button type="button" id="add-item" class="btn btn-success">+</button></td>
							<td><input id="name-input" type="text"></td>
							<td><input id="price-input" type="text"></td>
						</tr>
					<?php endif; ?>
					<?php while($row = $results2->fetch_assoc()): ?>
						<tr>
						<?php if(isset($_SESSION["is_admin"])): ?>
							<td><button type="button" class="btn btn-danger delete-item" data-id="<?php echo $row["id"] ?>">-</button></td>
						<?php else: ?>
							<td><button type="button" class="btn btn-outline-danger add-button" data-name="<?php echo $row["name"] ?>" data-price="<?php echo $row["price"] ?>" data-id="<?php echo $row["id"] ?>">Add</button></td>
						<?php endif; ?>
							<td><?php echo $row["name"] ?></td>
							<td><?php echo $row["price"] ?></td>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		<?php if(!isset($_SESSION["is_admin"])): ?>
			<div class="col-md-4 pt-5 mt-md-5 mx-5 mx-md-0">
				<div id="cart">
					<h3 class="mb-4">Your order</h3>
					<div id="cart-body" class="mb-4"></div>
					<span id="total">Total = $0.00</span>
				<?php if(isset($_SESSION["email"])): ?>
					<button id="checkout-btn" class="btn btn-danger mt-2 w-100">Checkout</button>
				<?php else: ?>
					<p class="text-danger mt-1">Must be logged in to order.</p>
				<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		</div>
	<?php endif; ?>
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
		let cart = {};
		let total = 0;
		let add_button = document.querySelectorAll(".add-button");
		for (let i = 0; i < add_button.length; i++) {
			add_button[i].onclick = function(){
				if(this.dataset.id in cart){
					let quantity = cart[this.dataset.id]["quantity"] + 1;
					cart[this.dataset.id]["quantity"] = quantity;
					document.querySelector(".quantity" + this.dataset.id).innerHTML = quantity;
				}
				else{
					cart[this.dataset.id] = {
						quantity: 1
					};
					let divElem = document.createElement("div");
					divElem.classList.add("d-flex");
					divElem.classList.add(this.dataset.id);
					let quantityElem = document.createElement("span");
					quantityElem.classList.add("quantity" + this.dataset.id);
					quantityElem.innerHTML = "1";
					let nameElem = document.createElement("span");
					nameElem.innerHTML = " x " + this.dataset.name;
					let trashElem = document.createElement("img");
					trashElem.setAttribute("src", "trash-icon.svg");
					trashElem.setAttribute("alt", "trashcan");
					trashElem.setAttribute("data-id", this.dataset.id);
					trashElem.setAttribute("data-price", this.dataset.price);
					trashElem.classList.add("trash-button");
					trashElem.onclick = function(){
						let quantity = cart[this.dataset.id]["quantity"] - 1;
						if(quantity == 0){
							delete cart[this.dataset.id];
							this.parentElement.remove();
						}
						else{
							cart[this.dataset.id]["quantity"] = quantity;
							document.querySelector(".quantity" + this.dataset.id).innerHTML = quantity;
						}
						total -= parseFloat(this.dataset.price);
						if(total.toFixed(2) == 0){
							total = 0;
						}
						document.querySelector("#total").innerHTML = "Total = $" + total.toFixed(2);
					}
					let priceElem = document.createElement("span");
					priceElem.classList.add("ml-auto");
					priceElem.innerHTML = "$" + this.dataset.price;
					divElem.appendChild(quantityElem);
					divElem.appendChild(nameElem);
					divElem.appendChild(trashElem);
					divElem.appendChild(priceElem);
					document.querySelector("#cart-body").appendChild(divElem);

				}
				total += parseFloat(this.dataset.price);
				document.querySelector("#total").innerHTML = "Total = $" + total.toFixed(2);
			}
		}
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
		if(document.querySelector("#checkout-btn") != null){
			document.querySelector("#checkout-btn").onclick = function(){
				let id = document.querySelector("#restaurant").dataset.id;
				if(total != 0){
					let data = "total=" + total.toFixed(2) + "&restaurant_id=" + id;
					ajaxPost("add-order.php", data, function(results){
						if(results == "error"){
							alert("Order has not been successfully placed.");
						}
						else{
							document.querySelector("#success-alert").classList.remove("hidden");
							total = 0;
							document.querySelector("#total").innerHTML = "Total = $" + total.toFixed(2);
							cart = {};
							document.querySelector("#cart-body").innerHTML = "";
						}
					})
				}
			}
		}
		if(document.querySelector("#add-item") != null){
			document.querySelector("#add-item").onclick = function(){
				let food_name = document.querySelector("#name-input").value.trim();
				let food_price = document.querySelector("#price-input").value.trim();
				let id = document.querySelector("#restaurant").dataset.id;
				if(food_name.length != 0 && food_price.length != 0){
					let data = "food_name=" + food_name + "&food_price=" + food_price + "&restaurant_id=" + id;
					ajaxPost("add-food.php", data, function(results){
						if(results == "error"){
							alert("Food has not been successfully added.");
						}
						else{
							location.reload(true);
						}
					})
				}
			}
		}
		if(document.querySelector(".delete-item") != null){
			let delete_item = document.querySelectorAll(".delete-item");
			for (let i = 0; i < delete_item.length; i++) {
				delete_item[i].onclick = function(){
					let data = "food_id=" + this.dataset.id;
					ajaxPost("delete-food.php", data, function(results){
						if(results == "error"){
							console.log("Food has not been successfully deleted.");
						}
						else{
							location.reload(true);
						}
					})
				}
			}
		}
		document.querySelector("#dismiss-btn").onclick = function(){
			document.querySelector("#success-alert").classList.add("hidden");
		}
	</script>
</body>
</html>