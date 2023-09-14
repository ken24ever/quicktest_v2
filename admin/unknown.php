<?php
// Include the common database connection
include('../connection.php');

if ($_GET['action'] === 'ajax') {
    // AJAX request - Fetch and return paginated audit trail entries

    // Pagination settings
    $perPage = 500;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $perPage;

    if ($offset < 0) {
        $offset = 0;
    }

    // Fetch audit trail entries with pagination
    $query = "SELECT * FROM audit_tray ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
    $result = $conn->query($query);

    $entries = array();

    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }

    // Retrieve total number of entries
    $totalQuery = "SELECT COUNT(*) AS total FROM audit_tray";
    $totalResult = $conn->query($totalQuery);
    $totalRows = $totalResult->fetch_assoc();
    $totalEntries = $totalRows['total'];

    $totalPages = ceil($totalEntries / $perPage);

    // Prepare JSON response
    $response = array(
        'success' => true,
        'data' => $entries,
        'totalEntries' => $totalEntries,
        'totalPages' => $totalPages
    );

    header('Content-Type: application/json');
    echo json_encode($response);

    $conn->close();
} else if ($_GET['action'] === 'sse') {
    // SSE request - Send real-time audit trail updates

    function fetchNewAuditTrailEntries($lastProcessedId) {
        global $conn;
    
        echo "Fetching new audit trail entries. Last processed ID: $lastProcessedId\n"; // Debug line
    
        $query = "SELECT * FROM audit_tray WHERE id > ? ORDER BY id ASC";
    
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $lastProcessedId);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $entries = $result->fetch_all(MYSQLI_ASSOC);
    
        echo "Fetched entries count: " . count($entries) . "\n"; // Debug line
    
        return $entries;
    }

    // Set headers for SSE
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('Access-Control-Allow-Origin: *');

    // Initialize lastProcessedId as 0
    $lastProcessedId = 0;

    // SSE loop
    while (true) {
        echo "Before fetching new audit trail entries. Current lastProcessedId: $lastProcessedId\n"; // Debug line
        $data = fetchNewAuditTrailEntries($lastProcessedId);

        if (!empty($data)) {
            $lastProcessedId = end($data)['id'];
            echo "After fetching new audit trail entries. Updated lastProcessedId: $lastProcessedId\n"; // Debug line
        }

        echo "Sending SSE data. Data count: " . count($data) . "\n"; // Debug line
        echo "data: " . json_encode($data) . "\n\n";
        ob_flush();
        flush();

        sleep(6);
    }
}
?>
