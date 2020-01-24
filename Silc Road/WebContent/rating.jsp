<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Rating</title>
	<link rel="stylesheet" href="main.css">
	<link href="open-iconic/font/css/open-iconic.css" rel="stylesheet">
<script>
	function change(){
		document.getElementById("ratingdisplay").innerHTML=document.getElementById("myRange").value;
	}
	function rate(){
		var xhttp = new XMLHttpRequest();
		var link = "RatingServlet?buyerID="+<%= request.getParameter("buyerID")%>+"&rating="+document.getElementById("myRange").value;
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	alert(xhttp.responseText);
		    }
		};
		xhttp.open("POST", link, true);
		xhttp.send();
		return true;
	}
</script>
</head>
<body>
	<div id="navbar">
		<div id="menuToggle">
			<input type="checkbox" id="button" />

			<span></span>
			<span></span>
			<span></span>

			<ul id="menu">
				<a class="menuItem" href="#"><li>Shop Page</li></a>
				<a class="menuItem" href="#"><li>My Profile</li></a>
				<a class="menuItem" href="#"><li>Add Item</li></a>
				<a id="signOutButton" href="#">LOG OUT</a>
			</ul> <!-- #menu -->
		</div> <!-- #menuToggle -->

		

		<form id="searchForm">
			<input id="searchBar" type="text" name="searchInput" placeholder="Search for products">
			<button id="submit" type="submit" name="submit"><span class="oi" data-glyph="magnifying-glass"></span></button>
		</form>
		
	</div> <!-- #navbar -->
	<div style="margin: 10%">
		<h1 style="margin-bottom: 50px">How would you rate <%=request.getParameter("buyerName") %>?</h1>
		<div class="slidecontainer">
			<form action="homepage.jsp" onsubmit="rate()">
  				<input type="range" min="1" max="5" step="1" value="5" class="slider" id="myRange" name="myRange" onchange="change()" style="width:40em">
  				<label for="myRange" id="ratingdisplay">5</label>
  				<input type="submit" value="Submit">
  			</form>
		</div>
	</div>
</body>
</html>