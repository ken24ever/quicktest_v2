<?php
include('../connection.php');
require 'vendor/autoload.php';

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

// Create a new Xlsx writer and save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$filename = 'users_export.xlsx';
$writer->save($filename);

// Send the file to download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

$conn->close();
?>
