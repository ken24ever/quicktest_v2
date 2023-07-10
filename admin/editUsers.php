<?php
// Set database connection variables
include("../connection.php");

// Create an empty response array
$response = array();

// Check if the edit form has been submitted
if (isset($_POST["id"])) {
    // Retrieve the edit form data
    $id = $_POST["id"];
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $examName = $_POST["examName"];

    // Check if the examName has been modified
    $sql_check = "SELECT examName FROM users WHERE id = '$id'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $oldExamName = $row["examName"];

        // Compare the old and new examName values
        $oldExamNames = explode(",", $oldExamName);
        $newExamNames = explode(",", $examName);

        // Find the added exam names
        $addedExamNames = array_diff($newExamNames, $oldExamNames);

        // Find the removed exam names
        $removedExamNames = array_diff($oldExamNames, $newExamNames);

        // Update the USERS_EXAM table for added exam names
        foreach ($addedExamNames as $addedExamName) {
            $sql_insert = "INSERT INTO users_exam (user_id, exam_id, status, scores) VALUES ('$id', (SELECT id FROM exams WHERE title = '$addedExamName'), 'pending', '')";
            $conn->query($sql_insert);
        }

        // Update the USERS_EXAM table for removed exam names
        foreach ($removedExamNames as $removedExamName) {
            $sql_delete = "DELETE FROM users_exam WHERE user_id = '$id' AND exam_id = (SELECT id FROM exams WHERE title = '$removedExamName')";
            $conn->query($sql_delete);
        }
    }

    // Construct the SQL query to update the user
    $sql_update = "UPDATE users SET name='$name', username='$username', email='$email', password='$password', examName='$examName' WHERE id='$id'";

    // Execute the update query
    if ($conn->query($sql_update) === TRUE) {
        $response['success'] = true;
        $response['message'] = "User Details Updated Successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating user: " . $conn->error;
    }
} else {
    $response['success'] = false;
    $response['message'] = "No User ID Provided";
}

// Convert the response array to JSON
echo json_encode($response);

// Close the database connection
$conn->close();
?>
