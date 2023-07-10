<?php
// Set database connection variables
include("../connection.php");

// Get values submitted via the form
$name = $_POST['names'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$examNames = $_POST['examsList']; // Retrieve the array of selected values
$gender = $_POST['gender'];
$app = $_POST['app'];
// Check if the username or email already exists
$sql_check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows > 0) {
    echo "Username or email already exists";
} else {
    // Insert new user into the database
    if (!empty($examNames)) {
        $examNames = array_unique($examNames); // Remove duplicates from the array
        
        $escapedExamNames = array_map(function ($name) use ($conn) {
            return mysqli_real_escape_string($conn, $name);
        }, $examNames);
        
        $examNamesString = implode(",", $escapedExamNames);
        
        // Insert the user into the 'users' table
        $sql_insert_user = "INSERT INTO users (name, email, username, password, gender, application, examName) VALUES ('$name', '$email', '$username', '$password', '$gender', '$app', '$examNamesString')";
        
        if ($conn->query($sql_insert_user) === TRUE) {
            $user_id = $conn->insert_id; // Retrieve the user ID
            
            // Insert the user-exam records into the 'users_exam' table
            $sql_insert_user_exams = "INSERT INTO users_exam (user_id, exam_id, status, scores) VALUES";
            
            $values = array();
            foreach ($examNames as $examName) {
                // Retrieve the exam ID based on the exam name
                $sql_select_exam = "SELECT id FROM exams WHERE title = '$examName'";
                $result_select_exam = $conn->query($sql_select_exam);
                
                if ($result_select_exam->num_rows > 0) {
                    $row = $result_select_exam->fetch_assoc();
                    $exam_id = $row['id'];
                    
                    $values[] = "('$user_id', '$exam_id', 'PENDING', '')";
                }
            }
            
            if (!empty($values)) {
                $sql_insert_user_exams .= implode(", ", $values);
                
                if ($conn->query($sql_insert_user_exams) === TRUE) {
                    echo "New user added successfully";
                } else {
                    echo "Error: " . $sql_insert_user_exams . "<br>" . $conn->error;
                }
            } else {
                echo "No matching exams found";
            }
        } else {
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }
    } else {
        echo "Please select at least one exam";
    }
}

// Close the database connection
$conn->close();
?> 
