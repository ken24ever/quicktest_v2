<?php
// Assuming you have established a database connection
// Set database connection variables
include("../connection.php");

if (isset($_POST['userId'])) {
  $userId = $_POST['userId'];

  // Fetch exams by user ID
  $sql = "SELECT e.title, ue.status
          FROM exams e
          INNER JOIN users_exam ue ON e.id = ue.exam_id
          WHERE ue.user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  $exams = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $exams[] = $row;
    }
  }

  // Return the exams as JSON
  header('Content-Type: application/json');
  echo json_encode($exams);
} else {
  echo json_encode([]);
}
?>
