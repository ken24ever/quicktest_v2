<?php
// Set database connection variables
include("../connection.php");

// Check if the search form has been submitted
if (isset($_POST["searchUsername"])) {
    // Retrieve the search query
    $searchUsername = $_POST["searchUsername"];

    // Construct the SQL query to retrieve matching users
    $sql = "SELECT * FROM users WHERE name LIKE '%$searchUsername%' OR username LIKE '%$searchUsername%' OR password LIKE '%$searchUsername%' ";

    // Execute the query
    $result = $conn->query($sql);

    // Display the search results in a table
    if ($result->num_rows > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>ID</th><th>Name</th><th>Username</th><th>Email</th><th>Password</th><th>Exam Name</th><th>Exam Scores</th><th>Action</th></tr></thead>";
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $name = $row["name"];
            $username = $row['username'];
            $email = $row['email'];
            $password = $row['password']; 
            $examName = $row['examName'];

            // Retrieve the user's exam scores from USERS_EXAM table
            $query = "SELECT exam_id, scores, updated_at FROM users_exam WHERE user_id = '$id'";
            $examResult = mysqli_query($conn, $query);

            $scores = "N/A";
            $viewScoresButton = "";

            if (mysqli_num_rows($examResult) > 0) {
                $scoresTable = "<table class='table'>";
                $scoresTable .= "<thead><tr><th>Exam Name</th><th>Score</th><th>Date</th></tr></thead>";
                $scoresTable .= "<tbody>";

                while ($examRow = mysqli_fetch_assoc($examResult)) {
                    $examID = $examRow['exam_id'];
                    $examScore = $examRow['scores'];
                    $examDate = $examRow['updated_at'];

                    // Retrieve the exam name from the "exams" table based on the exam ID
                    $examQuery = "SELECT title, duration FROM exams WHERE id = '$examID'";
                    $examNameResult = mysqli_query($conn, $examQuery);
                    $examNameRow = mysqli_fetch_assoc($examNameResult);
                    $examTitle = $examNameRow['title'];
                    $examDuration = $examNameRow['duration'];

                    $scoresTable .= "<tr>";
                    $scoresTable .= "<td>$examTitle</td>";
                    $scoresTable .= "<td>$examScore</td>";
                    $scoresTable .= "<td>$examDate</td>";
                    $scoresTable .= "</tr>";
                }

                $scoresTable .= "</tbody>";
                $scoresTable .= "</table>";

                $scores = $scoresTable;

                // Create a button to view more scores for each exam
                $viewScoresButton = "<button class='btn btn-info view-scores-button' data-toggle='modal' data-target='#scores-modal' data-username='$username'>View Scores</button>";
            }

            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $username . "</td>";
            echo "<td>" . $email . "</td>";
            echo "<td>" . $password . "</td>";
            echo "<td>" . $examName . "</td>";
            echo "<td>$scores</td>";
            echo "<td>
                    <div class='btn-group'>
                        <button class='btn btn-primary edit-button' data-toggle='modal' data-target='#edit-modal' data-id='" . $id . "' data-name='" . $name . "' data-username='" . $username . "' data-email='" . $email . "' data-password='" . $password . "' data-exam-name='" . $examName . "'>Edit</button>
                        <button class='btn btn-danger delete-button' id='" . $username . "'>Delete</button>
                        $viewScoresButton
                        <button class='btn btn-default reset bg-dark text-white' id='" . $username . "'>Reset</button>
                        <button class='btn btn-primary print-button' data-username='" . $username . "'>Print</button>
                    </div>
                </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No matching users found.";
    }
}

// Close the database connection
$conn->close();
?>
