<?php

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
    
    // Close the database connection
    mysqli_close($conn);
}

?>
