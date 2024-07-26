<?php
// Set database connection variables
include("connection.php");
  session_start(); 
// remove all session variables
$username = $_SESSION['username'];
$updateLoginStatus = "UPDATE users SET logged_in = 0 WHERE username = '$username'";
$resultLoginStatus = mysqli_query($conn, $updateLoginStatus);
session_unset();
// destroy the session
session_destroy();
header("location: index.php");
?>