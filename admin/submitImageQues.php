<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Set database connection variables
    include("../connection.php");

    // get form data
    $questionId = $_POST['question_id'];
    $questionText = $_POST['question_text'];
    $optionAText = $_POST['option_a_text'];
    $optionBText = $_POST['option_b_text'];
    $optionCText = $_POST['option_c_text'];
    $optionDText = $_POST['option_d_text'];
    $optionEText = $_POST['option_e_text'];

    // save images to server and get their paths
    $imagePath = '';
    $optionAImagePath = '';
    $optionBImagePath = '';
    $optionCImagePath = '';
    $optionDImagePath = '';
    $optionEImagePath = '';

    if(isset($_FILES['question_image']) && $_FILES['question_image']['error'] === UPLOAD_ERR_OK){
        $questionImageName = $_FILES['question_image']['name'];
        $questionImageTmpName = $_FILES['question_image']['tmp_name'];
        $questionImagePath = 'question_images/' . $questionImageName;
        move_uploaded_file($questionImageTmpName, $questionImagePath);
        $imagePath = $questionImagePath;
    }

    if(isset($_FILES['option_a_image']) && $_FILES['option_a_image']['error'] === UPLOAD_ERR_OK){
        $optionAImageName = $_FILES['option_a_image']['name'];
        $optionAImageTmpName = $_FILES['option_a_image']['tmp_name'];
        $optionAImagePath = 'option_a_images/' . $optionAImageName;
        move_uploaded_file($optionAImageTmpName, $optionAImagePath);
    }

    if(isset($_FILES['option_b_image']) && $_FILES['option_b_image']['error'] === UPLOAD_ERR_OK){
        $optionBImageName = $_FILES['option_b_image']['name'];
        $optionBImageTmpName = $_FILES['option_b_image']['tmp_name'];
        $optionBImagePath = 'option_b_images/' . $optionBImageName;
        move_uploaded_file($optionBImageTmpName, $optionBImagePath);
    }

    if(isset($_FILES['option_c_image']) && $_FILES['option_c_image']['error'] === UPLOAD_ERR_OK){
        $optionCImageName = $_FILES['option_c_image']['name'];
        $optionCImageTmpName = $_FILES['option_c_image']['tmp_name'];
        $optionCImagePath = 'option_c_images/' . $optionCImageName;
        move_uploaded_file($optionCImageTmpName, $optionCImagePath);
    }

    if(isset($_FILES['option_d_image']) && $_FILES['option_d_image']['error'] === UPLOAD_ERR_OK){
        $optionDImageName = $_FILES['option_d_image']['name'];
        $optionDImageTmpName = $_FILES['option_d_image']['tmp_name'];
        $optionDImagePath = 'option_d_images/' . $optionDImageName;
        move_uploaded_file($optionDImageTmpName, $optionDImagePath);
    }

    if(isset($_FILES['option_e_image']) && $_FILES['option_e_image']['error'] === UPLOAD_ERR_OK){
        $optionEImageName = $_FILES['option_e_image']['name'];
        $optionEImageTmpName = $_FILES['option_e_image']['tmp_name'];
        $optionEImagePath = 'option_e_images/' . $optionEImageName;
        move_uploaded_file($optionEImageTmpName, $optionEImagePath);
    }
    

        // prepare insert statement
$stmt = mysqli_prepare($conn, "INSERT INTO question_images (question_id, question_text, question_image, option_a_text, option_a_image, option_b_text, option_b_image, option_c_text, option_c_image, option_d_text, option_d_image, option_e_text, option_e_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                                // bind parameters
mysqli_stmt_bind_param($stmt, "issssssssssss", $questionId, $questionText, $imagePath, $optionAText, $optionAImagePath, $optionBText, $optionBImagePath, $optionCText, $optionCImagePath, $optionDText, $optionDImagePath, $optionEText, $optionEImagePath);

// execute statement
mysqli_stmt_execute($stmt);

// check if query was successful
if(mysqli_affected_rows($conn) > 0){
    echo "Data inserted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

// close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
}//end of if($_SERVER['REQUEST_METHOD'] == 'POST')

