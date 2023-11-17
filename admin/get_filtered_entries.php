<?php
// Include the database connection
include('../connection.php');

// Pagination settings
$perPage = isset($_GET['entriesPerPage']) ? (int)$_GET['entriesPerPage'] : 10; // Number of audit trail entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number
$offset = ($page - 1) * $perPage; // Calculate the offset for SQL query

// Get the filter parameters
$userFilter = isset($_GET['userFilter']) ? $_GET['userFilter'] : '';
$dateFilter = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '';
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

// Build the SQL query with filters and pagination
$query = "SELECT * FROM audit_tray";

// Add filters based on userFilter, dateFilter, and searchQuery
if (!empty($userFilter)) {
  $query .= " WHERE user_name = '$userFilter'";
}
if (!empty($dateFilter)) {
  // Modify this based on your actual date column name and format
  $formattedDateFilter = date('Y-m-d', strtotime($dateFilter));
  $query .= " AND DATE(created_at) = '$formattedDateFilter'";
}


if (!empty($searchQuery)) {
  $query .= " AND (user_name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR action LIKE '%$searchQuery%')";
}

$query .= " ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";

// Fetch audit trail entries with filters and pagination
$result = $conn->query($query);

// Create an array to store the audit trail entries data
$entries = array();

// Loop through the result set and add each entry to the array
while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

// Retrieve the total number of audit trail entries with filters (for pagination)
$totalQuery = "SELECT COUNT(*) AS total FROM audit_tray";
if (!empty($userFilter)) {
  $totalQuery .= " WHERE user_name = '$userFilter'";
}
if (!empty($dateFilter)) {
  // Convert the input date to the expected format
  $formattedDateFilter = date('Y-m-d', strtotime($dateFilter));
  $totalQuery .= " AND DATE(created_at) = '$formattedDateFilter'";
}

if (!empty($searchQuery)) {
  $totalQuery .= " AND (user_name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR action LIKE '%$searchQuery%')";
}

$totalResult = $conn->query($totalQuery);
$totalRows = $totalResult->fetch_assoc();
$totalEntries = $totalRows['total'];

// Calculate the total number of pages
$totalPages = ceil($totalEntries / $perPage);

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
