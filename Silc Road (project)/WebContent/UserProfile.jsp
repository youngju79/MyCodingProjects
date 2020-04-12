<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title>User Profile</title>

	<link rel="stylesheet" href="main.css">
	<link href="open-iconic/font/css/open-iconic.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
	<style>
		#main-container {
			width: 800px;
			margin: 0px auto;
			padding-top: 60px;
		}
		#profile-container {
			width: 600px;
			margin: 0px auto;
		}
		#profilePicture {
			width: 196px;
			height: 196px;
			background-color: gray;
			border-radius: 100px;
			border: 1px solid black;
			float: left;
			overflow: hidden;
		}
		#profilePicture > img {
			width: 200px;
			height: 200px;
		}
		#profileDetails {
			padding-left: 40px;
			width: 360px;
			float: left;
		}
		#profileName {
			font-size: 2.2em;
			font-weight: bold;
			margin-bottom: 20px;
			margin-top: 40px;
		}
		#profileEmail, #profileRating {
			font-size: 1.2em;
			font-weight: bold;
		}
		.details {
			display: inline;
			font-weight: normal;
		}
		#products-container {
			margin-top: 60px;
		}
		#productPicture{
			width: 130px;
			height: 170px;
			background-color: gray;
			float: left;
		}
		#productName {
			font-size: 2em;
			font-weight: bold;
			margin-bottom: 20px;
		}
		#remove_button {
			transition: all 0.2s;
			padding: 10px 14px;
			border: 2px solid black;
			cursor: pointer;
			border-radius: 100px;
		}
		#remove_button:hover {
			border: 2px solid black;
			background-color: #EEEEEE;
			color: black;
		}
	</style>

</head>

<%
	String name = (String)request.getAttribute("name");
	String email = (String)request.getAttribute("email");
	double rating = (double)request.getAttribute("rating");
	int userID = (int)request.getAttribute("userID");
	HttpSession sesh = request.getSession(false);
	int curr_userID = 0;
	if(sesh.getAttribute("userID") != null ) {
		curr_userID = (int)sesh.getAttribute("userID");
	}
	String logged = (String)sesh.getAttribute("loggedIn");
	String username = (String)sesh.getAttribute("username");
%>

<%@ page import="cs201Project.GetUserItems"%>
<%@ page import="cs201Project.Product"%>
<%@ page import="java.util.ArrayList" %>
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
					<a class="menuItem" href="GetUser?userID=<%=curr_userID%>" ><li>My Profile</li></a>
					<a class="menuItem" href="addItemPage.jsp"><li>Add Item</li></a>
					<a class="menuItem" href="Transactions.jsp"><li>Transactions</li></a>
					<a id="signOutButton" href="Signout">LOG OUT</a>
				<% } else { %>
					<a id="signOutButton" href="login.jsp">LOG IN</a>
				<% } %>
				
			</ul> <!-- #menu -->
		</div> <!-- #menuToggle -->

		<form id="searchForm" action = "SearchServlet">
			<input id="searchBar" type="text" name="searchInput" placeholder="Search for products">
			<button id="submit" type="submit" name="submit"><span class="oi" data-glyph="magnifying-glass"></span></button>
		</form>
	</div> <!-- #navbar -->


	<div id="main-container">
		<div id="profile-container">
			<div id="profilePicture">
				<img src="defaultProfile.jpeg" alt="Default profile picture">
			</div>

			<div id="profileDetails">
				<p id="profileName"><%=name%></p>

				<div id="profileEmail">Email:
					<p class="details"><%=email%></p>
				</div>

				<div id="profileRating">Rating:
					<p class="details"><%=rating%>/5.0</p>
				</div>
			</div>
		</div>

		<div class="clearfloat"></div>

		<div id="products-container">
			<h2>Products <%=name%> is selling</h2>
			<!-- for loop for all products here -->
			<% 
			GetUserItems user = new GetUserItems();
			ArrayList<Product> items = user.getItems(userID);
			for(int i=0; i<items.size(); i++){
				sesh.setAttribute("product" + i, items.get(i).getImage());
			%>
			<table style="border-top: 1px solid black; padding: 20px 0px; width:800px;">
				<tr>
					<div id="<%=items.get(i).getProductID()%>">
						<td style="width:160px;">
							<div id="productPicture">
								<img src="imageServlet?index=<%=i%>">
							</div>
						</td>
						<td style="width:500px;">
							<a href="GetProductDetails?productID=<%=items.get(i).getProductID()%>&index=<%=i%>" style="text-decoration:none;color:black;">
								<p id="productName" style="margin:0px 0px 20px 0px;font-size:1.6em;"><%=items.get(i).getProductName()%> </p>
							</a>
							<p class="details" style="font-size:1.2em;">Seller: <em><%=items.get(i).getSellerName()%></em></p>
							<br>
							<p class="details" style="font-size:1.2em;">Price: $<%=items.get(i).getProductPrice()%> </p>
						</td>
						<%  if((logged=="true") && (curr_userID==userID)){ %>
							<td style="padding:0px;">
								<a id="remove_button" onclick="removeRequest(<%=items.get(i).getProductID()%>)" style=""><strong>REMOVE</strong></a>
							</td>
						<% }  %>
					</div> <!-- #profileProducts -->
				</tr>
			<% 
			} 
			%>
			</table>
		</div> <!-- #products-container -->
	
	</div> <!-- #main-container -->
</body>
<script>
function removeRequest(productID){
	$.ajax({
		url: "DeleteItem",
		data:{
			productID: productID
		},
		success: function(response){
			document.getElementById(""+productID).style.display = "none";
			location.reload();
		}
	})
}
</script>
</html>