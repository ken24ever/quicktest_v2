<?php
<<<<<<< HEAD
session_start();
$fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 

=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
header('Content-Type: application/json');

// Check if the exam ID is set
if (isset($_POST['examId'])) {
    // Get the exam ID from the POST data
    $examId = $_POST['examId'];
    
<<<<<<< HEAD
    //get exam title
    $exam_Title = $_POST['exam_Title'];

    // Get database connection
    include("../connection.php");

    $action = 'Exam Details Deleted'; 
    $description = 'Logged in admin user: (' . $fullNames . ') deleted details of exam with title: "' . $exam_Title . '"';

        // Prepare the SQL statement to insert the record into the audit_tray table
  $sqlDel = "INSERT INTO audit_tray (user_name, user_id, description, action) VALUES (?,?,?,?)";
  $stmtsqlDel = $conn->prepare($sqlDel);
  $stmtsqlDel->bind_param("siss", $fullNames, $userID, $description, $action);

  // Execute the query and check if it was successful
  if ($stmtsqlDel->execute()) {
      // Send success response (You can choose to send a response if needed)
       //echo json_encode(['success' => true, 'message' => 'Record added to audit_tray']);
  } else {
      // Send error response if the query failed
      //echo json_encode(['success' => false, 'message' => 'Failed to add record to audit_tray']);
      // You may log the error for debugging purposes
     // error_log("Failed to add record to audit_tray: " . $stmt->error);
  }

=======
    // Get database connection
    include("../connection.php");

>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    // Prepare the SQL statement to retrieve all the questions associated with the exam
    $stmt = $conn->prepare("SELECT exam_id, image_ques, option_a_image_path, option_b_image_path, option_c_image_path, option_d_image_path, option_e_image_path FROM questions WHERE exam_id = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $examId);
    
    // Execute the statement
<<<<<<< HEAD
    $stmt->execute(); 
=======
    $stmt->execute();
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
    
    // Bind the results to variables
    $stmt->bind_result($id, $image, $option1, $option2, $option3, $option4, $option5);
    
    // Create an array to store the image paths for deletion later
    $imagePaths = array();

    // Loop through the results and add the image paths to the array
    while ($stmt->fetch())
     {
        if (!empty($image)) {
            $imagePaths[] = $image;
        }
        if (!empty($option1)) {
            $imagePaths[] = $option1;
        }
        if (!empty($option2)) {
            $imagePaths[] = $option2;
        }
        if (!empty($option3)) {
            $imagePaths[] = $option3;
        }
        if (!empty($option4)) {
            $imagePaths[] = $option4;
        }
        if (!empty($option5)) {
            $imagePaths[] = $option5;
        }
    }
    
    // Close the statement to free up resources
    $stmt->close();

    // Prepare the SQL statement to delete the exam
    $stmt1 = $conn->prepare("DELETE FROM exams WHERE id = ?");
    
    // Bind the parameter
    $stmt1->bind_param("i", $examId);
    
    // Execute the statement
    $stmt1->execute();

    // Get the number of rows affected
    $numRowsDeleted = $stmt1->affected_rows;

    // Close the statement to free up resources
    $stmt1->close();

    // Prepare the SQL statement to delete the questions associated with the exam
    $stmt2 = $conn->prepare("DELETE FROM questions WHERE exam_id = ?");
    
    // Bind the parameter
    $stmt2->bind_param("i", $examId);
    
    // Execute the statement
    $stmt2->execute();

    // Get the number of rows affected
    $numRowsDeleted += $stmt2->affected_rows;

    // Close the statement to free up resources
    $stmt2->close();

    // Delete the image files
    foreach ($imagePaths as $imagePath) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Check if the deletion was successful
    if ($numRowsDeleted > 0) {
        // If the deletion was successful, return a success JSON response
        $response = array('status' => 'success', 'message' => 'Exam ID with '.$examId.' deleted  successfully.');
        echo json_encode($response);
    } else {
        // If the deletion failed, return an error JSON response
        $response = array('status' => 'error', 'message' => 'Error deleting exam.');
        echo json_encode($response);
    }

}