<?php 

session_start();
$user_id = $_SESSION['user_id'];
unset($user_id);
session_destroy();
header("location:login.php");

?>