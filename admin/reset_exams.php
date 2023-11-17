<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742

session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

<<<<<<< HEAD
=======
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
// Set database connection variables
include("../connection.php");

// Get logged-in user's exam IDs and change status to pending
$username = $_GET['user'];

// Retrieve the user's ID
$userQuery = "SELECT id FROM users WHERE username = '$username'";
$userResult = mysqli_query($conn, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userRow = mysqli_fetch_assoc($userResult);
    $userId = $userRow['id'];

    $title = $_GET['resetCode'];

    // Retrieve the exam ID based on the provided title
    $examQuery = "SELECT id FROM exams WHERE title = '$title'";
    $examResult = mysqli_query($conn, $examQuery);

    if ($examResult && mysqli_num_rows($examResult) > 0) {
        $examRow = mysqli_fetch_assoc($examResult);
        $examId = $examRow['id'];

        // Update the status of the user's exams to pending
        $query = "UPDATE users_exam 
                  SET status = 'pending' 
<<<<<<< HEAD
                  WHERE user_id = '$userId' AND exam_id='$examId' "; 
=======
<<<<<<< HEAD
                  WHERE user_id = '$userId' AND exam_id='$examId' "; 
=======
                  WHERE user_id = '$userId' AND exam_id='$examId' ";
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742

        if (mysqli_query($conn, $query)) {
            // Delete the selected options for the specific user and exam
            $truncateTable = "DELETE FROM selected_options WHERE user_exam_id = '$userId' AND exam_id = '$examId'";
            
            if (mysqli_query($conn, $truncateTable)) {
                // Return success message with the username and exam
                echo json_encode(array("status" => "success", "message" => "Exams reset for the user: " . $username, "with exam title as" => $title));
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
            
                $action = 'Single User Reset'; 
                $description = 'Logged in admin user: (' . $fullNames . ') reseted exam title: "'. $title .'" for user with username: "' . $username . '" ';

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

<<<<<<< HEAD
=======
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
            } else {
                // Return error message
                echo json_encode(array("status" => "error", "message" => "Failed to delete selected options."));
            }
        } else {
            // Return error message for failed exam update
            echo json_encode(array("status" => "error", "message" => "Failed to update user's exams."));
        }
    } else {
        // Return error message for invalid exam title
        echo json_encode(array("status" => "error", "message" => "Invalid exam title."));
    }
} else {
    // Return error message for user not found
    echo json_encode(array("status" => "error", "message" => "User not found."));
}

// Close the database connection
$conn->close();
?>
