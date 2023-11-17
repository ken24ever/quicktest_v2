<?php
// Set database connection variables
include("../connection.php");

// Get the filter and search parameters
$userFilter = $_POST['userFilter'];
$dateFilter = $_POST['dateFilter'];
$searchQuery = $_POST['searchQuery'];
$page = $_POST['page'];
$entriesPerPage = $_POST['entriesPerPage'];

// Calculate the LIMIT and OFFSET for pagination
$offset = ($page - 1) * $entriesPerPage;

// Prepare the SQL statement with filters and search query, including LIMIT and OFFSET
$sql = "SELECT * FROM audit_tray WHERE 1=1";
if (!empty($userFilter)) {
  $sql .= " AND user_name = '$userFilter'";
}
if (!empty($dateFilter)) {
  $sql .= " AND created_at LIKE '%$dateFilter%'";
}
if (!empty($searchQuery)) {
  $sql .= " AND description LIKE '%$searchQuery%'";
}
$sql .= " ORDER BY created_at DESC LIMIT $entriesPerPage OFFSET $offset";

// Fetch filtered audit trail entries
$result = $conn->query($sql);

if ($result) {
  $entries = array();
  while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
  }

  // Count total number of filtered entries
  $totalCount = $result->num_rows;

  // Calculate total number of pages
  $totalPages = ceil($totalCount / $entriesPerPage);

  // Send success response with the data and pagination info
  echo json_encode(['success' => true, 'data' => $entries, 'totalPages' => $totalPages]);
} else {
  // Send error response
  echo json_encode(['success' => false]);
}

// Close the database connection
$conn->close();
?>
