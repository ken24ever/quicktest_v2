<?php
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
                  WHERE user_id = '$userId' AND exam_id='$examId' ";

        if (mysqli_query($conn, $query)) {
            // Delete the selected options for the specific user and exam
            $truncateTable = "DELETE FROM selected_options WHERE user_exam_id = '$userId' AND exam_id = '$examId'";
            
            if (mysqli_query($conn, $truncateTable)) {
                // Return success message with the username and exam
                echo json_encode(array("status" => "success", "message" => "Exams reset for the user: " . $username, "with exam title as" => $title));
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
