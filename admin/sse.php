<?php
// Include your database connection
include('../connection.php'); // Update the path as needed

// Function to fetch new audit trail entries or data
function fetchNewAuditTrailEntries($lastTimestamp) {
    global $conn; // Assuming you have a database connection variable named $conn

    // Fetch new audit trail entries from the database
    $query = "SELECT * FROM audit_tray WHERE created_at > ? ORDER BY created_at ASC";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind parameter
    $stmt->bind_param("s", $lastTimestamp);

    // Execute the query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Fetch the results as an associative array
    $entries = $result->fetch_all(MYSQLI_ASSOC);

    // Return the fetched entries as an array
    return $entries;
}


 
// Set the appropriate headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');

// Initialize lastTimestamp as null initially
$lastTimestamp = null;

// Keep the connection open
while (true) {
    // Fetch new audit trail entries
    $data = fetchNewAuditTrailEntries($lastTimestamp);

    // If new entries are fetched, update lastTimestamp
    if (!empty($data)) {
        $lastTimestamp = $data[count($data) - 1]['created_at'];
    }

    // Send the data to the client
    echo "data: " . json_encode($data) . "\n\n";

    // Flush the output to send the data immediately
    ob_flush();
    flush();

    // Wait for a while before sending the next update
    sleep(6); // Adjust the time interval as needed
}
?>
