<?php
<<<<<<< HEAD
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
include("../connection.php");
require_once 'vendor/autoload.php'; // Require the library for Excel generation

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the exam ID from the request
$examID = $_POST['examID'];

<<<<<<< HEAD
    //get exam title
    $exam_Title = $_POST['exam_Title'];

    $action = 'Exam Questions Downloaded'; 
    $description = 'Logged in admin user: (' . $fullNames . ') downloaded exam questions with title: "' . $exam_Title . '"';

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
=======
/* $sqlForExamTitle = "SELECT title FROM exams WHERE id = '$examID'";
$results = mysqli_query($conn, $sqlForExamTitle);
$row = mysqli_fetch_assoc($results);
$examTitle = $row['title']; */
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

// Select the questions for the specified exam ID from the QUESTIONS table
$questionsSql = "SELECT * FROM questions WHERE exam_id = ?";
$stmt = $conn->prepare($questionsSql);
$stmt->bind_param("i", $examID);
$stmt->execute();
$questionsResult = $stmt->get_result(); 
$stmt->close();

// Create a new spreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$sheet->setCellValue('A1', 'Question');
$sheet->setCellValue('B1', 'Option A');
$sheet->setCellValue('C1', 'Option B');
$sheet->setCellValue('D1', 'Option C');
$sheet->setCellValue('E1', 'Option D');
$sheet->setCellValue('F1', 'Option E');
$sheet->setCellValue('G1', 'Image Question');
$sheet->setCellValue('H1', 'Option A Image Path');
$sheet->setCellValue('I1', 'Option B Image Path');
$sheet->setCellValue('J1', 'Option C Image Path');
$sheet->setCellValue('K1', 'Option D Image Path');
$sheet->setCellValue('L1', 'Option E Image Path');
$sheet->setCellValue('M1', 'Answer');
// Fetch and write the questions and their details to the spreadsheet
$row = 2; // Starting row for data
while ($questionRow = $questionsResult->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $questionRow['question']);
    $sheet->setCellValue('B' . $row, $questionRow['option_a']);
    $sheet->setCellValue('C' . $row, $questionRow['option_b']);
    $sheet->setCellValue('D' . $row, $questionRow['option_c']);
    $sheet->setCellValue('E' . $row, $questionRow['option_d']);
    $sheet->setCellValue('F' . $row, $questionRow['option_e']);
    $sheet->setCellValue('G' . $row, $questionRow['image_ques']);
    $sheet->setCellValue('H' . $row, $questionRow['option_a_image_path']);
    $sheet->setCellValue('I' . $row, $questionRow['option_b_image_path']);
    $sheet->setCellValue('J' . $row, $questionRow['option_c_image_path']);
    $sheet->setCellValue('K' . $row, $questionRow['option_d_image_path']);
    $sheet->setCellValue('L' . $row, $questionRow['option_e_image_path']);
    $sheet->setCellValue('M' . $row, $questionRow['answer']);
    $row++;
}

// Set the appropriate headers for the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="questions.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Close the database connection
$conn->close();
?>
