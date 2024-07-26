<?php

include("connection.php");

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the exam ID and user ID from the POST data
$examID = $_POST['examID'];
$userID = $_POST['userID'];
$percentage="";
$roundUpVal = '';

// Select all questions with their options and answers from QUESTIONS table
$questionsSql = "SELECT * FROM questions WHERE exam_id = ?";
$stmt = $conn->prepare($questionsSql);
$stmt->bind_param("i", $examID);
$stmt->execute();
$questionsResult = $stmt->get_result();
$stmt->close();

// Initialize variables
$totalScore = 0;
$skippedQuestions = 0;
$incorrectQuestions = 0;
$correctQuestions = 0;
$totalQuestions = $questionsResult->num_rows; // Get the total number of questions

// Iterate over the questions
while ($questionRow = $questionsResult->fetch_assoc()) {
    $questionID = $questionRow['id'];
    $correctAnswer = intval($questionRow['answer']); // Convert the answer to integer
  
    // Get the selected option for the current question from SELECTED_OPTIONS table
    $selectedOptionSql = "SELECT selected_option FROM selected_options WHERE user_exam_id = ? AND question_id = ?";
    $stmt = $conn->prepare($selectedOptionSql);
    $stmt->bind_param("ii", $userID, $questionID);
    $stmt->execute();
    $selectedOptionResult = $stmt->get_result();
    $stmt->close();
  
    // Check if the question was skipped
    if ($selectedOptionResult->num_rows === 0) {
      $skippedQuestions++;
    } else {
      $selectedOptionRow = $selectedOptionResult->fetch_assoc();
      $selectedOptionInt = intval($selectedOptionRow['selected_option']);
  
      // Check if the selected option is correct
    // Check if the selected option is correct
if (strcasecmp($selectedOptionRow['selected_option'], $questionRow['answer']) === 0) {
    $totalScore += 1;
    $correctQuestions++;
  } else {
    $incorrectQuestions++;
  }
  
    }
  }


 // Now calculate correct scores in percentage and round to two decimal places
$percentage = round(($totalScore / $totalQuestions) * 100, 2);
$roundUpVal = ceil($percentage);

  
// Store the scores, end time, and status in the USERS_EXAM table
$updateScoresSql = "UPDATE users_exam SET scores = ?, end_time = NOW(), status = 'completed' WHERE user_id = ? AND exam_id = ?";
$stmt = $conn->prepare($updateScoresSql);
$stmt->bind_param("iii", $roundUpVal, $userID, $examID);
$stmt->execute();
$stmt->close();

// Get the number of CORRECT, INCORRECT, and SKIPPED questions attempted by the user
$attemptedQuestionsSql = "SELECT COUNT(*) AS attempted FROM selected_options WHERE user_exam_id = ?";
$stmt = $conn->prepare($attemptedQuestionsSql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$attemptedQuestionsResult = $stmt->get_result();
$attemptedQuestionsRow = $attemptedQuestionsResult->fetch_assoc();
$attemptedQuestions = $attemptedQuestionsRow['attempted'];
$stmt->close();

$skippedQuestions = $totalQuestions - ($correctQuestions + $incorrectQuestions);

// Construct the response array
$response = array(
  'totalScore' => $roundUpVal,
  'correctQuestions' => $correctQuestions,
  'incorrectQuestions' => $incorrectQuestions,
  'skippedQuestions' => $skippedQuestions
);

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
