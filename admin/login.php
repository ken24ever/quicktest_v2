<?php
// Set database connection variables
include("../connection.php");

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
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
<<<<<<< HEAD
=======
=======
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
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
?>
