<?php
// Set database connection variables
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve username and password from the POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the Super Admin User by username
    $sql = "SELECT id, name, password, access_level FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password using password_verify()
        if (password_verify($password, $hashedPassword)) {
            // Authentication successful
            $user_id = $row['id'];
            $user_name = $row['name'];
            $access_level = $row['access_level'];

            // Start the session and store user details
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['access_level'] = $access_level;

            // Send success response
            echo json_encode(['success' => true]);
        } else {
            // Authentication failed due to incorrect password
            echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
        }
    } else {
        // Authentication failed due to invalid username
        echo json_encode(['success' => false, 'message' => 'Invalid username.']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$conn->close();
?>
