<?php
session_start();

// Include your database connection logic here
// For example, if you are using mysqli, you might have something like this:
// include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}
//error_log("Received startTime: " . $_GET['startTime']);
// Get the user ID from the session
$user_id = $_SESSION['id'];

// Set up your database connection and perform the query
// Example using mysqli (replace with your database connection logic)
include("connection.php");

// Fetch the remaining_time from the users table
$query = "SELECT remaining_time FROM users WHERE id = $user_id";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $remaining_time = $row['remaining_time']; // The value is already an integer
        echo json_encode(['remainingTime' => $remaining_time]);
    } else {
        echo json_encode(['error' => 'User found, but remaining_time is NULL']);
    }
} else {
    $error_message = 'Query failed: ' . $conn->error;
    echo json_encode(['error' => $error_message]);

    // Log the error
    error_log($error_message);
}

$conn->close();
?>
