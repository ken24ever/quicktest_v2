<?php
session_start();
  // Set database connection variables
  include("connection.php");

  // Retrieve the exam details from the query string
  $examID = $_GET["examID"];
  $userID = $_SESSION['id'] ;

  // Retrieve and display the exam details from the database
  $sql = "SELECT title, description, duration FROM exams WHERE id = '$examID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $examTitle = $row["title"];
    $examDescription = $row["description"];
    $duration = $row['duration'];
  } else {
    echo "Exam not found.";
  }

  // Close the database connection
  $conn->close();
  ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CBT Confirmation Page</title>
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">

  <link rel="stylesheet" href="bootstrap_v4/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="style.css"> -->



	<!-- jquery library -->
	<script src="jquery/jquery-3.6.0.min.js"></script>
  <style>
    /* Custom styles */
    .dashboard {
      margin-top: 50px;
    }

    .dashboard .card {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .dashboard .card-header {
      background-color: #f8f9fa;
      border-bottom: none;
      font-weight: bold;
    }

    .dashboard .card-body {
      padding: 20px;
    }

    .dashboard .card-body h5 {
      margin-bottom: 15px;
    }

    .dashboard .card-body p {
      margin-bottom: 0;
    }

    .dashboard .card-footer {
      background-color: #f8f9fa;
      border-top: none;
    }

    .dashboard .card-footer a {
      color: #007bff;
    }

    .dashboard .card-footer a:hover {
      text-decoration: none;
    }

    .chart-container {
      height: 300px;
    }
  </style>
	<link rel="stylesheet" href="css/style.css">
</head>

<body style = "background-image: url('img/bgbg.jpg'); background-size: cover; background-attachment: fixed; background-position: center;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Candidate Exam Confirmation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="logout.php">Logout <span class="sr-only">(current)</span></a>
        </li>
     
      </ul>
    </div>
  </nav>

  <div class="container dashboard">
    <div class="row">
<!--  -->
      <div class="col-lg-12 mb-4">
        <div class="card">
          <div class="card-header">
           Confirmation 
          </div>
          <div class="card-body">
            <h5 class="card-title">Confirm Exam.</h5>
            
<?php
            
    echo "<h2>Exam Details</h2>";
    echo "<p class='card-text'><strong>Exam Title:</strong> " . $examTitle . "</p>";
    echo "<p class='card-text'><strong>Description:</strong> " . $examDescription . "</p>";
    echo "<p class='card-text'><strong>Duration:</strong> " . $duration . " minutes</p>";

    ?>
          </div>
          <div class="card-footer">
            <p class='card-text'>Please confirm if you are ready to start the exam.</p>
            <button id="confirm-exam-button" class="btn btn-success">Start Exam</button>
        </div>
        </div>
        <!--  -->
      </div>
</div>




  <script>
$(document).ready(function() {
  // Confirm Exam button click event
  $('#confirm-exam-button').click(function() { 
    // AJAX call to update the table
    $.ajax({
      url: 'update_table.php', // Replace with the actual PHP script URL
      method: 'POST',
      data: {
        user_id: <?php echo $userID; ?>, // Replace with the actual user ID
        exam_id: <?php echo $examID; ?> // Replace with the actual exam ID
    
      },
      success: function(response) {
        console.log(response); // Optional: Log the response from the PHP script
        // Handle success scenario here
        // For example, display a success message or redirect the user to the exam page
        window.location.href = 'start_exam.php?examID=<?php echo urlencode($examID); ?>';
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText); // Optional: Log the error response from the PHP script
        // Handle error scenario here
        // For example, display an error message to the user
      }
    });
  });
}); 


  </script>

<script src="bootstrap_v4/js/bootstrap.min.js"></script>
</body>
</html>
