<?php
	$connection = mysqli_connect("localhost","root","","characters");

	if (mysqli_connect_errno($connection))
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
    else
      mysqli_query($connection, "set names utf8");
?>
