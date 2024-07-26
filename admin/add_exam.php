<?php
session_start();
include("../connection.php");

error_reporting(E_ALL);
ini_set('display_errors', 0);

function sanitizeInput($conn, $input) {
    return mysqli_real_escape_string($conn, $input);
}

function moveUploadedFile($tmpName, $destination) {
    return move_uploaded_file($tmpName, $destination);
}

function generateUniqueFileName($prefix, $extension) {
    return !empty($extension) ? uniqid($prefix, true) . '.' . $extension : null;
}

function insertQuestion($conn, $examId, $question, $options, $images, $combinedAnswers, $i) {
    $sql = "INSERT INTO questions (exam_id, question, option_a, option_b, option_c, option_d, option_e, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path, answer) 
            VALUES ('$examId', '$question', '$options[0]', '$options[1]', '$options[2]', '$options[3]', '$options[4]', '$images[0]', '$images[1]', '$images[2]', '$images[3]', '$images[4]', '$images[5]', '$combinedAnswers')";
    
    if (mysqli_query($conn, $sql)) {
        return "Question $i has been added successfully!";
    } else {
        return "Error: " . mysqli_error($conn) . "<br>";
    }
}

$fullNames = sanitizeInput($conn, $_SESSION['user_name']);
$userID = sanitizeInput($conn, $_SESSION['user_id']);

$display = '';

