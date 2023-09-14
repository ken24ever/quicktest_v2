<?php
// Set database connection variables
include("../connection.php");

// Retrieve exams from the database
$sql = "SELECT * FROM exams";
$result = $conn->query($sql);

// Build an array of exams
$exams = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $exam = array(); 
        $exam['id'] = $row['id'];
        $exam['title'] = $row['title'];
        $exam['description'] = htmlspecialchars($row['description']); // escape special characters in description field

        $exam['duration'] = $row['duration'];

        //here we get all exams as options to the admin when registering candidates
       // $exam['exam_options'] = '<option value="'.$exam['title'].'">Exam Title : '.$exam['title'].' Description : ['.$exam['description'].']</option>';
        
        // Retrieve number of questions for this exam
        $sql_count = "SELECT COUNT(*) AS count FROM questions WHERE exam_id = " . $row["id"];
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $exam['num_questions'] = $row_count['count'];
        
        // Add exam to the array
        $exams[] = $exam;
    }
}

// Convert the array to JSON format
$json = json_encode($exams);

// Send the JSON response
header('Content-Type: application/json');
echo $json;

// Close the database connection
$conn->close();
?>