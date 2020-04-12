<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css"> 
<meta charset="ISO-8859-1">
<title>HomePage</title>
</head>
<body>
<header>
	<img src="images/bookworm.png" id="image">
</header>

<script>
function search_res(){
	//check for errors
	var search = document.myForm1.search.value;
	var type = document.myForm1.type.value;
	var xhttp= new XMLHttpRequest();
	xhttp.open("GET","WebServ?search=" + search + "&type=" + type, false);
	xhttp.send();
	if(xhttp.responseText.trim().length>0){
		document.getElementById("formerror").innerHTML = xhttp.responseText;
		return false;
	}
	sessionStorage.setItem("search", search);
	sessionStorage.setItem("type", type);
	return true;
}
</script>

<div class="main">
	<h1>BookWorm: Just a Mini Program... Happy Days!</h1>
	<div class="form1">
		<form name="myForm1" method="GET" action="SearchResults.jsp" onsubmit="return search_res();">
			<div id="formerror"></div>
			<input id="search" type="search" name="search" placeholder="Search for your favorite book!">
			<br>
			<div class="input1">
				<input type="radio" name="type" value="intitle">Name
				<input id="isbn" type="radio" name="type" value="isbn">ISBN
				<br>
				<input type="radio" name="type" value="inauthor">Author
				<input id="pub" type="radio" name="type" value="inpublisher">Publisher
				<br>
			</div>
			<br>
			<input id="button" type="submit" name="submit" value="Search!">
		</form>
	</div>
</div>

</body>
</html>