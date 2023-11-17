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

// Check if the delete form has been submitted
if (isset($_POST["username"])) {
    // Retrieve the usernames to be deleted
    $usernames = $_POST["username"];
<<<<<<< HEAD
    $action = 'Single User Delete'; 
    $description = 'Logged in admin user: (' . $fullNames . ') deleted user record with username: "' . $usernames . '"';
=======
<<<<<<< HEAD
    $action = 'Single User Delete'; 
    $description = 'Logged in admin user: (' . $fullNames . ') deleted user record with username: "' . $usernames . '"';
=======

>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
    // Ensure that $usernames is an array
    if (!is_array($usernames)) {
        $usernames = [$usernames];
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
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
    // Escape special characters in usernames
    $usernames = array_map(function ($username) use ($conn) {
        return mysqli_real_escape_string($conn, $username);
    }, $usernames);

    // Construct the SQL query to retrieve the user IDs for the deleted users
    $sql_select_user_ids = "SELECT id FROM users WHERE username IN ('" . implode("', '", $usernames) . "')";
    $result_select_user_ids = $conn->query($sql_select_user_ids);

    // Store the user IDs in an array
    $user_ids = [];
    while ($row = $result_select_user_ids->fetch_assoc()) {
        $user_ids[] = $row['id'];
    }

    // Check if any user IDs were retrieved
    if (count($user_ids) > 0) {
        // Construct the SQL query to delete the user-exam records
        $sql_delete_user_exams = "DELETE FROM users_exam WHERE user_id IN (" . implode(", ", $user_ids) . ")";

        // Execute the query to delete the user-exam records
        if ($conn->query($sql_delete_user_exams) === TRUE) {
            // Now delete the users from the 'users' table
            $sql_delete_users = "DELETE FROM users WHERE username IN ('" . implode("', '", $usernames) . "')";

            // Execute the query to delete the users
            if ($conn->query($sql_delete_users) === TRUE) {
                echo "User deleted successfully";
            } else {
                echo "Error deleting users: " . $conn->error;
            }
        } else {
            echo "Error deleting user-exam records: " . $conn->error;
        }
    } else {
        echo "No user IDs found";
    }
}

// Close the database connection
$conn->close();
?>