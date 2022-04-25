<?php
session_start();
$dbServername= "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "erkydb";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    if (mysqli_connect_errno()){    
	    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	    die();
	}
?>