<?php
// Set database connection variables
include("connection.php");

// Get logged-in user's exam IDs and change status to pending
$username = $_GET['user'];
echo $username;

$query = "UPDATE users_exam 
          JOIN users ON users_exam.user_id = users.id 
          SET users_exam.status = 'pending' 
          WHERE users.username = '$username'";

if (mysqli_query($conn, $query)) {
    $truncateTable = "TRUNCATE TABLE selected_options"; // Empty the selected_options table
    if (mysqli_query($conn, $truncateTable)) {
        header("Location: https://cbt.igs.ng/dashboard.php");
    }
}

?>