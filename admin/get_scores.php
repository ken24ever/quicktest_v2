<?php
// Set database connection variables
include("../connection.php");

// Check if the username is provided in the POST data
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Retrieve the user's details
    $sql = "SELECT id, name, username, email FROM users WHERE username = '$username'";
    $userResult = $conn->query($sql);

    // Retrieve the user's exam scores and dates
    $sql = "SELECT exams.title AS exam_title, users_exam.scores AS exam_scores, users_exam.updated_at AS exam_date
            FROM users_exam
            INNER JOIN exams ON users_exam.exam_id = exams.id
            INNER JOIN users ON users_exam.user_id = users.id
            WHERE users.username = '$username'";
    $scoresResult = $conn->query($sql);

    if ($userResult->num_rows > 0 && $scoresResult->num_rows > 0) {
        $userRow = $userResult->fetch_assoc();

        // Print the user's details
        echo '<h5>Candidate: ' . $userRow['name'] . '</h5>';
        echo '<table class="table">';
        echo '<thead><tr><th>Exam</th><th>Scores</th><th>Date Written</th></tr></thead>';
        echo '<tbody>';

        // Print the user's exam scores and dates
        while ($scoresRow = $scoresResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $scoresRow['exam_title'] . '</td>';
            echo '<td>' . $scoresRow['exam_scores'] . '</td>';
            echo '<td>' . $scoresRow['exam_date'] . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No scores found for the user.';
    }
} else {
    echo 'Invalid request.';
}

// Close the database connection
$conn->close();
?>
