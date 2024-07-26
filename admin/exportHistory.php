<?php
include('../connection.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$startDate = $endDate = '';

// Check if startDate and endDate are set in the GET data
if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    // Get start and end dates from the form
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    // Fetch users with "active" status set to zero within the specified date range
    $query = "SELECT u.id, u.name, u.email, u.username, u.gender, u.application, u.examName, u.userPassport, DATE(u.created_at) AS created_at, u.remaining_time, u.logged_in, u.active, ue.scores
        FROM users u
        LEFT JOIN users_exam ue ON u.id = ue.user_id
        WHERE u.active = 0
        AND DATE(u.created_at) >= '$startDate' AND DATE(u.created_at) <= '$endDate'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Create a new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers to the Excel file
        $headers = ['ID', 'Name', 'Email', 'Username', 'Gender', 'Application', 'Exam Name', 'User Passport', 'Created At', 'Remaining Time', 'Logged In', 'Active', 'Scores'];
        $sheet->fromArray([$headers], null, 'A1');

        // Add data to the Excel file
        $row = 2;
        while ($row_data = $result->fetch_assoc()) {
            $sheet->fromArray($row_data, null, 'A' . $row);
            $row++;
        }

        // Set the headers for Excel file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="recovery_users.xlsx"');
        header('Cache-Control: max-age=0');

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    } else {
        echo "No users found with 'active' status set to zero within the specified date range.";
    }
} else {
    echo "Start date and/or end date not provided.";
}

// Close database connection
$conn->close();
?>
