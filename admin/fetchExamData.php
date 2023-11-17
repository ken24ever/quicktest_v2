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
        GROUP BY u.id, u.name, u.email, u.username, u.password, u.gender, u.application, u.userPassport";

    // Subquery to count in-progress statuses
    $inProgressQuery = "SELECT COUNT(*) AS in_progress_count
        FROM users_exam
        WHERE status = 'in_progress'";

    // Subquery to count completed statuses
    $completedQuery = "SELECT COUNT(*) AS completed_count
        FROM users_exam
        WHERE status = 'completed'";

    // Full query joining the main query with in-progress and completed count
    $fullQuery = "SELECT main.*, 
        COALESCE(inProg.in_progress_count, 0) AS in_progress_count,
        COALESCE(completed.completed_count, 0) AS completed_count
        FROM ($mainQuery) AS main
        LEFT JOIN ($inProgressQuery) AS inProg ON 1=1
        LEFT JOIN ($completedQuery) AS completed ON 1=1";

    $result = $conn->query($fullQuery);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert the exams JSON string to an array
            $row['exams'] = json_decode($row['exams'], true);
            $users[] = $row;
        }
    }

    // Calculate the total percentage of active users
    $totalUsers = count($users);
    $inProgressCount = $users[0]['in_progress_count'];
    $completedCount = $users[0]['completed_count'];
    $percentage = ($inProgressCount / max(1, $totalUsers)) * 100;

    return ['users' => $users, 'in_progress_count' => $inProgressCount, 'completed_count' => $completedCount, 'totalUsers' => $totalUsers, 'percentage' => $percentage];
}

// Fetch users' details without pagination
$usersDetails = getUsersDetails();

// Get the total number of users
$totalUsers = $usersDetails['totalUsers'];

// Return the users' details, in-progress count, completed count, and total count as JSON
header('Content-Type: application/json');
echo json_encode(['users' => $usersDetails['users'], 'inProgressCount' => $usersDetails['in_progress_count'], 'completedCount' => $usersDetails['completed_count'], 'totalUsers' => $totalUsers, 'percentage' => $usersDetails['percentage']]);
?>
