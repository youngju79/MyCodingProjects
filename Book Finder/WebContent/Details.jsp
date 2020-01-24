<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css"> 
<meta charset="ISO-8859-1">
<title>Details Page</title>
</head>
<body>
<header>
<a href="HomePage.jsp"><img src="images/bookworm.png" id="image"></a>
	<div class="form2">
		<form name="myForm2" method="GET" action="SearchResults.jsp" onsubmit="return search_res();">
			<div id="formerror"></div>
			<input id="search2" type="search" name="search" placeholder="What book is on your mind?">
			<br>
			<div class="input2">
				<input id="name2" type="radio" name="type" value="intitle">Name
				<input id="isbn2" type="radio" name="type" value="isbn">ISBN
				<br>
				<input id="author2" type="radio" name="type" value="inauthor">Author
				<input id="pub2" type="radio" name="type" value="inpublisher">Publisher
			</div>
			<br>
			<input id="button2" type="image" name="submit" src="images/magnifying_glass.png">
		</form>
	</div>
</header>
<table id="list_book">
</table>
<script>
var id = sessionStorage.getItem("id");
var temp = sessionStorage.getItem("data");
var data = JSON.parse(temp);
var item = data.items[id];
var title = item.volumeInfo.title;
var author = item.volumeInfo.authors;
var image = item.volumeInfo.imageLinks.thumbnail;
var summary = item.volumeInfo.description;
var publisher = item.volumeInfo.publisher;
var publish_d = item.volumeInfo.publishedDate;
var isbn = item.volumeInfo.industryIdentifiers[1].identifier;
var rating = item.volumeInfo.averageRating;
document.getElementById("list_book").innerHTML += '<tr>' + 
	format(title, author, summary, image, publisher, publish_d,
	isbn, rating) + '</tr>';
function format(title, author, summary, image, publisher, publish_d, isbn, rating){
	var each_b = '<th><img src=' + image + 
		'id="imageBox" onclick="history.back()"></th>' +
		'<th><h3>' + title + '</h3> <em>' + author + '</em> <br>' + 
		'Publisher: ' + publisher + '<br> Published Date: ' + publish_d +
		'<br> ISBN: ' + isbn + '<br> <p> <u> Summary: </u>' + 
		summary + '</p> Rating: ' + rating + '</th>';
	return each_b;
}
function search_res(){
	//check for errors
	var search = document.myForm2.search.value;
	var type = document.myForm2.type.value;
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

</body>
</html>