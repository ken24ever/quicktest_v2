<?php
include('../connection.php');

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $name = $_POST['adminName'];
    $email = $_POST['adminEmail'];
    $username = $_POST['adminUsername'];
    $password = $_POST['adminPassword'];
    $accessLevel = $_POST['accessLevel'];

    // Validate form data (you can add more validation if required)
    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($accessLevel)) {
        $response = ['success' => false, 'message' => 'Please fill in all the required fields.'];
    } else {
        // Check if the username is already taken
        $checkUsernameQuery = "SELECT id FROM admin WHERE username = ?";
        $stmt = $conn->prepare($checkUsernameQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $response = ['success' => false, 'message' => 'Username already taken. Please choose another username.'];
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Prepare the SQL statement to insert the new admin user
            $insertAdminQuery = "INSERT INTO admin (name, email, username, password, access_level) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAdminQuery);
            $stmt->bind_param("ssssi", $name, $email, $username, $hashedPassword, $accessLevel);

            // Execute the statement
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Admin user added successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to add admin user. Please try again.'];
            }
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request.'];
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
