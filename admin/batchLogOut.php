<?php

session_start();

$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id'];

include('../connection.php');

// Retrieve the selected user IDs to delete
$userIds = isset($_POST['userIds']) && is_array($_POST['userIds']) ? $_POST['userIds'] : null;

$userIDsCount = count($_POST['userIds']);

// Initialize an array to store the paths of user passports to be deleted
$passportPaths = [];

// Initialize an array to store the selected user details for archiving
$selectedUserDetails = [];

// Fetch the selected user details, including the 'scores' column from USERS_EXAM
$selectUserDetailsQuery = "
  SELECT u.*, ue.scores, ue.start_time, ue.end_time, ue.status, ue.updated_at
  FROM users u
  LEFT JOIN users_exam ue ON u.id = ue.user_id
  WHERE u.id IN (" . implode(',', $userIds) . ")
";
$result = $conn->query($selectUserDetailsQuery);

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $selectedUserDetails[] = $row;
    $passportPath = $row['userPassport'];
    if ($passportPath) {
      $passportPaths[] = $passportPath;
    }
  }
}

// Initialize a flag to track whether all operations were successful
$success = true;

// Delete user passports from the file system using unlink
/* foreach ($passportPaths as $passportPath) {
  if (file_exists($passportPath)) {
    if (!unlink($passportPath)) {
      // If unable to delete the passport file, set the $success flag to false
      $success = false;
      break; // No need to continue deleting other files, we can exit the loop
    }
  }
} */

// Prepare the SQL statement to insert selected user details into the users_history table
$insertHistoryRecords = [];
foreach ($selectedUserDetails as $user) {
  $insertHistoryRecords[] = "(
    '$user[id]', '$user[name]', '$user[email]', '$user[username]', '$user[password]',
    '$user[gender]', '$user[application]', '$user[examName]', '$user[userPassport]',
       '$user[created_at]', '$user[updated_at]','$user[scores]'
  )";

  $updateUserStatus = "UPDATE users SET logged_in = 0 WHERE id = '$user[id]'";
  $resultUpdateUserStatus = $conn->query($updateUserStatus);
  if (!$resultUpdateUserStatus) {
    $response = ['success' => false, 'message' => 'Failed to log out user(s).'];
  }
} 
/* $insertHistoryQuery = "
  INSERT INTO users_history (
    id, name, email, username, password, gender, application, examName, userPassport, created_at, updated_at, scores
  ) VALUES " . implode(',', $insertHistoryRecords);
 */
// Execute the insert query
/* $resultInsertHistory = $conn->query($insertHistoryQuery);
 */
// Prepare the SQL statement to delete the selected users
// $deleteQuery = "DELETE u, ue FROM users u LEFT JOIN users_exam ue ON u.id = ue.user_id WHERE u.id IN (" . implode(',', $userIds) . ")";
// $result = $conn->query($deleteQuery);

//track reseted user IDs
$action = 'Batch Log Out';
$description = 'Logged in admin user: (' . $fullNames . ') logged out these numbers of user(s) : "' . $userIDsCount . '"';

// Prepare the SQL statement to insert the record into the audit_tray table
$sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES ('$fullNames','$userID','$description','$action')";
$stmtsqlDel = mysqli_query($conn, $sqlDel);

// Prepare the response based on the success flag
// if ($result && $success && $resultInsertHistory) {
  if ($resultUpdateUserStatus) {
  $response = ['success' => true, 'message' => 'Selected user(s) logged out Successfully!'];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
