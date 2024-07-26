<?php
// Set database connection variables
include("../connection.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

        // Prepare the SQL INSERT statement with placeholders for users
        $sql_insert_user = "INSERT INTO users (name, email, username, password, gender, application, examName, userPassport) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert_user = $conn->prepare($sql_insert_user);

        // Prepare the SQL INSERT statement with placeholders for user exams
        $sql_insert_user_exam = "INSERT INTO users_exam (user_id, exam_id, status) VALUES (?, ?, 'pending')";
        $stmt_insert_user_exam = $conn->prepare($sql_insert_user_exam);

        if (!$stmt_insert_user || !$stmt_insert_user_exam) {
            // Handle the case when preparing the statements fails
            $response = [
                'success' => false,
                'error' => 'Failed to prepare the SQL statements.'
            ];
            // Close the database connection
            $conn->close();
            // Send the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // Loop through each row in the worksheet (skip the header row)
        foreach ($worksheet->getRowIterator() as $key => $row) {
            if ($key === 1) continue; // Skip the first row (header row)

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            $data = [];

            // Loop through each cell in the row
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Extract data from the row
            if (count($data) < 8) {
                // Handle the case when the row does not have enough columns
                $errorCount++;
                continue; // Skip this row and proceed to the next
            }

            $name = $data[0];
            $email = $data[1];
            $username = $data[2];
            $password = $data[3];
            $gender = $data[4];
            $app = $data[5];
            $examNamesString = $data[6];
            $userPassportPath = $data[7];

            // Step 1: Convert the user passport image to binary (base64 encoding)
            $userPassportBinary = '';
            if (file_exists($userPassportPath)) {
                $userPassportBinary = base64_encode(file_get_contents($userPassportPath));

                // Step 2: Move the binary image to 'usersPassport' directory
                $userPassportFilename = basename($userPassportPath);
                $destinationPath = 'usersPassport/' . uniqid($username) . $userPassportFilename;

                if (file_put_contents($destinationPath, base64_decode($userPassportBinary))) {

                     // Set permissions for the uploaded file
                     chmod($destinationPath, 0644); // Adjust the permission mode as needed

                    // Step 3: Check if the user already exists in the database (based on email or username)
                    $sql_check_user = "SELECT id FROM users WHERE email = ? OR username = ?";
                    $stmt_check_user = $conn->prepare($sql_check_user);
                    $stmt_check_user->bind_param("ss", $email, $username);
                    $stmt_check_user->execute();
                    $result_check_user = $stmt_check_user->get_result();

                    if ($result_check_user->num_rows > 0) {
                        // Handle the case when the user already exists
                        $errorCount++;
                        $stmt_check_user->close();
                        continue; // Skip this row and proceed to the next
                    }

                    // Step 4: Insert the users' details into the database with the image binary data

                    // Bind parameters to the prepared statement
                    $stmt_insert_user->bind_param("ssssssss", $name, $email, $username, $password, $gender, $app, $examNamesString, $destinationPath);

                    // Execute the prepared statement
                    if ($stmt_insert_user->execute()) {
                        $user_id = $conn->insert_id; // Retrieve the user ID after successful insertion

                        // Step 5: For each exam name in the user's record, insert the user-exam records
                        if (!empty($examNamesString)) {
                            $examNamesArray = explode(',', $examNamesString);
                            $examNamesArray = array_map('trim', $examNamesArray);

                            $sql_select_exam = "SELECT id FROM exams WHERE title = ?";
                            $stmt_select_exam = $conn->prepare($sql_select_exam);

                            if (!$stmt_select_exam) {
                                // Handle the case when preparing the statement fails
                                $errorCount++;
                                $stmt_check_user->close();
                                continue; // Skip this row and proceed to the next
                            }

                            foreach ($examNamesArray as $examName) {
                                // Retrieve the exam ID based on the exam name
                                $stmt_select_exam->bind_param("s", $examName);
                                $stmt_select_exam->execute();
                                $result_select_exam = $stmt_select_exam->get_result();

                                if ($result_select_exam->num_rows > 0) {
                                    $row = $result_select_exam->fetch_assoc();
                                    $exam_id = $row['id'];

                                    // Insert the user-exam records into the 'users_exam' table
                                    $stmt_insert_user_exam->bind_param("ii", $user_id, $exam_id);

                                    if ($stmt_insert_user_exam->execute()) {
                                        // Increment the success count for exams
                                        //$successCount++;
                                    } else {
                                        // Handle the case when insertion fails
                                        $errorCount++;
                                    }
                                } else {
                                    // Handle the case when the exam name is not found in the database
                                    $errorCount++;
                                }
                            }

                            $stmt_select_exam->close();
                        }

                        $successCount++;
                    } else {
                        // Handle the case when insertion fails
                        $errorCount++;
                    }
                } else {
                    // Handle the case when moving the binary image fails
                    $errorCount++;
                }
            } else {
                // Handle the case when the user passport image file is not found
                $errorCount++;
                continue; // Skip this row and proceed to the next
            }
        }

        // Close the prepared statements
        $stmt_insert_user->close();
        $stmt_insert_user_exam->close();

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
