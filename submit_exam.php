<?php
session_start();
include("connection.php");

$selectedOptionsJSON = $_POST['selectedOptions'];
$selectedOptions = json_decode($selectedOptionsJSON, true);
$usersExamId = $_SESSION['id'] ?? '';
$examId = $_POST['examID'] ?? ''; // Get the exam ID from the AJAX request

// Loop through the selected options
foreach ($selectedOptions as $questionId => $option) {
  // Check if the selected option already exists in the selected_options table
  $sql = "SELECT * FROM selected_options WHERE user_exam_id = ? AND question_id = ?";

  // Prepare the SQL statement
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $usersExamId, $questionId);

  // Execute the SQL query
  $stmt->execute();

  // Fetch the result set
  $result = $stmt->get_result();

  // Check if a row exists 
  if ($result->num_rows > 0) {
    // A row exists, update the selected_option
    $updateSql = "UPDATE selected_options SET selected_option = ? WHERE user_exam_id = ? AND question_id = ?";

    // Prepare the update SQL statement
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('sii', $option, $usersExamId, $questionId);

    // Execute the update SQL statement
    $updateStmt->execute();
  } else {
    // No row exists, insert a new record
    $insertSql = "INSERT INTO selected_options (user_exam_id, exam_id, question_id, selected_option) VALUES (?, ?, ?, ?)";

    // Prepare the insert SQL statement
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param('iiis', $usersExamId, $examId, $questionId, $option);

    // Execute the insert SQL statement
    $insertStmt->execute();
  }
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Prepare the response data
$response = [
  'status' => 'success',
  'message' => 'Selected options stored successfully'
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
