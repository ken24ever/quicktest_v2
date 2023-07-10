<?php
// Set database connection variables
include("../connection.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // User found, start session
        session_start();
        $_SESSION['username'] = $username;

        // Return empty response for successful login
        echo "";
    } else {
        // User not found, show error message
        echo "Invalid username or password";
    }
}

mysqli_close($conn);
?>
