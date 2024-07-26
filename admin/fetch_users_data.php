<?php
// Assuming you have established a database connection
include("../connection.php");

// Function to fetch all users' details
function getAllUsersDetails() {
  global $conn;

  $sql = "SELECT u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.examName, u.userPassport,
          (SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('title', e.title, 'status', ue.status)), ']') FROM exams e
           LEFT JOIN users_exam ue ON e.id = ue.exam_id
           WHERE ue.user_id = u.id) AS exams
          FROM users u
          LEFT JOIN users_exam ue ON u.id = ue.user_id
          LEFT JOIN exams e ON ue.exam_id = e.id
          WHERE u.active = 1
          GROUP BY u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.userPassport";

  $result = $conn->query($sql);
  $users = [];

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Convert the exams JSON string to an array
      $row['exams'] = json_decode($row['exams'], true);
      $users[] = $row;
    }
  }

  return $users;
}

// Fetch all users' details
$usersDetails = getAllUsersDetails();

// Return the users' details as JSON
header('Content-Type: application/json');
echo json_encode(['users' => $usersDetails]);
