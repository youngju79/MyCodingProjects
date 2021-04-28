<?php 
require("Product.php");

$book = new Product("The Hunger Games");
echo $book->name;
echo "<br>";
echo $book->getDescription();

?>