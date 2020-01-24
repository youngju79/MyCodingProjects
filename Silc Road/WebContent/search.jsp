<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8" import="java.util.ArrayList" import="java.util.Iterator" import="java.util.Map" import="cs201Project.Product" import="java.sql.Blob" import="java.io.OutputStream" import="java.net.URL"%>
    
<% 
	ArrayList<Product> results = (ArrayList<Product>)request.getAttribute("resultList");
	
	HttpSession sesh = request.getSession(false);
	int userID = (int)sesh.getAttribute("userID");
	String username = (String)sesh.getAttribute("username");
%>
    
<!DOCTYPE html>
<html>
<head>
	<title>Search results</title>

	<link rel="stylesheet" href="main.css">
	<link href="open-iconic/font/css/open-iconic.css" rel="stylesheet">

	<style>
		.clearfloat {
			clear: both;
		}
		#topBar {
			width: 1200px;
			margin: 0px auto;
		}
		#searchFor {
			padding-top: 30px;
			margin: 0px 10px 0px 0px;
			display: block;
			font-size: 1.6em;
			font-weight: bold;
			float: left;
		}
		#resultCount {
			padding-top: 40px;
			margin: 0px;
			display: block;
			float: left;
		}
		#filterSearch {
			height: 50px;
			width: 100px;
			border: 1px solid black;
			margin: 20px 0px;
			overflow: hidden;
			line-height: 50px;
			font-size: 1.1em;
			padding: 0px 20px;
			transition: all 0.2s;
		}
		#filterSearch:hover {
			width: 100%;
		}
		#searchFilters {
			margin-left: 30px;
			display: inline;
		}
		#filterIcon {
			display: inline;
			font-size: 0.8em;
			line-height: 50px;
			margin-right: 10px;
		}
		#searchFilters > label {
			margin-left: 10px;
		}

		#main-container {
			width: 1200px;
			margin: 0px auto;
		}
		.searchResult {
			width: 280px;
			height: 420px;
			margin: 8px;
			border: 1px solid white;
			float: left;
			color: black;

		}
		.searchResult:hover {
			margin: 8px;
			border: 1px solid black;
		}
		.productPicture {
			width: 280px;
			height: 280px;
			/* background-color: whitesmoke; */
			float: left;
		}
		#imagepic{
		width:280px;
		height:280px;
		}
		.productTitle {
			width: 280px;
			margin: 20px 10px 10px 10px;
			float: left;
			font-size: 1.1em;
		}
		.productSeller {
			color: gray;
			margin: 0px 10px;
			width: 280px;
			float: left;
			font-style: italic;
		}
		.productPrice {
			margin: 10px 10px 20px 10px;
			width: 280px;
			float: left;
			color: gray;
		}
	</style>
	
	<script>
	function sortName(name) {
		document.location.href="/SearchServlet?sortName=" + name + "&searchInput="+ <%=request.getParameter("searchInput") %>;
	}
	function sortPrice(price) {
		this.form.submit();
	}
	function sortCategory(category) {
		document.location.href="/SearchServlet?sortCategory=" + category + "&searchInput="+ <%=request.getParameter("searchInput") %>;
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

		

		<form id="searchForm">
			<input id="searchBar" type="text" name="searchInput" placeholder="Search for products">
			<button id="submit" type="submit" name="submit"><span class="oi" data-glyph="magnifying-glass"></span></button>
		</form>
		
	</div> <!-- #navbar -->

	<div id="topBar">
		<div id="topTopBar">
			<p id="searchFor">Results for "<%=request.getAttribute("searchInput") %>"</p>
			<% 	String items = "ITEMS";
				if(results.size() == 1) {
					items = "ITEM";
				}%>
			<p id="resultCount">(<%=results.size()%> <%=items%>)</p>
		</div>

		<div class="clearfloat"></div>

		<div id="filterSearch">
			<span id="filterIcon" class="oi" data-glyph="ellipses"></span><strong>FILTERS</strong>
			<form id = "searchFilters" action="SearchServlet">
				<input type="hidden" name="searchInput" value="<%= request.getAttribute("searchInput") %>"> 
				<label for="priceFilter">PRICE</label>
				<select id="priceFilter" name="sortPrice" onchange="this.form.submit()">
					<option value="highToLow" <%= request.getAttribute("hightolowSelected") %>>HIGH TO LOW</option>
					<option value="lowToHigh" <%= request.getAttribute("lowtohighSelected") %>>LOW TO HIGH</option>
				</select>

				<label for="nameFilter">NAME</label>
				<select id="nameFilter" name="sortName" onchange="this.form.submit()">
					<option value="aToZ" <%= request.getAttribute("atozSelected") %>>A TO Z</option>
					<option value="zToA" <%= request.getAttribute("ztoaSelected") %>>Z TO A</option>
				</select>
				<label for = "booksCategory">BOOKS</label>
				<input id = "booksCategory" type="radio" name="sortCategory" value="books" onclick="this.form.submit()" <%= request.getAttribute("booksChecked") %>>
				<label for = "furnitureCategory">FURNITURE</label>
				<input id = "furnitureCategory" type="radio" name="sortCategory" value="furniture" onclick="this.form.submit()" <%=request.getAttribute("furnitureChecked") %>>
				<label for = "ticketsCategory">TICKETS</label>
				<input id = "ticketsCategory" type="radio" name="sortCategory" value="tickets" onclick="this.form.submit()" <%=request.getAttribute("ticketsChecked") %>>
				<label for = "clothingCategory">CLOTHING</label>
				<input id = "clothingCategory" type="radio" name="sortCategory" value="clothing" onclick="this.form.submit()" <%=request.getAttribute("clothingChecked") %>>
				<label for = "housingCategory">HOUSING</label>
				<input id = "housingCategory" type="radio" name="sortCategory" value="housing" onclick="this.form.submit()" <%=request.getAttribute("housingChecked") %>>
				<label for = "miscCategory">MISC</label>
				<input id = "miscCategory" type="radio" name="sortCategory" value="misc" onclick="this.form.submit()" <%=request.getAttribute("miscChecked") %>>
			</form>
		</div> <!-- #filterSearch -->

	</div> <!-- #topBar -->

	<div id="main-container">
		<%	
		HttpSession sess;
		sess = request.getSession();
		System.out.println("result size is:" + results.size());
			for(int i = 0; i < results.size(); i++) {
				Product p = results.get(i);
				int productID = p.getProductID();
				String productName = p.getProductName();
				String sellerName = p.getSellerName();
				double productPrice = p.getProductPrice();
				sess.setAttribute("product" + i, p.getImage());
		%>
	<a href="GetProductDetails?productID=<%=productID%>&index=<%=i%>">
	<div class="searchResult">
		<div class="productPicture">
			<img id="imagepic" src="imageServlet?index=<%=i%>"/>
		</div>
		<p class="productTitle"><%=productName%></p>
		<p class="productSeller"><%=sellerName%></p>
		<p class="productPrice">$<%=productPrice%></p>
		<div class="clearfloat"></div>
	</div></a> <!-- #searchResult -->
		<% } %>
	</div> <!-- #main-container -->
	
</body>

</html>