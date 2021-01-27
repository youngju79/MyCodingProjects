<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css"> 
<meta charset="ISO-8859-1">
<title>SearchResults</title>
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
<h2 id="result_">
</h2>
<script>
var search = sessionStorage.getItem("search");
document.getElementById("result_").innerHTML = 'Results for "' + search + '"'; 
var type = sessionStorage.getItem("type");
var url;
console.log(type);
if(type=="isbn"){
	url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + search;
}
if(type=="intitle"){
	url = "https://www.googleapis.com/books/v1/volumes?q=intitle" + search;
}
if(type=="inauthor"){
	url = "https://www.googleapis.com/books/v1/volumes?q=inauthor" + search;
}
if(type=="inpublisher"){
	url = "https://www.googleapis.com/books/v1/volumes?q=inpublisher" + search;
}
var xmlhttp = new XMLHttpRequest();
xmlhttp.open("GET", url, true);
xmlhttp.send();
xmlhttp.onreadystatechange = function() { 
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    	sessionStorage.setItem("data", xmlhttp.responseText);
        var temp = JSON.parse(xmlhttp.responseText);
        displayResults(temp);
    }
};
function displayResults(data){
	if(data.totalItems==0){
		document.getElementById("no_res").innerHTML = 'No books were found';
	}
	else{
		for(var i=0; i<data.items.length; i++){
			item = data.items[i];
			title = item.volumeInfo.title;
			author = item.volumeInfo.authors;
			image = item.volumeInfo.imageLinks.thumbnail;
			summary = item.volumeInfo.description;
			publisher = item.volumeInfo.publisher;
			publish_d = item.volumeInfo.publishedDate;
			isbn = item.volumeInfo.industryIdentifiers[1].identifier;
			rating = item.volumeInfo.averageRating;
			document.getElementById("list_book").innerHTML += '<tr>' + 
				format(title, author, summary, image, i, data) + '</tr>';
		}
	}
}
function format(title, author, summary, image, i, data){
	var each_b = '<th><a href="Details.jsp"><img src="' + image + 
		'" id="' + i + '" onclick="get_details(this.id);"></a></th>' +
		'<th><h3>' + title + '</h3>' + '<em>' + author + '</em>' + 
		'<p>' + '<u>' + 'Summary: ' + '</u>' + summary + '</p></th>';
	return each_b;
}
function get_details(id){
	sessionStorage.setItem("id", id);
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
<table id="list_book">
</table>
<h3 id="no_res">
</h3>
</body>
</html>