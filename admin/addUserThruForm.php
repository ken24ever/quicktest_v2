<?php
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

// Set database connection variables
include("../connection.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data sent from the event tracker
    $names = $_POST['names'];
    $editUsername = $_POST['editUsername'];
    $user_batch_file = $_POST['user_batch_file']; 
    $searchUsername = $_POST['searchUsername'];
    $description  = $action = "";

    // Check if the 'names' field is empty or not
    if (empty($names)) {
        $action = 'Add User';
        $description = 'User name field was empty when logged in user: (' . $fullNames . ') clicked the submit button';
    } else {
        $action = 'Add User'; 
        $description = 'Logged in admin user: (' . $fullNames . ') created this record with the name of: "' . $names . '"';
    }

    //when admin user edits users name after searching
    if (!empty($editUsername)) {
        $action = 'Edit User'; 
        $description = 'Logged in admin user: (' . $fullNames . ') edited or altered details of user with name: "' . $editUsername . '"';
    }

    // Check if the 'user_batch_file' field is empty or not
    if (!empty($user_batch_file)) {
        $action = 'Batch Users Upload'; 
        $description = 'Logged in admin user: (' . $fullNames . ') may have successfully created users by uploading file with filename: "' . $user_batch_file . '"';
    }

    // Check if the 'searchUsername' field is empty or not
    if (!empty($searchUsername)) {
        $action = 'Search User'; 
        $description = 'Logged in admin user: (' . $fullNames . ') searched for: "' . $searchUsername . '"';
    }

    // Prepare the SQL statement to insert the record into the audit_tray table
    $sql = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $fullNames, $userID, $description, $action);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Send success response (You can choose to send a response if needed)
        // echo json_encode(['success' => true, 'message' => 'Record added to audit_tray']);
    } else {
        // Send error response if the query failed
       // echo json_encode(['success' => false, 'message' => 'Failed to add record to audit_tray']);
        // You may log the error for debugging purposes
       // error_log("Failed to add record to audit_tray: " . $stmt->error);
    }

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    // Send error response
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>
