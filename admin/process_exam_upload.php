<?php

 // Set database connection 
 include("../connection.php");
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Get the form data
$examTitle = $_POST['exam_title1'];
$examDescription = $_POST['exam_description1'];
$examDuration = $_POST['exam_duration1'];

// Check if the exam title already exists in the EXAMS table
$existingExamQuery = "SELECT id FROM exams WHERE title = '$examTitle'";
$existingExamResult = $conn->query($existingExamQuery);

if ($existingExamResult->num_rows > 0) {
  // Exam title exists, retrieve the existing exam ID
  $existingExamRow = $existingExamResult->fetch_assoc();
  $examId = $existingExamRow['id'];
} else {
  // Exam title does not exist, insert a new record into the EXAMS table
  $insertExamQuery = "INSERT INTO EXAMS (title, description, duration) VALUES ('$examTitle', '$examDescription', '$examDuration')";
  if ($conn->query($insertExamQuery) === true) {
    $examId = $conn->insert_id;
  } else {
    $response = array('success' => false, 'message' => 'Failed to insert exam data.');
    echo json_encode($response);
    exit;
  }
}

// Process the uploaded Excel file
$excelFile = $_FILES['batch_file']['tmp_name'];

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load($excelFile);
$worksheet = $spreadsheet->getActiveSheet();

// Prepare the SQL statement for inserting questions and options
$insertQuestionQuery = "INSERT INTO QUESTIONS (exam_id, question, option_a, option_b, option_c, option_d, option_e, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path, answer ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insertQuestionStmt = $conn->prepare($insertQuestionQuery);
$insertQuestionStmt->bind_param("isssssssssssss", $examId, $question, $optiona, $optionb, $optionc, $optiond, $optione, $image_ques, $option_a_image_path, $option_b_image_path,$option_c_image_path, $option_d_image_path,$option_e_image_path, $answer);


// Skip the first row (headers) and iterate over the remaining rows in the worksheet
$worksheetIterator = $worksheet->getRowIterator();
$worksheetIterator->next(); // Skip the first row

while ($worksheetIterator->valid()) {
  $row = $worksheetIterator->current();
  $rowData = [];

  foreach ($row->getCellIterator() as $cell) {
    $rowData[] = $cell->getValue();
  }
  $question = $rowData[0];
  $optiona = $rowData[1];
  $optionb = $rowData[2];
  $optionc = $rowData[3];
  $optiond = $rowData[4];
  $optione = $rowData[5];
  $image_ques = !empty($rowData[6]) ? $rowData[6] : null; 
  $option_a_image_path = !empty($rowData[7]) ? $rowData[7] : null;  // Check for empty or null value
  $option_b_image_path = !empty($rowData[8]) ? $rowData[8] : null;  // Check for empty or null value
  $option_c_image_path = !empty($rowData[9]) ? $rowData[9] : null;  // Check for empty or null value
  $option_d_image_path = !empty($rowData[10]) ? $rowData[10] : null;  // Check for empty or null value
  $option_e_image_path = !empty($rowData[11]) ? $rowData[11] : null;  // Check for empty or null value
  $answer = $rowData[12];


  $insertQuestionStmt->execute();
  $worksheetIterator->next();
}

$insertQuestionStmt->close();

$response = array('success' => true, 'message' => 'Exam data inserted successfully.');
echo json_encode($response);

$conn->close();
?>
