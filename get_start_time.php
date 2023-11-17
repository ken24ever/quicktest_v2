<?php
include("connection.php");

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the start_time
$sql = "SELECT start_time FROM users_exam WHERE exam_id = ? AND user_id = ?";

// Assuming you have the examID and userID available as POST parameters
$examID = $_POST['examID'];
$userID = $_POST['userID'];

// Prepare the statement and bind the parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $examID, $userID);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Fetch the row
  $row = $result->fetch_assoc();

  // Return the start_time as a JSON response
  echo json_encode($row);
} else {
  // No start_time found, return an error message or handle accordingly
  echo json_encode(['error' => 'No start_time found for the exam.']);
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
