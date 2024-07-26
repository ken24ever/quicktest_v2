<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the AJAX request
    $examId = $_POST['exam_id'];
    $userId = $_POST['user_id'];

    // Insert data into the script_execution_log table
    $insertQuery = "INSERT INTO script_execution_log (execution_time, exam_id, user_id) VALUES (NOW(), $examId, $userId)";
    $conn->query($insertQuery);

      // You may also want to clean up old records based on a certain time interval, e.g., delete records older than 24 hours
      $cleanupQuery = "DELETE FROM script_execution_log WHERE execution_time < NOW() - INTERVAL 24 HOUR";
      $conn->query($cleanupQuery);

    // Send a response (you can customize this based on your needs)
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Script execution information stored successfully.']);
} else {
    // Handle other request methods if needed
    http_response_code(405); // Method Not Allowed
}


?>
