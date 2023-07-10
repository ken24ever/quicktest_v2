<?php
include('../connection.php');

// Retrieve the selected user IDs to delete
$userIds = $_POST['userIds'];

// Prepare the SQL statement to delete the selected users
$deleteQuery = "DELETE FROM users WHERE id IN (" . implode(',', $userIds) . ")";
$result = $conn->query($deleteQuery);

// Prepare the SQL statement to delete the selected users
$deleteQueryUserExams = "DELETE FROM users_exam WHERE user_id IN (" . implode(',', $userIds) . ")";
$res = $conn->query($deleteQueryUserExams);

if ($result && $res) {
  $response = ['success' => true, 'message' => 'Selected users deleted successfully.'];
} else {
  $response = ['success' => false, 'message' => 'Failed to delete selected users.'];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close(); 
?>
