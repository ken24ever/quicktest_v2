<?php

include("connection.php");
// Retrieve the duration from the request
$duration = $_POST['duration'];

// Assuming you have a database connection already established
// Update the exam duration in the USERS_EXAM table based on the user's exam ID
$userExamId = $_POST['examID']; // Assuming you have stored the user's exam ID in the session
$query = "UPDATE USERS_EXAM SET END_TIME = NOW() + INTERVAL $duration SECOND WHERE exam_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $userExamId);
$stmt->execute();
$stmt->close();

// Send a response indicating the success
$response = array('success' => true);
echo json_encode($response);
?>
