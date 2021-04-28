<?php
	session_start();
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$user = $url["user"];
	$pass = $url["pass"];
	$db = substr($url["path"], 1);
?>