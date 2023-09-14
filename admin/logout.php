<?php
  session_start(); 
// Include the database connection
include('../connection.php');

// remove all session variables
session_unset();

// destroy the session
session_destroy();

header("location: index.php");
?>