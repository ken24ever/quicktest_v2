<?php
session_start();
include("connection.php");
$userId = $_SESSION['id'];
$examID = $_GET["examID"];
$page = $_GET["page"];
$questionsPerPage = 1; // Adjust this value as needed

// Calculate the offset for pagination
$offset = ($page - 1) * $questionsPerPage;

// Retrieve the USERS_EXAM status for the given examID and userID
$statusSql = "SELECT status FROM users_exam WHERE exam_id = '$examID' AND user_id = '$userId'";
$statusResult = $conn->query($statusSql);
$status = $statusResult->fetch_assoc()['status'];

$questions = [];

if ($status != 'completed') {
    // Retrieve the questions for the given examID(id, question, option_a, option_b, option_c, option_d, option_e, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path)
    $sql = "SELECT *
            FROM questions
            WHERE exam_id = '$examID'
            ORDER BY ";
            
    if ($status == 'in_progress') {
        // Display attempted questions sequentially
        $sql .= "FIND_IN_SET(id, (SELECT GROUP_CONCAT(question_id ORDER BY id) FROM selected_options WHERE user_exam_id = '$userId')) DESC, ";
       //$sql .= "SELECT  question_id FROM selected_options WHERE user_exam_id = '$userId' ORDER BY question_id DESC ";

    }
    
    $sql .= "RAND()";

    $sql .= " LIMIT $offset, $questionsPerPage"; 

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch and store each question in the $questions array
        while ($row = $result->fetch_assoc()) {
            $question = [
                'id' => $row['id'],
                'question' => $row['question'],
                'answer' => $row['answer'],
                'options' => [
                    [
                        'option_id' => 'a',
                        'option_text' => $row['option_a'],
                        'option_image_path' => $row['option_a_image_path']
                    ],
                    [
                        'option_id' => 'b',
                        'option_text' => $row['option_b'],
                        'option_image_path' => $row['option_b_image_path']
                    ],
                    [
                        'option_id' => 'c',
                        'option_text' => $row['option_c'],
                        'option_image_path' => $row['option_c_image_path']
                    ],
                    [
                        'option_id' => 'd',
                        'option_text' => $row['option_d'],
                        'option_image_path' => $row['option_d_image_path']
                    ],
                    [
                        'option_id' => 'e',
                        'option_text' => $row['option_e'],
                        'option_image_path' => $row['option_e_image_path']
                    ]
                ],
                'image_ques' => $row['image_ques']
            ];

            $questions[] = $question;
        }
    }
}

// Calculate the total number of questions for the given examID
$sqlTotal = "SELECT COUNT(*) AS total FROM questions WHERE exam_id = '$examID'";
$resultTotal = $conn->query($sqlTotal);
$totalQuestions = $resultTotal->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalQuestions / $questionsPerPage);

// Close the database connection
$conn->close();

// Prepare the response data
$response = [
    'status' => 'success',
    'currentPage' => $page,
    'totalPages' => $totalPages,
];

// Add the questions array to the response if it is not empty
if (!empty($questions)) {
    $response['questions'] = $questions;
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
