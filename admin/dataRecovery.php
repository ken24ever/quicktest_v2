<?php
// Include your database connection file
include('../connection.php');

// Fetch the search parameters
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$searchTerm = '%' . $_POST['searchTerm'] . '%'; // Add % for partial match

// Construct the SQL query for searching
$sql = "
    SELECT *
    FROM users_history
    WHERE
        DATE(created_at) BETWEEN ? AND ?
        AND (
            name LIKE ?
            OR username LIKE ?  -- Use LIKE for partial matches
        )
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $startDate, $endDate, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Prepare the response based on the query result
if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $response = ['success' => true, 'users' => $users];
} else {
    $response = ['success' => false, 'message' => 'No results found'];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection and perform other necessary cleanup
$conn->close();
?>
