<?php

// Establish mysqli connection
include("connection.php");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the timezone to Africa/Lagos
date_default_timezone_set('Africa/Lagos');

// Check if the start_time is empty or "00:00:00"
if (empty($_POST['start_time']) || $_POST['start_time'] === "00:00:00") {
    // Get the current timestamp as the start_time
    $start_time = date('Y-m-d H:i:s');
} else {
    // Use the provided start_time
    $start_time = $_POST['start_time'];
} 

// Update the table
$user_id = $_POST['user_id'];
$exam_id = $_POST['exam_id'];
$status = 'in_progress';

$sql = "UPDATE users_exam SET start_time = '$start_time', status = '$status' WHERE user_id = '$user_id' AND exam_id = '$exam_id'";

if (mysqli_query($conn, $sql)) {
    echo "Table updated successfully.";
} else {
    echo "Error updating table: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn); 
?>
