<?php
session_start();
include 'connection.php';

if (isset($_POST['examId'])) {
    $examId = $_POST['examId'];
    $userId = $_SESSION['id']; // Replace 'id' with the actual session variable that holds the user ID

    // Fetch exam details and scores from the database for a particular user
    $sql = "SELECT e.title AS exam_name, ue.scores
            FROM users_exam ue
            INNER JOIN exams e ON ue.exam_id = e.id
            WHERE e.id = $examId AND ue.user_id = $userId";

    $result = $conn->query($sql);

    $response = array();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['examName'] = $row['exam_name'];
        $response['scores'] = [$row['scores']];
    } else {
        // Fetch the exam name separately from the exams table
        $examNameSql = "SELECT title FROM exams WHERE id = $examId";
        $examNameResult = $conn->query($examNameSql);
        $examNameRow = $examNameResult->fetch_assoc();

        $response['examName'] = $examNameRow['title'];
        $response['scores'] = [];
    }
    
    // Select all questions with their options and answers from QUESTIONS table
    $questionsSql = "SELECT * FROM questions WHERE exam_id = ?";
    $stmt = $conn->prepare($questionsSql);
    $stmt->bind_param("i", $examId);
    $stmt->execute();
    $questionsResult = $stmt->get_result();
    $stmt->close();

    // Initialize variables
    $totalScore = 0;
    $skippedQuestions = 0;
    $incorrectQuestions = 0;
    $correctQuestions = 0;
    $totalQuestions = $questionsResult->num_rows; // Get the total number of questions

    // Iterate over the questions
    while ($questionRow = $questionsResult->fetch_assoc()) {
        $questionID = $questionRow['id'];
        $correctAnswer = intval($questionRow['answer']); // Convert the answer to integer

        // Get the selected option for the current question from SELECTED_OPTIONS table
        $selectedOptionSql = "SELECT selected_option FROM selected_options WHERE user_exam_id = ? AND question_id = ?";
        $stmt = $conn->prepare($selectedOptionSql);
        $stmt->bind_param("ii", $userId, $questionID);
        $stmt->execute();
        $selectedOptionResult = $stmt->get_result();
        $stmt->close();

        // Check if the question was skipped
        if ($selectedOptionResult->num_rows === 0) {
            $skippedQuestions++;
        } else {
            $selectedOptionRow = $selectedOptionResult->fetch_assoc();
            $selectedOptionInt = intval($selectedOptionRow['selected_option']);

            // Check if the selected option is correct
            if (strcasecmp($selectedOptionRow['selected_option'], $questionRow['answer']) === 0) {
                $totalScore += 1;
                $correctQuestions++;
            } else {
                $incorrectQuestions++;
            }
        }
    }

    // Get the number of attempted questions
    $attemptedQuestions = $correctQuestions + $incorrectQuestions + $skippedQuestions;

    // Update the response array with the attempted question categories
    $response['categories'] = array(
        'Correct' => $correctQuestions,
        'Incorrect' => $incorrectQuestions,
        'Skipped' => $skippedQuestions
    );

    echo json_encode($response);
}

$conn->close();
?>
