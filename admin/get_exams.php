<?php
// Set database connection variables
include("../connection.php");

// Retrieve the current page number from the request
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Define the number of exams to display per page
$perPage = 4;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $perPage;

// Retrieve exams from the database with pagination
$sql = "SELECT * FROM exams LIMIT $offset, $perPage"; 
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

        // Retrieve number of questions for this exam
        $sql_count = "SELECT COUNT(*) AS count FROM questions WHERE exam_id = " . $row["id"];
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $exam['num_questions'] = $row_count['count'];

        // Add exam to the array
        $exams[] = $exam;
    }
}

// Retrieve the total number of exams
$sql_total = "SELECT COUNT(*) AS total FROM exams";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$totalExams = $row_total['total'];

// Calculate the total number of pages
$totalPages = ceil($totalExams / $perPage);

// Create an array to hold the exam data and pagination information
$response = array(
    'exams' => $exams,
    'total_pages' => $totalPages
);

// Convert the array to JSON format
$json = json_encode($response);

// Send the JSON response
header('Content-Type: application/json');
echo $json;

// Close the database connection
$conn->close();
?>
