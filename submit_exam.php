<?php
session_start();
include("connection.php");
<<<<<<< HEAD
//var_dump($_POST['selectedOptions']);
// Check if selectedOptions data is received via POST
if (isset($_POST['selectedOptions'])) {
  // Get the JSON data and decode it
  $selectedOptionsJSON = $_POST['selectedOptions'];
  $selectedOptions = json_decode($selectedOptionsJSON, true);

  // Check if json_decode was successful and $selectedOptions is an array
  if (is_array($selectedOptions)) {
    $usersExamId = $_SESSION['id'] ?? '';
    $examId = $_POST['examID'] ?? ''; // Get the exam ID from the AJAX request

    // Loop through the selected options
    foreach ($selectedOptions as $questionId => $options) {
      // Convert the array of options to a serialized string
      $commaSeparatedOptions = implode(',', $options);


      // Check if the selected options already exist in the selected_options table
      $sql = "SELECT * FROM selected_options WHERE user_exam_id = ? AND question_id = ?";

      // Prepare the SQL statement
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('ii', $usersExamId, $questionId);

      // Execute the SQL query
      $stmt->execute();

      // Fetch the result set
      $result = $stmt->get_result();

      // Check for errors in the SQL statement execution
      if ($stmt->error) {
        echo "SQL statement error: " . $stmt->error;
      }

      // Close the statement
      $stmt->close(); // Close the statement here after fetching the result set

      // Check if a row exists
      if ($result->num_rows > 0) {
        // A row exists, update the selected_options
        $updateSql = "UPDATE selected_options SET selected_option = ? WHERE user_exam_id = ? AND question_id = ?";

        // Prepare the update SQL statement
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('sii', $commaSeparatedOptions, $usersExamId, $questionId);

        // Execute the update SQL statement
        $updateStmt->execute();

        // Close the update statement
        $updateStmt->close();

        echo "Updated row for question ID: " . $questionId . "<br>";
      } else {
        // No row exists, insert a new record
        $insertSql = "INSERT INTO selected_options (user_exam_id, exam_id, question_id, selected_option) VALUES (?, ?, ?, ?)";

        // Prepare the insert SQL statement
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('iiis', $usersExamId, $examId, $questionId, $commaSeparatedOptions);

        // Execute the insert SQL statement
        $insertStmt->execute();

        // Close the insert statement
        $insertStmt->close();

        echo "Inserted row for question ID: " . $questionId . "<br>";
      }
    }

    // Close the database connection
    $conn->close();

    // Prepare the response data
    $response = [
      'status' => 'success',
      'message' => 'Selected options stored successfully'
    ];
  } else {
    // JSON data could not be properly decoded
    $response = [
      'status' => 'error',
      'message' => 'Invalid JSON data received'
    ];
  }
} else {
  // selectedOptions data not received via POST
  $response = [
    'status' => 'error',
    'message' => 'selectedOptions data not received'
  ];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

=======

$selectedOptionsJSON = $_POST['selectedOptions'];
$selectedOptions = json_decode($selectedOptionsJSON, true);
$usersExamId = $_SESSION['id'] ?? '';
$examId = $_POST['examID'] ?? ''; // Get the exam ID from the AJAX request

// Loop through the selected options
foreach ($selectedOptions as $questionId => $option) {
  // Check if the selected option already exists in the selected_options table
  $sql = "SELECT * FROM selected_options WHERE user_exam_id = ? AND question_id = ?";

  // Prepare the SQL statement
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $usersExamId, $questionId);

  // Execute the SQL query
  $stmt->execute();

  // Fetch the result set
  $result = $stmt->get_result();

  // Check if a row exists 
  if ($result->num_rows > 0) {
    // A row exists, update the selected_option
    $updateSql = "UPDATE selected_options SET selected_option = ? WHERE user_exam_id = ? AND question_id = ?";

    // Prepare the update SQL statement
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param('sii', $option, $usersExamId, $questionId);

    // Execute the update SQL statement
    $updateStmt->execute();
  } else {
    // No row exists, insert a new record
    $insertSql = "INSERT INTO selected_options (user_exam_id, exam_id, question_id, selected_option) VALUES (?, ?, ?, ?)";

    // Prepare the insert SQL statement
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param('iiis', $usersExamId, $examId, $questionId, $option);

    // Execute the insert SQL statement
    $insertStmt->execute();
  }
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();

// Prepare the response data
$response = [
  'status' => 'success',
  'message' => 'Selected options stored successfully'
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
?>
