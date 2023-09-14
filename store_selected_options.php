<?php
// Start the session
session_start();

// Set database connection variables
include("connection.php");

// Retrieve the exam ID and pagination parameters from the AJAX request
$examID = isset($_POST['examID']) ? $_POST['examID'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : '';
$limit = isset($_POST['limit']) ? $_POST['limit'] : '';

// Calculate the offset for pagination
$offset = (intval($page) - 1) * (int)$limit;

// Retrieve the selected options from the AJAX request
$selectedOptions = $_POST['selectedOptions'] ?? [];

// Store the selected options in the session
$_SESSION['selectedOptions'] = $selectedOptions;

// Construct the SQL query to retrieve the questions for the current page
$sql = "SELECT * FROM questions WHERE exam_id = '$examID' LIMIT $offset, $limit";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Initialize the question number
  $questionNumber = $offset + 1;

  // Fetch all questions for the exam
  $totalQuestionsQuery = "SELECT COUNT(*) AS total FROM questions WHERE exam_id = '$examID'";
  $totalQuestionsResult = $conn->query($totalQuestionsQuery);
  $totalQuestionsRow = $totalQuestionsResult->fetch_assoc();
  $totalQuestions = $totalQuestionsRow['total'];

  // Loop through each question and display them
  while ($row = $result->fetch_assoc()) {
    $questionID = $row['id'];
    $questionText = $row['question'];

    // Retrieve the selected option for the current question
    $selectedOption = isset($selectedOptions[$questionID]) ? $selectedOptions[$questionID] : '';

    // Check if the user has selected a new option for this question
    if (isset($_POST['selectedOptions'][$questionID])) {
      $selectedOption = $_POST['selectedOptions'][$questionID];
      // Update the selected option
      $selectedOptions[$questionID] = $selectedOption;
    }

    // Display the question
    echo "<div class='question'>";
    echo "<p>Question $questionNumber: $questionText</p> <br>";

    // Start the question form
    echo "<form method='POST' data-question-id='$questionID'>";

    // Display the answer options as radio buttons for the user to select
    $options = ['A', 'B', 'C', 'D', 'E'];
    foreach ($options as $option) {
      $optionText = $row['option_' . strtolower($option)];
      $optionImagePath = $row['option_' . strtolower($option) . '_image_path'];

      echo "<label><input type='radio' name='answer_$questionID' value='$option'";
      if ($selectedOption === $option) {
        echo " checked";
      }
      echo ">$optionText</label><br>";

      // Check if the option has an image
      if (!empty($optionImagePath)) {
        echo "<img src='$optionImagePath' alt='Option $option Image'>";
      }
    }

    // Close the question form
    echo "</form>";

    echo "</div>";
    $questionNumber++; // Increment the question number
  }

  // Update the selected options in the session
  $_SESSION['selectedOptions'] = $selectedOptions;

  // Display pagination buttons
  echo "<div class='pagination-buttons'>";
  if ($page > 1) {
    echo "<button class='prev-button' data-page='" . ($page - 1) . "' >Previous</button>";
  }
  if ($offset + $limit < $totalQuestions) {
    echo "<button class='next-button' data-page='" . ($page + 1) . "' >Next</button>";
  }
  echo "</div>";
} else {
  echo "No questions found.";
}

// Close the database connection
$conn->close();
?>
