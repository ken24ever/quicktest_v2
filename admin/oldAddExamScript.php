<?php
// Set database connection variables
include("../connection.php");

if(isset($_POST['exam_title']) && isset($_POST['exam_description']) && isset($_POST['exam_duration']) && isset($_POST['question_count'])) {
   
    $title = $_POST['exam_title'];
    $description = mysqli_real_escape_string($conn,$_POST['exam_description']);
    $duration = $_POST['exam_duration'];
    $questionCount = $_POST['question_count'];

    // Check if exam title already exists in database
    $titleCheckQuery = "SELECT * FROM exams WHERE title = '$title'";
    $titleCheckResult = mysqli_query($conn, $titleCheckQuery);
    if(mysqli_num_rows($titleCheckResult) > 0) {
        // Exam title already exists, trigger error message
        echo "Error: Exam title already exists!";
    } else {
        // Exam title does not exist, insert new exam and questions into the database
        $examInsertQuery = "INSERT INTO exams (title, description, duration) VALUES ('$title', '$description', '$duration')";

        if(mysqli_query($conn, $examInsertQuery)) {

            $examId = mysqli_insert_id($conn) ;

               // Loop through all questions submitted in POST request
        for($i = 1; $i <= $_POST['question_count']; $i++){
            $question = $_POST['question'.$i];
            $option_a = mysqli_real_escape_string($conn,$_POST['option_a'.$i]);
            $option_b = mysqli_real_escape_string($conn,$_POST['option_b'.$i]);
            $option_c = mysqli_real_escape_string($conn,$_POST['option_c'.$i]);
            $option_d = mysqli_real_escape_string($conn,$_POST['option_d'.$i]);
            $option_e = mysqli_real_escape_string($conn,$_POST['option_e'.$i]);// added new option
            $answer = mysqli_real_escape_string($conn, $_POST['correct'.$i]);

            // Insert question details into questions table
            $insert_question_query = "INSERT INTO questions (exam_id, question, option_a, option_b, option_c, option_d, option_e, answer) VALUES ('$examId', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$answer')";
            mysqli_query($conn, $insert_question_query);
        }

            echo "Exam and questions added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: Invalid Request!";
}

mysqli_close($conn);


?>