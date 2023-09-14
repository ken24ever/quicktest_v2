<?php
// Include the database connection
include('../connection.php');

// Get the filter values from the request
$userFilter = isset($_GET['userFilter']) ? $_GET['userFilter'] : '';
$dateFilter = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '';
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

// Prepare the SQL query based on the filter values
$query = "SELECT COUNT(*) AS total FROM audit_tray WHERE 1";

if ($userFilter !== '') {
  $query .= " AND user_name = '$userFilter'";
}

if ($dateFilter !== '') {
  $query .= " AND created_at >= '$dateFilter 00:00:00' AND created_at <= '$dateFilter 23:59:59'";
}

if ($searchQuery !== '') {
  $query .= " AND (user_name LIKE '%$searchQuery%' OR action LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR created_at LIKE '%$searchQuery%')";
}

// Execute the SQL query
$result = $conn->query($query);

// Get the total number of filtered entries
$totalRows = $result->fetch_assoc();
$totalEntries = $totalRows['total'];

// Calculate the total number of pages
$entriesPerPage = 10; // Set the number of entries per page here
$totalPages = ceil($totalEntries / $entriesPerPage);

// Prepare the JSON response
$response = array(
  'success' => true,
  'totalPages' => $totalPages
);

// Send the JSON response
header('Content-Type: application/json');

// Return the response as JSON
echo json_encode($response);

// Close the database connection
$conn->close();
?>
