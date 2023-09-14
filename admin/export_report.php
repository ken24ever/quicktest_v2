<?php
include('../connection.php');
<<<<<<< HEAD

require_once 'vendor/autoload.php'; // Require the library for Excel generation
=======
require 'vendor/autoload.php';
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Retrieve the selected user IDs to export
$userIds = $_POST['userIds'];

// Prepare the SQL statement to fetch the selected users' details
$query = "SELECT u.id, u.name, u.username, u.email, GROUP_CONCAT(e.title) AS exam_names, ue.scores, ue.updated_at
          FROM users u
          LEFT JOIN users_exam ue ON u.id = ue.user_id
          LEFT JOIN exams e ON ue.exam_id = e.id
          WHERE u.id IN (" . implode(',', $userIds) . ") AND ue.status = 'completed'
          GROUP BY u.id";

$result = $conn->query($query);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row
$headerRow = ['ID', 'Name', 'Username', 'Email', 'Exam Names', 'Scores', 'Dates'];
$sheet->fromArray($headerRow, NULL, 'A1');

// Fetch and populate the data rows
$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
  $rowData = [
    $row['id'],
    $row['name'],
    $row['username'],
    $row['email'],
    $row['exam_names'],
    $row['scores'],
    $row['updated_at']
  ];
  $sheet->fromArray($rowData, NULL, 'A' . $rowIndex);
  $rowIndex++;
}

<<<<<<< HEAD
// Set the appropriate headers for the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="audit_tray.xlsx"');
header('Cache-Control: max-age=0');

// Save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
=======
// Create a new Xlsx writer and save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$filename = 'users_export.xlsx';
$writer->save($filename);

// Send the file to download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

$conn->close();
?>
