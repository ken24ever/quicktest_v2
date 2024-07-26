<?php
include("../connection.php");

function getUsersDetails() {
    global $conn;

    // Main query to fetch user details and count for in-progress status
    $mainQuery = "SELECT u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.examName, u.userPassport,
        (SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('title', e.title, 'status', ue.status)), ']') FROM exams e
        LEFT JOIN users_exam ue ON e.id = ue.exam_id
        WHERE ue.user_id = u.id) AS exams
        FROM users u
        LEFT JOIN users_exam ue ON u.id = ue.user_id
        LEFT JOIN exams e ON ue.exam_id = e.id
        WHERE u.active = 1 
        ";

    // Subquery to count in-progress statuses
    $inProgressQuery = "SELECT COUNT(*) AS in_progress_count
        FROM users_exam
        WHERE status = 'in_progress'";

// Subquery to count completed statuses
$completedQuery = "SELECT COUNT(*) AS completed_count
    FROM users_exam ue
    LEFT JOIN users u ON ue.user_id = u.id
    WHERE ue.status = 'completed' AND u.active = 1";

    // NEW: Subquery to count script executions within a time interval (e.g., last 5 minutes)
    $executionCountQuery = "SELECT COUNT(*) AS transaction_count
        FROM script_execution_log
        WHERE execution_time >= NOW()- INTERVAL 5 MINUTE";

        // Subquery to count users with active = 1
$countUsers = "SELECT COUNT(*) AS usersCount
FROM users 
WHERE  active = 1";

    // Full query joining the main query with in-progress, completed count, and execution count
                $fullQuery = "SELECT main.*, 
                COALESCE(inProg.in_progress_count, 0) AS in_progress_count,
                COALESCE(completed.completed_count, 0) AS completed_count,
                COALESCE(execCount.transaction_count, 0) AS transaction_count,
                COALESCE(countUsrs.usersCount, 0) AS usersCount
            FROM ($mainQuery) AS main
            LEFT JOIN ($inProgressQuery) AS inProg ON 1=1
            LEFT JOIN ($completedQuery) AS completed ON 1=1
            LEFT JOIN ($countUsers) AS countUsrs ON 1=1
            LEFT JOIN ($executionCountQuery) AS execCount ON 1=1";


    $result = $conn->query($fullQuery);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert the exams JSON string to an array
            $row['exams'] = json_decode($row['exams'], true);
            $users[] = $row;
        }

    // Calculate the total percentage of active users
    $totalUsers = $users[0]['usersCount'];
    $inProgressCount = $users[0]['in_progress_count'];
    $completedCount = $users[0]['completed_count'];
    $transactionCount = $users[0]['transaction_count']; 

}else{
    $totalUsers = 0;
    $inProgressCount = 0;
    $completedCount = 0;
    $transactionCount = 0; // NEW: Add transaction count
}

// NEW: Add transaction count
$percentage = ($inProgressCount / max(1, $totalUsers)) * 100;
    // Threshold and Peak Level Logic
    $normalThreshold = 80;
    $cautionaryThreshold = 100;
    //$criticalThreshold = 6;

    if ($transactionCount <= $normalThreshold) {
        // Within normal threshold, no action needed
        $thresholdStatus = 'Normal';
    } elseif ($transactionCount <= $cautionaryThreshold) {
        // Cautionary range, may require attention
        // Implement actions or notifications as needed
        $thresholdStatus = 'Cautionary';
    } else {
        // Critical range, potential concerns
        // Implement actions or alerts, e.g., notify administrators
        $thresholdStatus = 'Critical';
    }

    return ['users' => $users, 'in_progress_count' => $inProgressCount, 'completed_count' => $completedCount, 'transaction_count' => $transactionCount, 'totalUsers' => $totalUsers, 'percentage' => $percentage, 'threshold_status' => $thresholdStatus];
}

// Fetch users' details without pagination
$usersDetails = getUsersDetails();

// Get the total number of users
$totalUsers = $usersDetails['totalUsers'];

// Return the users' details, in-progress count, completed count, transaction count, total count, percentage, and threshold status as JSON
header('Content-Type: application/json');
echo json_encode(['users' => $usersDetails['users'], 'inProgressCount' => $usersDetails['in_progress_count'], 'completedCount' => $usersDetails['completed_count'], 'transactionCount' => $usersDetails['transaction_count'], 'totalUsers' => $totalUsers, 'percentage' => $usersDetails['percentage'], 'thresholdStatus' => $usersDetails['threshold_status']]);
?>
