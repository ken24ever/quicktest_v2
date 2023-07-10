<?php


// Set database connection variables
include("connection.php");
$error_msg = "";
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        //loop
        while($row = mysqli_fetch_assoc($result)){

          $usrID = $row['id'];
          $username = $row['username'];
          $Password_ = $row['password'];
          $names = $row['name'];
          $gender = $row['gender'];
          $examName = $row['examName'];
          $emailAddrs= $row['email'];
          $app= $row['application'];

        // User found, start session and redirect to dashboard
        session_start();
        $_SESSION['id'] = $usrID ;
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $names;
        $_SESSION['password'] = $Password_;
        $_SESSION['id'] = $usrID;
        $_SESSION['gender'] = $gender;
        $_SESSION['emailAddrs'] = $emailAddrs;
        $_SESSION['examName'] = $examName;
        $_SESSION['app'] = $app;

        // Return empty response for successful login
        echo "";
        }//end of while loop

    } else {
        // User not found, show error message
        $error_msg = "Invalid email or password";
    }
    echo $error_msg;
}

mysqli_close($conn);
?>