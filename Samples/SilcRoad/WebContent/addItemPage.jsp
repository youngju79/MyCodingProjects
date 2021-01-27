<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
    
<%
	HttpSession sesh = request.getSession(false);
	int userID = 0;
	if(sesh.getAttribute("userID") != null ) {
		userID = (int)sesh.getAttribute("userID");
	}
	String username = (String)sesh.getAttribute("username");
%>
<!DOCTYPE html>
<html>
<head>
<!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<meta charset="UTF-8">
<title>Add Item</title>
<style>
#productIMG{
width:50px;
}
#productDesc{
width:180px;
height: 300px;
}
#productName{
width:200px;
}
#price{
width:150px;
}
#conditionDropDown{
width:200px;
}
#categoryDropDown{
width:200px;
}
#leftmost{
float:left;
width:300px;
}
#middle{
float:left;
width:300px;
}
#rightmost{
float:left;
width:300px;
}
#content{
margin-left:auto;
margin-right:auto;
width:920px;
}
#addButt{
height:40px;
width:150px;
}
#blankspot{
margin-top:20px;
width:250px;
height:250px;
background-color:grey;
display:flex;
align-items:center;
justify-content:center;
}
</style>
	<link rel="stylesheet" href="main.css">
	<link href="open-iconic/font/css/open-iconic.css" rel="stylesheet">
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

		

		<form id="searchForm" action = "SearchServlet">
			<input id="searchBar" type="text" name="searchInput" placeholder="Search for products">
			<button id="submit" type="submit" name="submit"><span class="oi" data-glyph="magnifying-glass"></span></button>
		</form>
		
	</div> <!-- #navbar -->
	<h1 style="margin-left:40px; padding-top:20px;">Add Item</h1>
<div id = "content">

<form id = addItemForm method="POST" action="insertItemServlet" enctype="multipart/form-data">
<input type="text" name="fullName" value="<%=username%>" style="display:none;">
<input type="text" name="userID" value="<%=userID%>" style="display:none;">

<div id="leftmost">
Name<br/>
<input type="text" name = "productName" id="productName" value="" required/>
<br/><br/><br/><br/>
Price<br/>
$ <input id="price" type="number" name= "prodprice" min="0.00" step="0.01" max="2500" value="" required/>
<br/><br/><br/><br/>
Condition<br/>
<select name="condition" id="conditionDropDown" required>
<option value="">Select a Condition</option>
<option value="new">New</option>
<option value="good">Good</option>
<option value="used">Used</option>
</select>
<br/><br/><br/><br/>
Category<br/>
<select name="category" id="categoryDropDown" required>
<option value="">Select a Category</option>
<option value="books">Textbooks</option>
<option value="furniture">Furniture</option>
<option value="tickets">Tickets</option>
<option value="clothing">Clothing</option>
<option value="housing">Housing</option>
<option value="misc">Misc.</option>
</select>
<br/><br/><br/><br/>
</div>
<div id="middle">
Product Description<br/>
<textarea id="productDesc" name = "productDesc" form ="addItemForm" required></textarea>
</div>
<div id="rightmost">
<div id="blankspot">
<img id="productIMG" src="camIMG.png" alt="Upload your Product Image">

</div>

<br/>
<input id="uploadimg" type="file" name="image" onchange="readURL(this);" value="" accept="image/png, .jpeg, .jpg, image/gif" required/>
<br/><br/><br/>

<input id="addButt" type="submit" value="Add Item"/>
</div>

</form>
</div>

</body>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#productIMG')
                .attr('src', e.target.result)
                .width(250)
                .height(250);
        };
        reader.readAsDataURL(input.files[0]);
    }
    console.log("image location is:" + $('#uploadimg').val() );
}

(function() {
    /* $('form > input,number,text,select').keyup(function() {

        var empty = false;
        $('form > input,number,text,select').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if (empty) {
            $('#addButt').attr('disabled', 'disabled');
        } else {
            $('#addButt').removeAttr('disabled');
        }
    }); */
})()

</script>
</html>