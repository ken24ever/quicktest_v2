<?php
// Assuming you have established a database connection
include("../connection.php");

// Function to fetch users' details with pagination
function getUsersDetailsWithPagination($page, $itemsPerPage) {
  global $conn;

  $offset = ($page - 1) * $itemsPerPage;

  $sql = "SELECT u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.examName, u.userPassport,
          (SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('title', e.title, 'status', ue.status)), ']') FROM exams e
           LEFT JOIN users_exam ue ON e.id = ue.exam_id
           WHERE ue.user_id = u.id) AS exams
          FROM users u
          LEFT JOIN users_exam ue ON u.id = ue.user_id
          LEFT JOIN exams e ON ue.exam_id = e.id
          GROUP BY u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.userPassport
          LIMIT ? OFFSET ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $itemsPerPage, $offset);
  $stmt->execute();
  $result = $stmt->get_result();
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

if (isset($_GET['page']) && isset($_GET['itemsPerPage'])) {
  $page = $_GET['page'];
  $itemsPerPage = $_GET['itemsPerPage'];

  // Fetch users' details with pagination
  $usersDetails = getUsersDetailsWithPagination($page, $itemsPerPage);

  // Get the total number of users for pagination
  $totalUsers = 0;
  $totalUsersResult = $conn->query("SELECT COUNT(*) AS total FROM users");
  if ($totalUsersResult && $totalUsersResult->num_rows > 0) {
    $totalUsersRow = $totalUsersResult->fetch_assoc();
    $totalUsers = intval($totalUsersRow['total']);
  }

  // Return the users' details and total count as JSON
  header('Content-Type: application/json');
  echo json_encode(['users' => $usersDetails, 'totalUsers' => $totalUsers]);
} else {
  // Handle invalid requests
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Invalid request']);
}

?>
