<?php
session_start();
include("connection.php");

$userExamId = $_SESSION['id'] ?? ''; // Assuming 'id' is the session variable storing the user's exam ID

// Retrieve the selected options from the database based on the user's exam ID
$sql = "SELECT question_id, selected_option FROM selected_options WHERE user_exam_id = ? ORDER BY question_id asc";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userExamId);
$stmt->execute();
$result = $stmt->get_result();

$selectedOptions = array();
while ($row = $result->fetch_assoc()) {
    $questionId = $row['question_id'];
    $selectedOption = $row['selected_option'];
    $selectedOptions[$questionId] = $selectedOption;
}

// Send the selected options as JSON response
header('Content-Type: application/json');
echo json_encode($selectedOptions);
?>
