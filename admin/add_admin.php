<?php
include('../connection.php');

// Function to get the MAC address of the server
function getMACAddress() {
    // Using shell_exec to execute a shell command to get the MAC address
    $macAddr = false;

    // For Linux
    if (PHP_OS == 'Linux') {
        @exec("ifconfig -a | grep -Po 'HWaddr \K.*$'", $result);
        if ($result) {
            $macAddr = $result[0];
        }
    }
    // For Windows
    elseif (PHP_OS == 'WINNT') {
        @exec("getmac", $result);
        if ($result) {
            $macAddr = substr($result[0], 0, 17);
        }
    }

    return $macAddr;
}

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $name = $_POST['adminName'];
    $email = $_POST['adminEmail'];
    $username = $_POST['adminUsername'];
    $password = $_POST['adminPassword'];
    $accessLevel = $_POST['accessLevel'];
    $clientIP = $_POST['clientIP'];

    // Get the MAC address of the server
    $serverMAC = getMACAddress();

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
                // Get the ID of the newly inserted admin user
                $adminId = $stmt->insert_id;

                // Generate a new license key
                $licenseKey = md5(uniqid());
                $expirationDate = date('Y-m-d H:i:s', strtotime('+1 month'));

                // Insert into license table
                $insertLicenseQuery = "INSERT INTO licenses (admin_id, access_level, license_key, mac_address, ip_address, expiration_date) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertLicenseQuery);
                $stmt->bind_param("iissss", $adminId, $accessLevel, $licenseKey, $serverMAC, $clientIP, $expirationDate);
                
                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Admin user added successfully.', 'licenseKey' => $licenseKey];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to insert license details. Please try again.'];
                }
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
