<?php
include('../connection.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//var_dump($_POST['selectedEntries']);
try {
    // Retrieve the selected entry IDs to export
    $selectedEntries = $_POST['selectedEntries'];

    // Prepare the SQL statement to fetch the selected entries' details
    $placeholders = implode(',', array_fill(0, count($selectedEntries), '?'));
    $query = "SELECT * FROM audit_tray WHERE id IN ($placeholders)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($selectedEntries)), ...$selectedEntries);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->get_result();

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the header row
    $headerRow = ['ID', 'User Name', 'Description', 'Action', 'Created At'];
    $sheet->fromArray($headerRow, NULL, 'A1');

    // Fetch and populate the data rows
    $rowIndex = 2;
    while ($row = $result->fetch_assoc()) {
        $rowData = [
            $row['id'],
            $row['user_name'],
            $row['description'],
            $row['action'],
            $row['created_at']
        ];
        $sheet->fromArray($rowData, NULL, 'A' . $rowIndex);
        $rowIndex++;
    }

   

// Create a new Xlsx writer and save the spreadsheet to a file
$writer = new Xlsx($spreadsheet);
$filename = 'audit_trail_export.xlsx'; // Specify the filename
$savePath = 'C:/xampp/htdocs/cbt_exam/admin/audit_tray/'; // Specify the absolute path to the directory
$fullPath = $savePath . $filename; // Combine path and filename

// Close any existing file handles before saving
$writer->getDiskCachingDirectory(true);

$writer->save($fullPath);

// Set content type and headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($fullPath)); // Set the content length

// Clear any output that has been buffered and not sent
while (ob_get_level()) {
    ob_end_clean();
}

// Read and send the file contents
readfile($fullPath);

// Exit to prevent any further output
exit;



    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Handle the exception
    echo 'Error: ' . $e->getMessage();
}
?>