if (isset($_POST['exam_title'], $_POST['exam_description'], $_POST['exam_duration'], $_POST['question_count'])) {
    $examTitle = sanitizeInput($conn, $_POST['exam_title']);
    $description = sanitizeInput($conn, $_POST['exam_description']);
    $duration = sanitizeInput($conn, $_POST['exam_duration']);
    $questionCount = $_POST['question_count'];

    $sql = "SELECT * FROM exams WHERE title = '$examTitle'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Exam title exists
        $row = mysqli_fetch_assoc($result);
        $examId = $row['id'];
        $title = $row['title'];

        for ($i = 1; $i <= $questionCount; $i++) {
            $correctAnswersJSON = isset($_POST['correctAnswers']) ? $_POST['correctAnswers'] : '';
            $correctAnswers = json_decode($correctAnswersJSON, true);
            $combinedAnswers = implode(',', $correctAnswers[$i]);

            $questionText = sanitizeInput($conn, $_POST['question' . $i]);
            $option_a = sanitizeInput($conn, $_POST['option_a' . $i]);
            $option_b = sanitizeInput($conn, $_POST['option_b' . $i]);
            $option_c = sanitizeInput($conn, $_POST['option_c' . $i]);
            $option_d = sanitizeInput($conn, $_POST['option_d' . $i]);
            $option_e = sanitizeInput($conn, $_POST['option_e' . $i]);

            $questionImageName = isset($_FILES["question_image_" . $i]['name']) ? basename($_FILES["question_image_" . $i]['name']) : "";
            $questionImageTmpName = isset($_FILES["question_image_" . $i]['tmp_name']) ? $_FILES["question_image_" . $i]['tmp_name'] : "";
            $questionImageExtension = isset($questionImageName) ? pathinfo($questionImageName, PATHINFO_EXTENSION) : "";

            $optionAImageName = isset($_FILES["option_a_image_" . $i]['name']) ? basename($_FILES["option_a_image_" . $i]['name']) : "";
            $optionAImageTmpName = isset($_FILES["option_a_image_" . $i]['tmp_name']) ? $_FILES["option_a_image_" . $i]['tmp_name'] : "";
            $optionAImageExtension = isset($optionAImageName) ? pathinfo($optionAImageName, PATHINFO_EXTENSION) : "";


            // Check if an image has been uploaded for option B
            $optionBImageName = isset($_FILES["option_b_image_".$i]['name']) ? basename($_FILES["option_b_image_".$i]['name']) : "";
            $optionBImageTmpName = isset($_FILES["option_b_image_".$i]['tmp_name']) ? $_FILES["option_b_image_".$i]['tmp_name'] : "";
            $optionBImageExtension = isset($optionBImageName) ? pathinfo($optionBImageName, PATHINFO_EXTENSION) : "";

            // Check if an image has been uploaded for option C
            $optionCImageName = isset($_FILES["option_c_image_".$i]['name']) ? basename($_FILES["option_c_image_".$i]['name']) : "";
            $optionCImageTmpName = isset($_FILES["option_c_image_".$i]['tmp_name']) ? $_FILES["option_c_image_".$i]['tmp_name'] : "";
            $optionCImageExtension = isset($optionCImageName) ? pathinfo($optionCImageName, PATHINFO_EXTENSION) : "";

            // Check if an image has been uploaded for option D
            $optionDImageName = isset($_FILES["option_d_image_".$i]['name']) ? basename($_FILES["option_d_image_".$i]['name']) : "";
            $optionDImageTmpName = isset($_FILES["option_d_image_".$i]['tmp_name']) ? $_FILES["option_d_image_".$i]['tmp_name'] : "";
            $optionDImageExtension = isset($optionDImageName) ? pathinfo($optionDImageName, PATHINFO_EXTENSION) : "";

            // Check if an image has been uploaded for option E
            $optionEImageName = isset($_FILES["option_e_image_".$i]['name']) ? basename($_FILES["option_e_image_".$i]['name']) : "";
            $optionEImageTmpName = isset($_FILES["option_e_image_".$i]['tmp_name']) ? $_FILES["option_e_image_".$i]['tmp_name'] : "";
            $optionEImageExtension = isset($optionEImageName) ? pathinfo($optionEImageName, PATHINFO_EXTENSION) : "";


            $questionImageNewName = generateUniqueFileName('qimg_', $questionImageExtension);
            $questionOptionAImg = generateUniqueFileName('optionA_' . $i, $optionAImageExtension);

            if (!empty($questionImageName) || !empty($optionAImageName) || !empty($optionBImageName) ||
                !empty($optionCImageName) || !empty($optionDImageName) || !empty($optionEImageName)) {

                $questionImageDestination = !empty($questionImageNewName) ? "uploads/" . $questionImageNewName : "";
                $optionAImgDest = !empty($questionOptionAImg) ? "uploads/" . $questionOptionAImg : "";

                moveUploadedFile($questionImageTmpName, $questionImageDestination);
                moveUploadedFile($optionAImageTmpName, $optionAImgDest);
            }

            $display .= insertQuestion($conn, $examId, $questionText, [$option_a, $option_b, $option_c, $option_d, $option_e], [$questionImageDestination, $optionAImgDest], $combinedAnswers, $i);
        }

        $action = 'More Questions Added';
        $description = 'Logged in admin user: (' . $fullNames . ') added these numbers ("' . $questionCount . '") of questions to exam title: "' . $examTitle . '"';

        $sqlAudit = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES ('$fullNames', '$userID', '$description', '$action')";
        $returnRes = mysqli_query($conn, $sqlAudit);

        $display .= "More questions added successfully to Exam title: " . $title . "<br>";

    } else {
        // Exam title does not exist, insert the exam into the exams table
        $sql1 = "INSERT INTO exams (title, description, duration) VALUES ('$examTitle', '$description', '$duration')";
        if (mysqli_query($conn, $sql1)) {
            $examId = mysqli_insert_id($conn);

                                    // ... existing code ...

                            for ($i = 1; $i <= $questionCount; $i++) {
                                // Get the correct answers for each question
                                $correctAnswersJSON = isset($_POST['correctAnswers']) ? $_POST['correctAnswers'] : '';
                                $correctAnswers = json_decode($correctAnswersJSON, true);

                                // Combine the answers into a single string (e.g., ['A', 'D', 'E'] becomes 'ADE')
                                $combinedAnswers = implode(',', $correctAnswers[$i]);

                                // Get the question text and other options
                                $questionText = sanitizeInput($conn, $_POST['question' . $i]);
                                $option_a = sanitizeInput($conn, $_POST['option_a' . $i]);
                                $option_b = sanitizeInput($conn, $_POST['option_b' . $i]);
                                $option_c = sanitizeInput($conn, $_POST['option_c' . $i]);
                                $option_d = sanitizeInput($conn, $_POST['option_d' . $i]);
                                $option_e = sanitizeInput($conn, $_POST['option_e' . $i]);

                                // Check if an image has been uploaded for question
                                $questionImageName = isset($_FILES["question_image_" . $i]['name']) ? basename($_FILES["question_image_" . $i]['name']) : "";
                                $questionImageTmpName = isset($_FILES["question_image_" . $i]['tmp_name']) ? $_FILES["question_image_" . $i]['tmp_name'] : "";
                                $questionImageExtension = isset($questionImageName) ? pathinfo($questionImageName, PATHINFO_EXTENSION) : "";

                                // Check if an image has been uploaded for option A
                                $optionAImageName = isset($_FILES["option_a_image_" . $i]['name']) ? basename($_FILES["option_a_image_" . $i]['name']) : "";
                                $optionAImageTmpName = isset($_FILES["option_a_image_" . $i]['tmp_name']) ? $_FILES["option_a_image_" . $i]['tmp_name'] : "";
                                $optionAImageExtension = isset($optionAImageName) ? pathinfo($optionAImageName, PATHINFO_EXTENSION) : "";

                                // Check if an image has been uploaded for option B
                                $optionBImageName = isset($_FILES["option_b_image_".$i]['name']) ? basename($_FILES["option_b_image_".$i]['name']) : "";
                                $optionBImageTmpName = isset($_FILES["option_b_image_".$i]['tmp_name']) ? $_FILES["option_b_image_".$i]['tmp_name'] : "";
                                $optionBImageExtension = isset($optionBImageName) ? pathinfo($optionBImageName, PATHINFO_EXTENSION) : "";

                                // Check if an image has been uploaded for option C
                                $optionCImageName = isset($_FILES["option_c_image_".$i]['name']) ? basename($_FILES["option_c_image_".$i]['name']) : "";
                                $optionCImageTmpName = isset($_FILES["option_c_image_".$i]['tmp_name']) ? $_FILES["option_c_image_".$i]['tmp_name'] : "";
                                $optionCImageExtension = isset($optionCImageName) ? pathinfo($optionCImageName, PATHINFO_EXTENSION) : "";

                                // Check if an image has been uploaded for option D
                                $optionDImageName = isset($_FILES["option_d_image_".$i]['name']) ? basename($_FILES["option_d_image_".$i]['name']) : "";
                                $optionDImageTmpName = isset($_FILES["option_d_image_".$i]['tmp_name']) ? $_FILES["option_d_image_".$i]['tmp_name'] : "";
                                $optionDImageExtension = isset($optionDImageName) ? pathinfo($optionDImageName, PATHINFO_EXTENSION) : "";

                                // Check if an image has been uploaded for option E
                                $optionEImageName = isset($_FILES["option_e_image_".$i]['name']) ? basename($_FILES["option_e_image_".$i]['name']) : "";
                                $optionEImageTmpName = isset($_FILES["option_e_image_".$i]['tmp_name']) ? $_FILES["option_e_image_".$i]['tmp_name'] : "";
                                $optionEImageExtension = isset($optionEImageName) ? pathinfo($optionEImageName, PATHINFO_EXTENSION) : "";


                                $questionImageNewName = generateUniqueFileName('qimg_', $questionImageExtension);
                                $questionOptionAImg = generateUniqueFileName('optionA_' . $i, $optionAImageExtension);

                                if (!empty($questionImageName) || !empty($optionAImageName) || !empty($optionBImageName) ||
                                    !empty($optionCImageName) || !empty($optionDImageName) || !empty($optionEImageName)) {

                                    $questionImageDestination = !empty($questionImageNewName) ? "uploads/" . $questionImageNewName : "";
                                    $optionAImgDest = !empty($questionOptionAImg) ? "uploads/" . $questionOptionAImg : "";

                                    moveUploadedFile($questionImageTmpName, $questionImageDestination);
                                    moveUploadedFile($optionAImageTmpName, $optionAImgDest);
                                    move_uploaded_file($optionBImageTmpName, $optionBImgDest);
                                    move_uploaded_file($optionCImageTmpName, $optionCImgDest);
                                    move_uploaded_file($optionDImageTmpName, $optionDImgDest);
                                    move_uploaded_file($optionEImageTmpName, $optionEImgDest);
                                }

                                $display .= insertQuestion($conn, $examId, $questionText, [$option_a, $option_b, $option_c, $option_d, $option_e], [$questionImageDestination, $optionAImgDest], $combinedAnswers, $i);
                            }


            $display .= "Exam title and its questions added successfully";
        } else {
            $display .= "Error: " . mysqli_error($conn);
        }
    }
} else {
    $display .= "Error: Please provide exam details";
}

mysqli_close($conn);
echo $display;

