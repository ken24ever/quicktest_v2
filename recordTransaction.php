<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get question ID from POST data
  $questionId = $_POST['questionId'];
  $user_id = $_POST['user_id'];
  $exam_id = $_POST['exam_id'];

  // Insert a new record in the transactions_breakdown table
  $insertQuery = "INSERT INTO transactions_breakdown (exam_id, question_id, user_id) VALUES (?, ?, ?)";

  $stmt = $conn->prepare($insertQuery);
  $stmt->bind_param('iii', $exam_id, $questionId, $user_id);

  if ($stmt->execute()) {
    // Transaction recorded successfully
    echo json_encode(['status' => 'success']);
  } else {
    // Error recording transaction
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
  }

  $stmt->close();
}
?>
