<?php
// Set database connection variables
include("../connection.php");

// Check if a file is uploaded
if (isset($_FILES['user_batch_file'])) {
  $file = $_FILES['user_batch_file'];

  // Check if the file is an Excel file
  if ($file['type'] == 'application/vnd.ms-excel' || $file['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
    $tempFile = $file['tmp_name'];

    // Load the PhpSpreadsheet library using Composer's autoloader
    require_once 'vendor/autoload.php';

    // Load the Excel file
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tempFile);

    // Get the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();

    $successCount = 0;
    $errorCount = 0;

    // Loop through each row in the worksheet
    foreach ($worksheet->getRowIterator() as $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false);

      $data = [];

      // Loop through each cell in the row
      foreach ($cellIterator as $cell) {
        $data[] = $cell->getValue();
      }

      // Extract data from the row
      $name = $data[0];
      $email = $data[1];
      $username = $data[2];
      $password = $data[3];
      $gender = $data[4];
      $app = $data[5];
      // Retrieve the exam names from index 6
        $examNamesString = $data[6];
        $examNamesArray = explode(',', $examNamesString);

        // Capitalize the exam names
        $examNames = array_map('strtoupper', $examNamesArray);

      // Check if the username or email already exists
      $sql_check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
      $result_check = $conn->query($sql_check);

      if ($result_check->num_rows > 0) {
        $errorCount++;
      } else {
        // Insert new user into the database
        if (!empty($examNames)) {
          $examNames = array_unique($examNames); // Remove duplicates from the array

          $escapedExamNames = array_map(function ($name) use ($conn) {
            return mysqli_real_escape_string($conn, $name);
          }, $examNames);

          $examNamesString = implode(",", $escapedExamNames);

          // Insert the user into the 'users' table
          $sql_insert_user = "INSERT INTO users (name, email, username, password, gender, application, examName) VALUES ('$name', '$email', '$username', '$password', '$gender', '$app', '$examNamesString')";

          if ($conn->query($sql_insert_user) === TRUE) {
            $user_id = $conn->insert_id; // Retrieve the user ID

            // Insert the user-exam records into the 'users_exam' table
            $sql_insert_user_exams = "INSERT INTO users_exam (user_id, exam_id, status) VALUES";
            $values = array();

            foreach ($examNames as $examName) {
              // Retrieve the exam ID based on the exam name
              $sql_select_exam = "SELECT id FROM exams WHERE title = '$examName'";
              $result_select_exam = $conn->query($sql_select_exam);

              if ($result_select_exam->num_rows > 0) {
                $row = $result_select_exam->fetch_assoc();
                $exam_id = $row['id'];

                $values[] = "('$user_id', '$exam_id', 'pending')";
              }
            }

            if (!empty($values)) {
              $sql_insert_user_exams .= implode(", ", $values);

              if ($conn->query($sql_insert_user_exams) === TRUE) {
                $successCount++;
              } else {
                $errorCount++;
              }
            } else {
              $errorCount++;
            }
          } else {
            $errorCount++;
          }
        } else {
          $errorCount++;
        }
      }
    }

    // Prepare the response
    $response = [ 
      'success' => true,
      'message' => $successCount . ' users added successfully. ' . $errorCount . ' users could not be added.'
    ];
  } else {
    $response = [
      'success' => false,
      'error' => 'Invalid file format. Please upload an Excel file.'
    ];
  }
} else {
  $response = [
    'success' => false,
    'error' => 'No file uploaded.'
  ];
}

// Close the database connection
$conn->close();

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
