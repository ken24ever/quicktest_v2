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

    // Track reseted user IDs
    $action = 'Batch Users Reset';
    $description = 'Logged in admin user: (' . $fullNames . ') did a batch user reset for these number of users: "' . $userIDsCount . '"';

    // Prepare the SQL statement to insert the record into the audit_tray table
    $sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES (?, ?, ?, ?)";
    $stmtsqlDel = $conn->prepare($sqlDel);
    $stmtsqlDel->bind_param("siss", $fullNames, $userID, $description, $action);

    // Execute the prepared statement for audit_tray insertion
    if (!$stmtsqlDel->execute()) {
        die('Statement execution failed: ' . $stmtsqlDel->error);
    }

    // Step 1: Update the remaining_time column in the users table to NULL for the selected users
    foreach ($userIds as $userId) {
        
        // Prepare the SQL statement to update remaining_time to NULL
        $sqlUpdateRemainingTime = "UPDATE users SET remaining_time = NULL WHERE id = ?";
        $stmtUpdateRemainingTime = $conn->prepare($sqlUpdateRemainingTime);

        // Check if the statement is prepared successfully
        if (!$stmtUpdateRemainingTime) {
            // Handle the case when preparing the statement fails
            die('Statement preparation failed: ' . $conn->error);
        }

        // Bind parameters to the prepared statement
        $stmtUpdateRemainingTime->bind_param("i", $userId);

        // Execute the prepared statement
        if (!$stmtUpdateRemainingTime->execute()) {
            // Handle the case when execution fails
            die('Statement execution failed: ' . $stmtUpdateRemainingTime->error);
        }

        // Close the statement for updating remaining_time
        $stmtUpdateRemainingTime->close();

        // Step 2: Update the status column in the users_exam table to 'pending'
        $sqlUpdateStatus = "UPDATE users_exam SET status = 'pending' WHERE user_id = ?";
        $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);

        // Check if the statement is prepared successfully
        if (!$stmtUpdateStatus) {
            // Handle the case when preparing the statement fails
            die('Statement preparation failed: ' . $conn->error);
        }

        // Bind parameters to the prepared statement
        $stmtUpdateStatus->bind_param("i", $userId);

        // Execute the prepared statement
        if (!$stmtUpdateStatus->execute()) {
            // Handle the case when execution fails
            die('Statement execution failed: ' . $stmtUpdateStatus->error);
        }

        // Close the statement for updating status
        $stmtUpdateStatus->close();

        // Step 3: Get the user_exam_id and exam_id for each user from the users_exam table
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

        // Step 4: Loop through the user exams and delete the corresponding selected_options
        while ($row_user_exams = $result_user_exams->fetch_assoc()) {
            $user_exam_id = $row_user_exams['user_exam_id'];
            $exam_id = $row_user_exams['exam_id'];

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

            // Close the statement for deleting selected_options
            $stmt_delete_selected_options->close();

            // Step 6: Fetch the examName using the exam_id from the exams table
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

            // Close the statement for the examName retrieval
            $stmt_get_exam_name->close();
        }

        // Close the statement for the user exams retrieval
        $stmt_get_user_exams->close();
    }

    // Step 7: Return a success response
    echo json_encode(['status' => 'success', 'message' => 'User(s) Reset Was Successful!']);
} else {
    // Step 8: Return an error response (if needed)
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Close the prepared statement for audit_tray insertion
$stmtsqlDel->close();

// Close the database connection
$conn->close();
?>
 