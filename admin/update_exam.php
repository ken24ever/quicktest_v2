<?php
<<<<<<< HEAD
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

// Check if the form was submitted
if (isset($_POST['examId'])) {
    
    // Get the form data
    $examId = $_POST['examId'];
    $examTitle = $_POST['examTitle'];
    $examDesc = $_POST['examDesc'];
    $examDuration = $_POST['examDuration'];
    
   // Set database connection 
    include("../connection.php");

    
    // Escape the form data to prevent SQL injection attacks
    $examTitle = mysqli_real_escape_string($conn, $examTitle);
    $examDuration = mysqli_real_escape_string($conn, $examDuration);
    
    // Construct the SQL UPDATE statement
    $sql = "UPDATE exams SET title = '$examTitle', duration = '$examDuration', description = '$examDesc' WHERE id = '$examId'";
    
    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        echo "Exam with the ID of ".$examId." updated successfully";
    } else {
        echo "<b style='color:red !important'>Error updating exam with the ID of ".$examId.": </b>" . mysqli_error($conn);
    }
<<<<<<< HEAD

            $action = 'Exam Details Edited'; 
            $description = 'Logged in admin user: (' . $fullNames . ') edited exam title "' . $examTitle . '"';

                // Prepare the SQL statement to insert the record into the audit_tray table
          $sql = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES (?,?,?,?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("siss", $fullNames, $userID, $description, $action);
      
          // Execute the query and check if it was successful
          if ($stmt->execute()) {
              // Send success response (You can choose to send a response if needed)
               //echo json_encode(['success' => true, 'message' => 'Record added to audit_tray']);
          } else {
              // Send error response if the query failed
              //echo json_encode(['success' => false, 'message' => 'Failed to add record to audit_tray']);
              // You may log the error for debugging purposes
             // error_log("Failed to add record to audit_tray: " . $stmt->error);
          }
=======
    
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    // Close the database connection
    mysqli_close($conn);
}

?>
