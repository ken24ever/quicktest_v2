<?php
// Set database connection variables
include("../connection.php");

// Check if the delete form has been submitted
if (isset($_POST["username"])) {
    // Retrieve the usernames to be deleted
    $usernames = $_POST["username"];

    // Ensure that $usernames is an array
    if (!is_array($usernames)) {
        $usernames = [$usernames];
    }

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