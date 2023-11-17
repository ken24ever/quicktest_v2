<?php
// Set database connection variables
include("../connection.php");



// Retrieve exams from the database with pagination
$sql = "SELECT * FROM exams "; 
$result = $conn->query($sql);

// Build an array of exams
$exams = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exam = array();
        $exam['id'] = $row['id'];
        $exam['title'] = $row['title'];
        $exam['description'] = htmlspecialchars($row['description']); // escape special characters in description field
        $exam['duration'] = $row['duration'];

       
    

        // Add exam to the array
        $exams[] = $exam;
    }
}




// Create an array to hold the exam data and pagination information
$response = array(
    'exams' => $exams,

);

// Convert the array to JSON format
$json = json_encode($response);

// Send the JSON response
header('Content-Type: application/json');
echo $json;

// Close the database connection
$conn->close();
?>
