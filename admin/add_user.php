<?php
// Set database connection variables
include("../connection.php");

// Get values submitted via the form
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
$name = mysqli_real_escape_string($conn, $_POST['names']);
$username = mysqli_real_escape_string($conn, $_POST['username']); 
$password = mysqli_real_escape_string($conn, $_POST['password']); 
$email = mysqli_real_escape_string($conn, $_POST['email']);
$examNames = $_POST['examsList']; // Retrieve the array of selected values
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$app = mysqli_real_escape_string($conn, $_POST['app']);
 
<<<<<<< HEAD
=======
=======
$name = $_POST['names'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$examNames = $_POST['examsList']; // Retrieve the array of selected values
$gender = $_POST['gender'];
$app = $_POST['app'];
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
// Check if the username or email already exists
$sql_check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows > 0) {
    echo "Username or email already exists";
} else {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
    // Handle user passport image upload
    $userPassportDir = "usersPassport/"; // Directory to store user passport images

    if ($_FILES['userPassport']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['userPassport']['tmp_name'];
        $fileExt = pathinfo($_FILES['userPassport']['name'], PATHINFO_EXTENSION);
        $userPassportFileName = uniqid('user_passport_') . '.' . $fileExt;
        $userPassportPath = $userPassportDir . $userPassportFileName;

        if (move_uploaded_file($tmpName, $userPassportPath)) {
            // User passport image uploaded successfully, proceed with database insertion

            // Insert new user into the database
            if (!empty($examNames)) {
                $examNames = array_unique($examNames); // Remove duplicates from the array

                $escapedExamNames = array_map(function ($name) use ($conn) {
                    return mysqli_real_escape_string($conn, $name);
                }, $examNames);

                $examNamesString = implode(",", $escapedExamNames);

                // Insert the user into the 'users' table
                $sql_insert_user = "INSERT INTO users (name, email, username, password, gender, application, examName, userPassport) VALUES ('$name', '$email', '$username', '$password', '$gender', '$app', '$examNamesString', '$userPassportPath')";

                if ($conn->query($sql_insert_user) === TRUE) {
                    $user_id = $conn->insert_id; // Retrieve the user ID

                    // Insert the user-exam records into the 'users_exam' table
                    $sql_insert_user_exams = "INSERT INTO users_exam (user_id, exam_id, status, scores) VALUES";

                    $values = array();
                    foreach ($examNames as $examName) {
                        // Retrieve the exam ID based on the exam name
                        $sql_select_exam = "SELECT id FROM exams WHERE title = '$examName'";
                        $result_select_exam = $conn->query($sql_select_exam);

                        if ($result_select_exam->num_rows > 0) {
                            $row = $result_select_exam->fetch_assoc();
                            $exam_id = $row['id'];

                            $values[] = "('$user_id', '$exam_id', 'PENDING', '')";
                        }
                    }

                    if (!empty($values)) {
                        $sql_insert_user_exams .= implode(", ", $values);

                        if ($conn->query($sql_insert_user_exams) === TRUE) {
                            echo "New user added successfully";
                        } else {
                            echo "Error: " . $sql_insert_user_exams . "<br>" . $conn->error;
                        }
                    } else {
                        echo "No matching exams found";
                    }
                } else {
                    echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
                }
            } else {
                echo "Please select at least one exam";
            }
        } else {
            echo "Error: Failed to move uploaded file";
        }
    } else {
        echo "Error: " . $_FILES['userPassport']['error'];
<<<<<<< HEAD
=======
=======
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
            $sql_insert_user_exams = "INSERT INTO users_exam (user_id, exam_id, status, scores) VALUES";
            
            $values = array();
            foreach ($examNames as $examName) {
                // Retrieve the exam ID based on the exam name
                $sql_select_exam = "SELECT id FROM exams WHERE title = '$examName'";
                $result_select_exam = $conn->query($sql_select_exam);
                
                if ($result_select_exam->num_rows > 0) {
                    $row = $result_select_exam->fetch_assoc();
                    $exam_id = $row['id'];
                    
                    $values[] = "('$user_id', '$exam_id', 'PENDING', '')";
                }
            }
            
            if (!empty($values)) {
                $sql_insert_user_exams .= implode(", ", $values);
                
                if ($conn->query($sql_insert_user_exams) === TRUE) {
                    echo "New user added successfully";
                } else {
                    echo "Error: " . $sql_insert_user_exams . "<br>" . $conn->error;
                }
            } else {
                echo "No matching exams found";
            }
        } else {
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }
    } else {
        echo "Please select at least one exam";
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
    }
}

// Close the database connection
$conn->close();
<<<<<<< HEAD
?>
=======
<<<<<<< HEAD
?>
=======
?> 
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
