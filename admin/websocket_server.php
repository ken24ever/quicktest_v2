<?php
// Create a socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Check if the socket was created successfully
if ($socket === false) {
    echo "Failed to create socket: " . socket_strerror(socket_last_error()) . "\n";
} else {
    // Connect to WebSocket server (replace 'localhost' and '8080' with actual server details)
    if (socket_connect($socket, 'localhost', 8080) === false) {
        echo "Failed to connect to server: " . socket_strerror(socket_last_error($socket)) . "\n";
    } else {
        // Include the database connection (assuming you're using the same connection as the other script)
        include('../connection.php');

        // Fetch audit trail entries with pagination
        $query = "SELECT * FROM audit_tray ORDER BY created_at DESC";
        $result = $conn->query($query);

        // Loop through the result set and send each entry as a WebSocket message
        while ($row = $result->fetch_assoc()) {
            $dataToSend = json_encode($row); // Convert the entry to JSON format

            // Write data to the socket
            if (socket_write($socket, $dataToSend, strlen($dataToSend)) === false) {
                echo "Failed to write to server: " . socket_strerror(socket_last_error($socket)) . "\n";
            } else {
                echo "WebSocket message sent successfully.\n";
            }
            
            // Add a delay between sending messages (if needed)
            usleep(1000000); // Sleep for 1 second
        }

        // Close the database connection
        $conn->close();
    }

    // Close the socket
    socket_close($socket);
}
?>
