<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
    
<%
	HttpSession sesh = request.getSession();
	int userID = 0;
	if(sesh.getAttribute("userID") != null ) {
		userID = (int)sesh.getAttribute("userID");
	}
	String username = (String)sesh.getAttribute("username");
%>
<!DOCTYPE html>
<html>
<head>
	<title>HomePage</title>

	<link rel="stylesheet" href="main.css">
	<link href="open-iconic/font/css/open-iconic.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Staatliches&display=swap" rel="stylesheet">

	<style>
		body {
			background-color: black;
		}
		#navbar {
			background-color: black;
			border: none;
		}
		#main-container {
			width: 800px;
			height: 240px;
			margin: auto;
			margin-top: 220px;
		}
		#menuToggle span {
			background-color: white;
		}
		#menu {
			background-color: white;
			color: black;
		}
		#menuToggle input:checked ~ span {
			background-color: black;
		}
		.menuItem {
			color: black;
		}
		.menuItem:hover {
			color: dimgray;
		}
		#notificationIcon {
			margin-right: 30px;
			border: 2px solid white;
			height: 36px;
			width: 36px;
			color: white;
		}
		#welcomeBanner {
			width: 800px;
			font-size: 6em;
			margin: 0px auto;
			color: white;
			font-family: 'Staatliches', sans-serif;
		}
		#bigSearchForm {
			display: block;
			width: 1000px;
			margin: 20px auto;
		}
		#bigSearchInput {
			width: 600px;
			height: 40px;
			border: none;
			border-bottom: 2px solid lightgray;
			background-color: black;
			color: white;
			font-size: 2em;

			padding: 6px;
			margin-bottom: 30px;

			outline: none;
			-webkit-appearance: none;
			-webkit-box-shadow: none;
			box-shadow: none;
		}
		#bigSearchInput:focus {
			border-bottom: 4px solid white;
		}
		#bigSubmit {
			float: none;
			width: 52px;
			height: 52px;
			font-size: 1.1em;
			line-height: 26px;
			border: 2px solid white;
			border-radius: 28px;
			background-color: black;
			color: white;
			padding-top: 6px;
			transition: all 0.2s;
		}
		#bigSubmit:focus {
			background-color: white;
			color: black;
		}
		#S {
			animation: S 4s;
			animation-fill-mode: forwards;
			display: inline;
		}
		#C {
			animation: C 4s;
			animation-fill-mode: forwards;
			display: inline;
		}
		#signOutButton {
			color: black;
			text-decoration: none;
			height: 40px;
			width: 120px;
			border: 3px solid black;
			font-size: 1.2em;
			transition: all 0.2s;
		}
		#signOutButton:hover {
			background-color: black;
			color: white;
		}
		@keyframes S{
			20% {
				color: white;
			}
			100% {
				color: #D32F2F;
			}
		}
		@keyframes C{
			20% {
				color: white;
			}
			100% {
				color: #FFCC00;
			}
		}
		@keyframes background{
			20% {
				background-color: white;
			}
			100% {
				background-color: black;
			}
		}
	</style>

</head>

<body>
	
	<div id="navbar">
		<div id="menuToggle">
			<input type="checkbox" id="button" />

			<span></span>
			<span></span>
			<span></span>

			<ul id="menu">
				<a class="menuItem" href="homepage.jsp"><li>Home</li></a>
				<% if(!username.equalsIgnoreCase("guest")) { %>
					<a class="menuItem" href="GetUser?userID=<%=userID%>" ><li>My Profile</li></a>
					<a class="menuItem" href="addItemPage.jsp"><li>Add Item</li></a>
					<a class="menuItem" href="Transactions.jsp"><li>Transactions</li></a>
					<a id="signOutButton" href="Signout">LOG OUT</a>
				<% } else { %>
					<a id="signOutButton" href="login.jsp">LOG IN</a>
				<% } %>
				
			</ul> <!-- #menu -->
		</div> <!-- #menuToggle -->

		
	</div> <!-- #navbar -->

	<div id="main-container">
		<div id="welcomeBanner">WELCOME TO <p id="S">S</p>IL<p id="C">C</p> ROAD</div>
		<form id="bigSearchForm" action="SearchServlet">
			<input id="bigSearchInput" type="text" name="searchInput" placeholder="search for products">
			<button id="bigSubmit" type="submit" name="submit"><span class="oi" data-glyph="magnifying-glass"></span></button>
		</form>
	</div>
</body>
</html>