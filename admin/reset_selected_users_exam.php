<?php

session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id'];

// Set database connection variables
include("../connection.php");

// Check the database connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Check if the 'userIds' array is set in the POST data and is an array
if (isset($_POST['userIds']) && is_array($_POST['userIds'])) {
  $userIds = $_POST['userIds'];
   $userIDsCount = count($_POST['userIds']);

       //track reseted user IDs 
       $action = 'Batch Users Reset'; 
       $description = 'Logged in admin user: (' . $fullNames . ') did a batch user reset for these number of users: "' . $userIDsCount . '"';
     
           // Prepare the SQL statement to insert the record into the audit_tray table
     $sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES ('$fullNames','$userID','$description','$action')";
     $stmtsqlDel = mysqli_query($conn, $sqlDel);
     //$stmtsqlDel->bind_param("siss", $fullNames, $userID, $description, $action);
     
     

  // Step 1: Reset the exams for the selected users in the database
  foreach ($userIds as $userId) {

    // Step 2: Get the user_exam_id and exam_id for each user from the users_exam table
    $sql_get_user_exams = "SELECT user_id as user_exam_id, exam_id
                           FROM users_exam
                           WHERE user_id = ?";
    $stmt_get_user_exams = $conn->prepare($sql_get_user_exams);

    // Check if the statement is prepared successfully
    if (!$stmt_get_user_exams) {
      // Handle the case when preparing the statement fails
      die('Statement preparation failed: ' . $conn->error); 
    }

    // Bind parameters to the prepared statement
    $stmt_get_user_exams->bind_param("i", $userId);

    // Execute the prepared statement
    if (!$stmt_get_user_exams->execute()) {
      // Handle the case when execution fails
      die('Statement execution failed: ' . $stmt_get_user_exams->error);
    }

    // Get the result of the query
    $result_user_exams = $stmt_get_user_exams->get_result();

    // Step 3: Loop through the user exams and delete the corresponding selected_options
    while ($row_user_exams = $result_user_exams->fetch_assoc()) {
      $user_exam_id = $row_user_exams['user_exam_id'];
      $exam_id = $row_user_exams['exam_id'];

      // Step 4: Fetch the examName using the exam_id from the exams table
      $sql_get_exam_name = "SELECT title FROM exams WHERE id = ?";
      $stmt_get_exam_name = $conn->prepare($sql_get_exam_name);

      // Check if the statement is prepared successfully
      if (!$stmt_get_exam_name) {
        // Handle the case when preparing the statement fails
        die('Statement preparation failed: ' . $conn->error);
      }

      // Bind parameters to the prepared statement
      $stmt_get_exam_name->bind_param("i", $exam_id);

      // Execute the prepared statement
      if (!$stmt_get_exam_name->execute()) {
        // Handle the case when execution fails
        die('Statement execution failed: ' . $stmt_get_exam_name->error);
      }

      // Get the result of the query
      $result_exam_name = $stmt_get_exam_name->get_result();

      // Fetch the examName
      $row_exam_name = $result_exam_name->fetch_assoc();
      $examName = $row_exam_name['title'];

      // Step 5: Delete the corresponding selected_options from the selected_options table
      $sql_delete_selected_options = "DELETE FROM selected_options
                                      WHERE user_exam_id = ? AND exam_id = ?";
      $stmt_delete_selected_options = $conn->prepare($sql_delete_selected_options);

      // Check if the statement is prepared successfully
      if (!$stmt_delete_selected_options) {
        // Handle the case when preparing the statement fails
        die('Statement preparation failed: ' . $conn->error);
      }

      // Bind parameters to the prepared statement
      $stmt_delete_selected_options->bind_param("ii", $user_exam_id, $exam_id);

      // Execute the prepared statement
      if (!$stmt_delete_selected_options->execute()) {
        // Handle the case when execution fails
        die('Statement execution failed: ' . $stmt_delete_selected_options->error);
      }

      // Step 6: Close the statement for the examName retrieval
      $stmt_get_exam_name->close();
    }

    // Step 7: Close the statement for the user exams retrieval
    $stmt_get_user_exams->close();

    // Step 8: Finally, update the status in the users_exam table to 'pending'
    // Here, we assume you have a 'status' column in the users_exam table
    $sql_update_status = "UPDATE users_exam
                          SET status = 'pending'
                          WHERE user_id = ?";
    $stmt_update_status = $conn->prepare($sql_update_status);

    // Check if the statement is prepared successfully
    if (!$stmt_update_status) {
      // Handle the case when preparing the statement fails
      die('Statement preparation failed: ' . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt_update_status->bind_param("i", $userId);

    // Execute the prepared statement
    if (!$stmt_update_status->execute()) {
      // Handle the case when execution fails
      die('Statement execution failed: ' . $stmt_update_status->error);
    }

    // Step 9: Close the statement for updating the status
    $stmt_update_status->close();
  }

  // Step 10: Return a success response
  echo json_encode(['status' => 'success', 'message' => 'User(s) Reset Was Successful!']);
} else {
  // Step 11: Return an error response (if needed)
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Close the database connection
$conn->close();
?>
