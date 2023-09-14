<?php 
<<<<<<< HEAD
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

// Set database connection variables
include("../connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Variable to handle error messages and success messages
$description = $action = $questionImageDestination = $optionAImgDest = $optionBImgDest = $optionCImgDest = $optionDImgDest = $optionEImgDest = $display = '';
=======
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Set database connection variables
include("../connection.php");

// Define the maximum file size for the images (2MB)
$maxFileSize = 2 * 1024 * 1024;

// Variable to handle error messages and success messages
$questionImageDestination = $optionAImgDest = $optionBImgDest = $optionCImgDest = $optionDImgDest = $optionEImgDest = $display = '';
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

if(isset($_POST['exam_title']) && isset($_POST['exam_description']) && isset($_POST['exam_duration']) || isset($_POST['question_count']))
{
    // Get the exam title and other information
    $examTitle = $_POST['exam_title'];
    $description = mysqli_real_escape_string($conn, $_POST['exam_description']);
    $duration = $_POST['exam_duration'];
    $questionCount = $_POST['question_count'];

    // Check if the exam title already exists
    $sql = "SELECT * FROM exams WHERE title = '$examTitle'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0 ) 
    {
        // The exam title exists, get its ID
        $row = mysqli_fetch_assoc($result);
        $examId = $row['id'];
        $title = $row['title'];
        for($i = 1; $i <= $questionCount; $i++) 
{
<<<<<<< HEAD
   // Get the correct answers for each question
   $correctAnswersJSON = isset($_POST['correctAnswers']) ? $_POST['correctAnswers'] : '';
   $correctAnswers = json_decode($correctAnswersJSON, true);

   // Combine the answers into a single string (e.g., ['A', 'D', 'E'] becomes 'ADE')
   $combinedAnswers = implode(',', $correctAnswers[$i]);

             
  // Get the question text and other options
  $questionText = mysqli_real_escape_string($conn, $_POST['question'.$i]);
  $option_a = mysqli_real_escape_string($conn, $_POST['option_a'.$i]);
  $option_b = mysqli_real_escape_string($conn, $_POST['option_b'.$i]);
  $option_c = mysqli_real_escape_string($conn, $_POST['option_c'.$i]);
  $option_d = mysqli_real_escape_string($conn, $_POST['option_d'.$i]);
  $option_e = mysqli_real_escape_string($conn, $_POST['option_e'.$i]); // Added new option
=======
    // Get the question text
    $questionText = mysqli_real_escape_string($conn,$_POST['question'.$i]);
    $option_a = mysqli_real_escape_string($conn, $_POST['option_a'.$i]);
    $option_b = mysqli_real_escape_string($conn, $_POST['option_b'.$i]);
    $option_c = mysqli_real_escape_string($conn, $_POST['option_c'.$i]);
    $option_d = mysqli_real_escape_string($conn, $_POST['option_d'.$i]);
    $option_e = mysqli_real_escape_string($conn, $_POST['option_e'.$i]); // Added new option
    $answer = mysqli_real_escape_string($conn, $_POST['correct'.$i]);

    // Check if a question image and options image has been uploaded
 
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

       // Check if an image has been uploaded for question
$questionImageName = isset($_FILES["question_image_".$i]['name']) ? basename($_FILES["question_image_".$i]['name']) : "";
$questionImageTmpName = isset($_FILES["question_image_".$i]['tmp_name']) ? $_FILES["question_image_".$i]['tmp_name'] : "";
$questionImageExtension = isset($questionImageName) ? pathinfo($questionImageName, PATHINFO_EXTENSION) : "";

// Check if an image has been uploaded for option A
$optionAImageName = isset($_FILES["option_a_image_".$i]['name']) ? basename($_FILES["option_a_image_".$i]['name']) : "";
$optionAImageTmpName = isset($_FILES["option_a_image_".$i]['tmp_name']) ? $_FILES["option_a_image_".$i]['tmp_name'] : "";
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

// The image file is valid, move it to the upload directory
$questionImageNewName = !empty($questionImageName) ? uniqid('qimg_', true) . '.' . $questionImageExtension : null;
$questionOptionAImg = !empty($optionAImageName) ? uniqid('optionA_'.$i, true) . '.' . $optionAImageExtension : null;
$questionOptionBImg = !empty($optionBImageName) ? uniqid('optionB_'.$i, true) . '.' . $optionBImageExtension : null;
$questionOptionCImg = !empty($optionCImageName) ? uniqid('optionC_'.$i, true) . '.' . $optionCImageExtension : null;
$questionOptionDImg = !empty($optionDImageName) ? uniqid('optionD_'.$i, true) . '.' . $optionDImageExtension : null;
$questionOptionEImg = !empty($optionEImageName) ? uniqid('optionE_'.$i, true) . '.' . $optionEImageExtension : null;

if (!empty($questionImageName) || !empty($optionAImageName) || !empty($optionBImageName) ||
    !empty($optionCImageName) || !empty($optionDImageName) || !empty($optionEImageName)) {

    $questionImageDestination = !empty($questionImageNewName) ? "uploads/" . $questionImageNewName : "";
    $optionAImgDest = !empty($questionOptionAImg) ? "uploads/" . $questionOptionAImg : "";
    $optionBImgDest = !empty($questionOptionBImg) ? "uploads/" . $questionOptionBImg : "";
    $optionCImgDest = !empty($questionOptionCImg) ? "uploads/" . $questionOptionCImg : "";
    $optionDImgDest = !empty($questionOptionDImg) ? "uploads/" . $questionOptionDImg : "";
    $optionEImgDest = !empty($questionOptionEImg) ? "uploads/" . $questionOptionEImg : "";

    move_uploaded_file($questionImageTmpName, $questionImageDestination);
    move_uploaded_file($optionAImageTmpName, $optionAImgDest);
    move_uploaded_file($optionBImageTmpName, $optionBImgDest);
    move_uploaded_file($optionCImageTmpName, $optionCImgDest);
    move_uploaded_file($optionDImageTmpName, $optionDImgDest);
    move_uploaded_file($optionEImageTmpName, $optionEImgDest);
}

     
                // The image file has been moved successfully, add the question to the database
                $insertQuestionQuery = "INSERT INTO questions (exam_id, question, option_a, option_b, option_c, option_d, option_e, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path, answer) 
<<<<<<< HEAD
                VALUES ('$examId', '$questionText', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$questionImageDestination', '$optionAImgDest', '$optionBImgDest', '$optionCImgDest', '$optionDImgDest', '$optionEImgDest', '$combinedAnswers')";
=======
                VALUES ('$examId', '$questionText', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$questionImageDestination', '$optionAImgDest', '$optionBImgDest', '$optionCImgDest', '$optionDImgDest', '$optionEImgDest', '$answer')";
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
               if ( mysqli_query($conn, $insertQuestionQuery)){
                    $display .= "Question(s) Added Successfully To Exam title: ".$title ." Questions Count ". $i . "<br>";
               }
               else 
               {
                $display .= "Error: There was an error adding questions to exam title: " . $title . "<br>";
               }
<<<<<<< HEAD
       
     
=======
            
         
        
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7


}

<<<<<<< HEAD
          //Activities log and action taken respectively are declared here.
          $action = 'More Questions Added'; 
          $description = 'Logged in admin user: (' . $fullNames . ') added these numbers ("'. $questionCount .'") of questions to exam title: "' . $examTitle . '"';
       
      // Prepare the SQL statement to insert the record into the audit_tray table
 $sqlAudit = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES
  ('$fullNames', '$userID', '$description', '$action')";
 $returnRes = mysqli_query($conn, $sqlAudit);

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
echo $display;




    } 
    else
    {
        // The exam title does not exist, insert the exam into the exams table
        $sql1 = "INSERT INTO exams (title, description, duration) VALUES ('$examTitle', '$description', '$duration')";
        if (mysqli_query($conn, $sql1)) 
        {
            // Get the ID of the newly inserted exam
            $examId = mysqli_insert_id($conn);

            // Loop through each question and its options
            for($i = 1; $i <= $questionCount; $i++) 
            {
<<<<<<< HEAD

     // Get the correct answers for each question
     $correctAnswersJSON = isset($_POST['correctAnswers']) ? $_POST['correctAnswers'] : '';
     $correctAnswers = json_decode($correctAnswersJSON, true);
 
 
     // Combine the answers into a single string (e.g., ['A', 'D', 'E'] becomes 'ADE')
     $combinedAnswers = implode(',', $correctAnswers[$i]);
 

                  // Get the question text and other options
  $questionText = mysqli_real_escape_string($conn, $_POST['question'.$i]);
  $option_a = mysqli_real_escape_string($conn, $_POST['option_a'.$i]);
  $option_b = mysqli_real_escape_string($conn, $_POST['option_b'.$i]);
  $option_c = mysqli_real_escape_string($conn, $_POST['option_c'.$i]);
  $option_d = mysqli_real_escape_string($conn, $_POST['option_d'.$i]);
  $option_e = mysqli_real_escape_string($conn, $_POST['option_e'.$i]); // Added new option






=======
                // Get the question text
                $questionText =mysqli_real_escape_string($conn, $_POST['question'.$i]);
                $option_a = mysqli_real_escape_string($conn, $_POST['option_a'.$i]);
                $option_b = mysqli_real_escape_string($conn, $_POST['option_b'.$i]);
                $option_c = mysqli_real_escape_string($conn, $_POST['option_c'.$i]);
                $option_d = mysqli_real_escape_string($conn, $_POST['option_d'.$i]);
                $option_e = mysqli_real_escape_string($conn, $_POST['option_e'.$i]); // Added new option
                $answer = mysqli_real_escape_string($conn, $_POST['correct'.$i]);

                // Check if an image has been uploaded for question
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
                    // Check if an image has been uploaded for question
$questionImageName = isset($_FILES["question_image_".$i]['name']) ? basename($_FILES["question_image_".$i]['name']) : "";
$questionImageTmpName = isset($_FILES["question_image_".$i]['tmp_name']) ? $_FILES["question_image_".$i]['tmp_name'] : "";
$questionImageExtension = isset($questionImageName) ? pathinfo($questionImageName, PATHINFO_EXTENSION) : "";

// Check if an image has been uploaded for option A
$optionAImageName = isset($_FILES["option_a_image_".$i]['name']) ? basename($_FILES["option_a_image_".$i]['name']) : "";
$optionAImageTmpName = isset($_FILES["option_a_image_".$i]['tmp_name']) ? $_FILES["option_a_image_".$i]['tmp_name'] : "";
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

// The image file is valid, move it to the upload directory
$questionImageNewName = !empty($questionImageName) ? uniqid('qimg_', true) . '.' . $questionImageExtension : null;
$questionOptionAImg = !empty($optionAImageName) ? uniqid('optionA_'.$i, true) . '.' . $optionAImageExtension : null;
$questionOptionBImg = !empty($optionBImageName) ? uniqid('optionB_'.$i, true) . '.' . $optionBImageExtension : null;
$questionOptionCImg = !empty($optionCImageName) ? uniqid('optionC_'.$i, true) . '.' . $optionCImageExtension : null;
$questionOptionDImg = !empty($optionDImageName) ? uniqid('optionD_'.$i, true) . '.' . $optionDImageExtension : null;
$questionOptionEImg = !empty($optionEImageName) ? uniqid('optionE_'.$i, true) . '.' . $optionEImageExtension : null;

if (!empty($questionImageName) || !empty($optionAImageName) || !empty($optionBImageName) ||
    !empty($optionCImageName) || !empty($optionDImageName) || !empty($optionEImageName)) {

    $questionImageDestination = !empty($questionImageNewName) ? "uploads/" . $questionImageNewName : "";
    $optionAImgDest = !empty($questionOptionAImg) ? "uploads/" . $questionOptionAImg : "";
    $optionBImgDest = !empty($questionOptionBImg) ? "uploads/" . $questionOptionBImg : "";
    $optionCImgDest = !empty($questionOptionCImg) ? "uploads/" . $questionOptionCImg : "";
    $optionDImgDest = !empty($questionOptionDImg) ? "uploads/" . $questionOptionDImg : "";
    $optionEImgDest = !empty($questionOptionEImg) ? "uploads/" . $questionOptionEImg : "";

    move_uploaded_file($questionImageTmpName, $questionImageDestination);
    move_uploaded_file($optionAImageTmpName, $optionAImgDest);
    move_uploaded_file($optionBImageTmpName, $optionBImgDest);
    move_uploaded_file($optionCImageTmpName, $optionCImgDest);
    move_uploaded_file($optionDImageTmpName, $optionDImgDest);
    move_uploaded_file($optionEImageTmpName, $optionEImgDest);
}

                        // The question image has been uploaded successfully, insert the question into the questions table
                        $sql2 = "INSERT INTO questions (exam_id, question, option_a, option_b, option_c, option_d, option_e, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path, answer) 
<<<<<<< HEAD
                        VALUES ('$examId', '$questionText', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$questionImageDestination', '$optionAImgDest', '$optionBImgDest', '$optionCImgDest', '$optionDImgDest', '$optionEImgDest', '$combinedAnswers')";
=======
                        VALUES ('$examId', '$questionText', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$questionImageDestination', '$optionAImgDest', '$optionBImgDest', '$optionCImgDest', '$optionDImgDest', '$optionEImgDest', '$answer')";
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
                        if (mysqli_query($conn, $sql2)) 
                        {
                            $display .= "Question " . $i . " has been added successfully! ".$questionImageNewName;
                        } 
                        else 
                        {
                            $display .= "Error: " . mysqli_error($conn) . "<br>";
                        }
<<<<<<< HEAD

                              //Activities log and action taken respectively are declared here.
               $action1 = 'Exam Creation'; 
               $description1 = 'Logged in admin user: (' . $fullNames . ') created exam title: "' . $examTitle . '" and added these numbers ("'. $questionCount .'") of questions';
            
                        // Prepare the SQL statement to insert the record into the audit_tray table
                        $sqlAudit1 = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES
                        ('$fullNames', '$userID', '$description1', '$action1')";
                        $returnRes1 = mysqli_query($conn, $sqlAudit1);
                        
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
                    } 
                   /*   else 
                    {
                        $display .= "Error uploading question image " . $i . "<br>";
                    }  */
        
         
        
        // Display success message
        echo "Exam title and its questions added successfully ";
    } 
    else 
    {
        echo "Error: " . mysqli_error($conn);
    }
}

}
else
{
// Display error message if exam details not set
echo "Error: Please provide exam details";
}

// Close database connection
mysqli_close($conn);

// Display error/success messages
echo $display;
?>
