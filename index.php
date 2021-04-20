<!DOCTYPE html>
<html lang="en">
<head>
	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Typing CSS -->
    <link rel="stylesheet" href="typing.js-master/text-cursor.css">

	<title>Youngju Shin | Portfolio</title>
	<style>
		#header {
            height: 100vh;
            text-align: center;
            background: linear-gradient(
                  rgba(0, 0, 0, 0.5),
                  rgba(0, 0, 0, 0.5)
                ),
                url("img/nature.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
		#thumbnail{
			width: 200px;
			height: auto;
			border-radius: 50%;
		}
		#usc-text{
			color: #c41e3a;
		}
		.logo, .logo:hover{
		   color: white;
		   text-decoration: none;
		}
		#intro-box{
			width: 650px;
			background-color:#000;
			opacity: 0.9;
			border-radius: 10px;
		}
		.project-description{
			display: flex;
            align-items: center;
            justify-content: center;
		}
	</style>
</head>
<body>
	<div id="header">
        <div class="mx-5">
        	<img id="thumbnail" src="img/me.jpg" class="my-3" alt="me">
            <p class="fs-1 fw-bold mb-1">Youngju Shin</p>
            <p class="fs-5"><span id="usc-text" class="fw-bold">USC</span> | <span style="color: #FFCC00">College Student</span></p>
            <div class="my-4">
            	<a class="logo mx-2" href="https://www.linkedin.com/in/yong-shin-b2541a170/" target="_blank">
            		<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
						<path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
					</svg>
				</a>
				<a class="logo mx-2" href="mailto:yongzush@usc.edu">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
						<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
					</svg>
				</a>
				<a class="logo mx-2" href="https://github.com/youngju79/My-Sample-Codes" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
						<path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
					</svg>
				</a>
            </div>
        </div>
        <div id="intro-box" class="mx-5 p-4 text-start fs-2">
        	<p id="line1" class="hidden">Hi, welcome to my personal page!</p>
        	<p id="line2" class="hidden">I am currently a junior studying computer science at USC, and I love to create websites on the side.</p>
        	<p id="line3" class="hidden">Please feel free to reach out to me :)</p>
        	<p id="cursor-line" class="visible">&gt;&gt; <span class="typed-cursor">&#9608;</span></p>
        </div>
    </div>
    <div class="container">
    	<div class="row">
    		<p class="col-12 fs-1 fw-bold my-5 text-center">Sample Projects</p>
    		<hr>
    		<!-- FoodieHub -->
    		<div class="col-8 my-5">
			    <div id="carousel-1" class="carousel slide border border-dark" data-bs-interval="false">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carousel-1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#carousel-1" data-bs-slide-to="1" aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#carousel-1" data-bs-slide-to="2" aria-label="Slide 3"></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="img/foodiehub-homepage.png" class="d-block w-100" alt="homepage">
						</div>
						<div class="carousel-item">
							<img src="img/foodiehub-restaurants.png" class="d-block w-100" alt="restaurants">
						</div>
						<div class="carousel-item carousel-dark">
							<img src="img/foodiehub-menu.png" class="d-block w-100" alt="menu">
							<div class="carousel-caption d-none d-md-block">
								<h5>Interactive menu and cart using javascript</h5>
								<p>Customers who are logged in are allowed to add food to the cart. The cart's items and total price is updated dynamically. The customer can choose to purchase which adds the order to his/her purchase history</p>
							</div>
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-1" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-1" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
				<div class="text-center mt-4">
					<a href="Samples/FoodieHub/home.php"><button type="button" class="btn btn-danger">Demo</button></a>
					<a class="link-primary" href="https://github.com/youngju79/My-Sample-Codes/tree/master/Samples/FoodieHub"><button type="button" class="btn btn-danger">Code</button></a>
				</div>
		    </div>
		    <div class="col-4 my-5 project-description">
		    	<div class="ms-5">
		    		<h5 class="fs-3 fw-bold">FoodieHub</h5>
					<p class="fs-5">FoodieHub is a food delivery web app that allows registered customers to buy food from restaurants. Implemented with responsive design for mobile and dekstop. <u>Utilized</u>: html, css, javascript, php, boostrap.</p>
		    	</div>
		    </div>
		    <hr>
		    <!-- Eggsellent -->
		    <div class="col-8 my-5">
				<div id="carousel-2" class="carousel slide border border-dark" data-bs-interval="false">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carousel-2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#carousel-2" data-bs-slide-to="1" aria-label="Slide 2"></button>
						<button type="button" data-bs-target="#carousel-2" data-bs-slide-to="2" aria-label="Slide 3"></button>
						<button type="button" data-bs-target="#carousel-2" data-bs-slide-to="3" aria-label="Slide 4"></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="img/eggsellent-homepage.png" class="d-block w-100" alt="homepage">
						</div>
						<div class="carousel-item">
							<img src="img/eggsellent-nutrition.png" class="d-block w-100" alt="nutrition">
						</div>
						<div class="carousel-item">
							<img src="img/eggsellent-recipes.png" class="d-block w-100" alt="recipes">
						</div>
						<div class="carousel-item">
							<img src="img/eggsellent-modal.png" class="d-block w-100" alt="modal">
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-2" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-2" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			    <div class="text-center mt-4">
					<a href="Samples/Eggsellent/HomePage.html"><button type="button" class="btn btn-dark">Demo</button></a>
					<a href="https://github.com/youngju79/My-Sample-Codes/tree/master/Samples/Eggsellent"><button type="button" class="btn btn-dark">Code</button></a>
				</div>
		    </div>
		    <div class="col-4 my-5 project-description">
		    	<div class="ms-5">
		    		<h5 class="fs-3 fw-bold">Eggsellent</h5>
					<p class="fs-5">Eggsellent is a sample front-end web app that is intended to illustrate promotional content. <u>Utilized</u>: html, css, boostrap.</p>
		    	</div>
		    </div>
		    <hr>
		    <!-- MovieDB -->
		    <div class="col-8 my-5">
				<div id="carousel-3" class="carousel border border-dark" data-bs-interval="false">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="img/moviedb-homepage.png" class="d-block w-100" alt="homepage">
						</div>
					</div>
				</div>
			    <div class="text-center mt-4">
					<a href="Samples/MovieDB/moviedb.html"><button type="button" class="btn btn-primary">Demo</button></a>
					<a href="https://github.com/youngju79/My-Sample-Codes/tree/master/Samples/MovieDB"><button type="button" class="btn btn-primary">Code</button></a>
				</div>
		    </div>
		    <div class="col-4 my-5 project-description">
		    	<div class="ms-5">
		    		<h5 class="fs-3 fw-bold">MovieDB</h5>
					<p class="fs-5">MovieDB is a web app that displays the current top movies. Users are allowed to search for a specific movie through a query. Movies are received from a GET api call to 'themoviedb'. <u>Utilized</u>: html, css, javascript, boostrap.</p>
		    	</div>
		    </div>
    	</div>
    </div>

	<footer class="footer mt-5 py-3 bg-dark">
		<div class="container text-center">
			<span class="text-muted">Youngju's Personal Website ©</span>
		</div>
	</footer>

	<script src="typing.js-master/typing.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html