<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Set up your database connection and perform the query
// Example using mysqli (replace with your database connection logic)
include("connection.php");

// Get the remaining_time from the request (Corrected to match the JavaScript parameter)
$remaining_time = isset($_POST['remaining_time']) ? intval($_POST['remaining_time']) : 0;

// Update remaining_time in the users table
$query = "UPDATE users SET remaining_time = $remaining_time WHERE id = $user_id";
$result = $conn->query($query);

if ($result) {
    echo json_encode(['success' => 'Remaining time updated successfully']);
} else {
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
}

$conn->close();
?>
