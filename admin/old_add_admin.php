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
           // ...

if ($stmt->execute()) {
    // Get the ID of the newly inserted admin user
    $adminId = $stmt->insert_id;

    // Update or insert license information
    $checkLicenseQuery = "SELECT * FROM licenses WHERE admin_id = ?";
    $stmt = $conn->prepare($checkLicenseQuery);
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // License key already exists for this admin
        $licenseData = $result->fetch_assoc();
        $licenseKey = $licenseData['license_key'];
    } else {
        // Generate a new license key
        $licenseKey = md5(uniqid());
        $expirationDate = date('Y-m-d H:i:s', strtotime('+1 month'));

        // Insert into licenses table
        $insertLicenseQuery = "INSERT INTO licenses (admin_id, access_level, license_key, expiration_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertLicenseQuery);
        $stmt->bind_param("iiss", $adminId, $accessLevel, $licenseKey, $expirationDate);
        $stmt->execute();
    }

    $response = ['success' => true, 'message' => 'Admin user added successfully.', 'licenseKey' => $licenseKey];
} else {
    $response = ['success' => false, 'message' => 'Failed to add admin user. Please try again.'];
}

// ... 
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
