<?php
// Connect to database
include("../connection.php");

// Get the question ID from the AJAX request
$questionId = $_POST['question_id'];

// Get the question details from the database
$sql = "SELECT * FROM questions WHERE id = '$questionId'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Return the question details as a JSON response
header('Content-Type: application/json');
echo json_encode(array(
    'status' => 'success',
    'question' => $row
));

// Close database connection
mysqli_close($conn);
?>
