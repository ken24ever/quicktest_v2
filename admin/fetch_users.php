<?php
include('../connection.php');

// Retrieve the search input (exam ID)
$examId = $_POST['examId'];

// Pagination parameters
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$limit = 1000; // Number of records per page
$offset = ($page - 1) * $limit; // Offset for the SQL query WHERE u.active = 1

// Prepare the SQL statement to fetch the users' details with pagination
$query = "SELECT u.id, u.name, u.username, u.email, u.application, GROUP_CONCAT(e.title) AS exam_names, ue.scores, ue.updated_at
          FROM users u
          LEFT JOIN users_exam ue ON u.id = ue.user_id
          LEFT JOIN exams e ON ue.exam_id = e.id
          WHERE ue.exam_id = '$examId' AND ue.status = 'completed' AND u.active = 1
          GROUP BY u.id
          LIMIT $limit OFFSET $offset"; 

$result = $conn->query($query);

// Fetch the users' details and store them in an array  AND u.username LIKE '%$examId%' OR u.name LIKE '%$examId%'
$users = [];
while ($row = $result->fetch_assoc()) { 
  $user = [
    'id' => $row['id'],
    'name' => $row['name'],
    'username' => $row['username'],
    'email' => $row['email'],
    'job' => $row['application'],
    'exam_names' => $row['exam_names'],
    'scores' => $row['scores'],
    'dates' => $row['updated_at'] 
  ];
  $users[] = $user;
}

// Count the total number of records for pagination
$countQuery = "SELECT COUNT(DISTINCT u.id) AS total_count
               FROM users u
               LEFT JOIN users_exam ue ON u.id = ue.user_id
               LEFT JOIN exams e ON ue.exam_id = e.id
               WHERE ue.exam_id = '$examId' AND ue.status = 'completed' ";

$countResult = $conn->query($countQuery);
$totalCount = $countResult->fetch_assoc()['total_count'];

// Close the database connection
$conn->close();

// Prepare the response
$response = [
  'success' => true,
  'users' => $users,
  'total_count' => $totalCount,
  'page' => $page,
  'total_pages' => ceil($totalCount / $limit)
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
