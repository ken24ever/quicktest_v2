<?php
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 


// Connect to the database
include("../connection.php");

$uploadDir = "uploads/"; // Set the upload directory
$response = array();

// Get the form data
$questionId = isset($_POST['questionId']) ? $_POST['questionId'] : null;
$questionText = isset($_POST['question']) ? $_POST['question'] : null;
$optionA = isset($_POST['optionA']) ? $_POST['optionA'] : null;
$optionB = isset($_POST['optionB']) ? $_POST['optionB'] : null;
$optionC = isset($_POST['optionC']) ? $_POST['optionC'] : null;
$optionD = isset($_POST['optionD']) ? $_POST['optionD'] : null;
$optionE = isset($_POST['optionE']) ? $_POST['optionE'] : null;
$imgQues = isset($_FILES['question_image_']['name']) ? $_FILES['question_image_']['name'] : null;
$imgOptA = isset($_FILES['image_optionA']['name']) ? $_FILES['image_optionA']['name'] : null;
$imgOptB = isset($_FILES['image_optionB']['name']) ? $_FILES['image_optionB']['name'] : null;
$imgOptC = isset($_FILES['image_optionC']['name']) ? $_FILES['image_optionC']['name'] : null;
$imgOptD = isset($_FILES['image_optionD']['name']) ? $_FILES['image_optionD']['name'] : null;
$imgOptE = isset($_FILES['image_optionE']['name']) ? $_FILES['image_optionE']['name'] : null;
$answer = isset($_POST['answer']) ? $_POST['answer'] : null;

//tracker set up here
$action = 'Question Edit'; 
$description = 'Logged in admin user: (' . $fullNames . ') edited exam question ID: "'. $questionId .'" ';

    // Prepare the SQL statement to insert the record into the audit_tray table
$sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES (?,?,?,?)";
$stmtsqlDel = $conn->prepare($sqlDel);
$stmtsqlDel->bind_param("siss", $fullNames, $userID, $description, $action);

// Execute the query and check if it was successful
if ($stmtsqlDel->execute()) {
  // Send success response (You can choose to send a response if needed)
   //echo json_encode(['success' => true, 'message' => 'Record added to audit_tray']);
} else {
  // Send error response if the query failed
  //echo json_encode(['success' => false, 'message' => 'Failed to add record to audit_tray']);
  // You may log the error for debugging purposes
 // error_log("Failed to add record to audit_tray: " . $stmt->error);
}

// Prepare the SQL statement
$sql = "UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, option_e=?, answer=?, image_ques=?, option_a_image_path=?, option_b_image_path=?, option_c_image_path=?, option_d_image_path=?, option_e_image_path=? WHERE id=?";

// Prepare the query
$stmt = $conn->prepare($sql);

// Generate unique names for the uploaded files
$questionImageNewName = !empty($imgQues) ? $uploadDir . uniqid('qimg_', true) . '.' . pathinfo($imgQues, PATHINFO_EXTENSION) : null;
$optionAImageNewName = !empty($imgOptA) ? $uploadDir . uniqid('optionA_', true) . '.' . pathinfo($imgOptA, PATHINFO_EXTENSION) : null;
$optionBImageNewName = !empty($imgOptB) ? $uploadDir . uniqid('optionB_', true) . '.' . pathinfo($imgOptB, PATHINFO_EXTENSION) : null;
$optionCImageNewName = !empty($imgOptC) ? $uploadDir . uniqid('optionC_', true) . '.' . pathinfo($imgOptC, PATHINFO_EXTENSION) : null;
$optionDImageNewName = !empty($imgOptD) ? $uploadDir . uniqid('optionD_', true) . '.' . pathinfo($imgOptD, PATHINFO_EXTENSION) : null;
$optionEImageNewName = !empty($imgOptE) ? $uploadDir . uniqid('optionE_', true) . '.' . pathinfo($imgOptE, PATHINFO_EXTENSION) : null;

// Move the uploaded files to the "uploads/" directory
if (!empty($imgQues)) {
  move_uploaded_file($_FILES['question_image_']['tmp_name'], $questionImageNewName);
}
if (!empty($imgOptA)) {
  move_uploaded_file($_FILES['image_optionA']['tmp_name'], $optionAImageNewName);
}
if (!empty($imgOptB)) {
  move_uploaded_file($_FILES['image_optionB']['tmp_name'], $optionBImageNewName);
}
if (!empty($imgOptC)) {
  move_uploaded_file($_FILES['image_optionC']['tmp_name'], $optionCImageNewName);
}
if (!empty($imgOptD)) {
  move_uploaded_file($_FILES['image_optionD']['tmp_name'], $optionDImageNewName);
}
if (!empty($imgOptE)) {
  move_uploaded_file($_FILES['image_optionE']['tmp_name'], $optionEImageNewName);
}

// Bind the parameters
$stmt->bind_param("sssssssssssssi", $questionText, $optionA, $optionB, $optionC, $optionD, $optionE, $answer, $questionImageNewName, $optionAImageNewName, $optionBImageNewName, $optionCImageNewName, $optionDImageNewName, $optionEImageNewName, $questionId);

// Execute the query
if ($stmt->execute()) {
  // If the query is successful, return a success response
  $response = array(
    'status' => 'success',
    'question' => null
  );
} else {
  // If the query fails, return an error response
  $response = array(
    'status' => 'error',
    'message' => 'Failed to update question'
  );
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();

// Send the response back to the client as JSON
header('Content-Type: application/json');
echo json_encode($response);

