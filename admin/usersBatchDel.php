<?php
<<<<<<< HEAD

session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id'];

include('../connection.php');

// Retrieve the selected user IDs to delete
$userIds = isset($_POST['userIds']) && is_array($_POST['userIds']) ? $_POST['userIds'] : null;

$userIDsCount = count($_POST['userIds']);

//track reseted user IDs 
$action = 'Batch Users Delete'; 
$description = 'Logged in admin user: (' . $fullNames . ') did a batch user delete for these number of users: "' . $userIDsCount . '"';

    // Prepare the SQL statement to insert the record into the audit_tray table
$sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES ('$fullNames','$userID','$description','$action')";
$stmtsqlDel = mysqli_query($conn, $sqlDel);




// Initialize an array to store the paths of user passports to be deleted
$passportPaths = [];

// Prepare the SQL statement to select user passports of the selected users
$selectPassportsQuery = "SELECT userPassport FROM users WHERE id IN (" . implode(',', $userIds) . ")";
$result = $conn->query($selectPassportsQuery);

// Fetch the user passports and store their paths in the $passportPaths array
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $passportPath = $row['userPassport'];
    if ($passportPath) {
      $passportPaths[] = $passportPath;
    }
  }
}
=======
include('../connection.php');

// Retrieve the selected user IDs to delete
$userIds = $_POST['userIds'];
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

// Prepare the SQL statement to delete the selected users
$deleteQuery = "DELETE FROM users WHERE id IN (" . implode(',', $userIds) . ")";
$result = $conn->query($deleteQuery);

<<<<<<< HEAD
// Prepare the SQL statement to delete the user exams of the selected users
$deleteQueryUserExams = "DELETE FROM users_exam WHERE user_id IN (" . implode(',', $userIds) . ")";
$res = $conn->query($deleteQueryUserExams);

// Initialize a flag to track whether all operations were successful
$success = true;

// Delete user passports from the file system using unlink
foreach ($passportPaths as $passportPath) {
  if (file_exists($passportPath)) {
    if (!unlink($passportPath)) {
      // If unable to delete the passport file, set the $success flag to false
      $success = false;
      break; // No need to continue deleting other files, we can exit the loop
    }
  }
}

// Prepare the response based on the success flag
if ($result && $res && $success) {
  $response = ['success' => true, 'message' => 'Selected user(s) and their passport(s) deleted successfully.'];
} else {
  $response = ['success' => false, 'message' => 'Failed to delete selected users and/or their passports.'];
=======
// Prepare the SQL statement to delete the selected users
$deleteQueryUserExams = "DELETE FROM users_exam WHERE user_id IN (" . implode(',', $userIds) . ")";
$res = $conn->query($deleteQueryUserExams);

if ($result && $res) {
  $response = ['success' => true, 'message' => 'Selected users deleted successfully.'];
} else {
  $response = ['success' => false, 'message' => 'Failed to delete selected users.'];
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close(); 
?>
