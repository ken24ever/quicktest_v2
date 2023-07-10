<?php
// Start the session
session_start();

// Connect to database
include("../connection.php");

// Set the number of questions to display per page
$questionsPerPage = 6;

// Get the current page number from the AJAX request
$pageNumber = isset($_POST['page']) ? (int)$_POST['page'] : 1;

// Calculate the offset
$offset = ($pageNumber - 1) * $questionsPerPage;

// Get the exam id from the POST request (if provided)
$examId = isset($_POST['exam_id']) ? $_POST['exam_id'] : null;

// Get the total number of questions
if ($examId) {
    $sqlCount = "SELECT COUNT(*) FROM questions WHERE exam_id = '$examId'";
} else {
    $sqlCount = "SELECT COUNT(*) FROM questions";
}

$result = mysqli_query($conn, $sqlCount);
$row = mysqli_fetch_row($result);
$totalQuestions = $row[0];

// Get the questions for the current page
if ($examId) {
    $sql = "SELECT * FROM questions WHERE exam_id = '$examId' ORDER BY id DESC LIMIT $offset, $questionsPerPage";
} else {
    $sql = "SELECT * FROM questions ORDER BY id DESC LIMIT $offset, $questionsPerPage";
}
$questions = mysqli_query($conn, $sql);

// Loop through the questions and add them to the array
$questionsArray = array();
while ($row = mysqli_fetch_assoc($questions)) {
    // Assign the entire $row array to $_SESSION['question']
    $_SESSION['question'] = $row;

    // Push the question to the $questionsArray
    array_push($questionsArray, $_SESSION['question']);
}

// Return questions and pagination details as a JSON response
header('Content-Type: application/json');
echo json_encode(array(
    'status' => 'success',
    'questions' => $questionsArray,
    'totalPages' => ceil($totalQuestions / $questionsPerPage),
    'currentPage' => $pageNumber
));

// Close the database connection
$conn->close();
?>
