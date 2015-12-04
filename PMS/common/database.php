<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$db = 'restaurante';

	// Create connection
	$link = mysqli_connect($servername, $username, $password,$db);

	// Check connection
	if (!$link)
	{
	    die("Connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";
?>