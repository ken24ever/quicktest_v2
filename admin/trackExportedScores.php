<?php
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

// Set database connection variables
include("../connection.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data sent from the event tracker
    $exam_Title = $_POST['exam_Title'];
    $checkedCount = $_POST['checkedCount'];
    $description  = $action = "";

    // Check if the 'exam_Title' field is empty or not
    if (!empty($exam_Title)) {
        $action = 'Export Users Scores';
        $description = 'Logged in admin user: (' . $fullNames . ') exported these number: ('.$checkedCount.') of users scores and details for exam with title: "' . $exam_Title . '"';
    } 
    

    // Prepare the SQL statement to insert the record into the audit_tray table
    $sql = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES ( '$fullNames', '$userID', '$description', '$action')";
    $stmt = mysqli_query($conn,$sql);
   // $stmt->bind_param("siss",);

    // Close the database connection
    $conn->close();
} else {
    // Invalid request method
    // Send error response
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>
