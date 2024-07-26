<?php
// Set database connection variables
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve username and password from the POST request 
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch the Admin User by username
    $sql = "SELECT admin.id, admin.name, admin.password, admin.access_level, licenses.ip_address 
            FROM admin 
            LEFT JOIN licenses ON admin.id = licenses.admin_id
            WHERE admin.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result(); 

    if ($result->num_rows === 1) {
        // User found, verify the password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        $accessLevel = $row['access_level'];
        $userIP = $row['ip_address'];

        // Verify the password using password_verify()
        if (password_verify($password, $hashedPassword)) {
            // Check if the IP address is available for the admin
            if (!empty($userIP)) {
                // Authentication successful
                $user_id = $row['id'];
                $user_name = $row['name'];

                // Start the session and store user details
                session_start();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['access_level'] = $accessLevel;

                // Send success response
                echo json_encode(['success' => true]);
            } else {
                // IP address is not available
                echo json_encode(['success' => false, 'message' => 'IP address is not available.']);
            }
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
