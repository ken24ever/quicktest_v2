<?php
// Include the database connection
include('connection.php');

// Pagination settings
$entriesPerPage = isset($_GET['entriesPerPage']) ? (int)$_GET['entriesPerPage'] : 10; // Get the number of audit trail entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
$offset = ($page - 1) * $entriesPerPage; // Calculate the offset for SQL query

// Fetch audit trail entries with pagination
$query = "SELECT * FROM audit_tray ORDER BY created_at DESC LIMIT $entriesPerPage OFFSET $offset";
$result = $conn->query($query);

// Create an array to store the audit trail entries data
$entries = array();

// Loop through the result set and add each entry to the array
while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

// Retrieve the total number of audit trail entries
$totalQuery = "SELECT COUNT(*) AS total FROM audit_tray";
$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc();
$totalEntries = $totalRows['total'];

// Calculate the total number of pages
$totalPages = ceil($totalEntries / $entriesPerPage);

// Prepare the JSON response
$response = array(
    'success' => true,
    'data' => $entries,
    'totalEntries' => $totalEntries,
    'totalPages' => $totalPages
);

// Send the JSON response
header('Content-Type: application/json');

// Return the audit trail entries data as JSON
echo json_encode($response);

// Close the database connection
$conn->close();
?>

