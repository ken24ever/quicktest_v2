<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}else{
  
$passport = $_SESSION['passport'];
$src = "admin/".$passport;
}
?>

<?php
// Set database connection variables
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Get logged-in user's exam IDs
$username = $_SESSION['username'];
$query = "SELECT exam_id, status, scores FROM users_exam JOIN users ON users_exam.user_id = users.id WHERE users.username = '$username'";
$result = mysqli_query($conn, $query);

$reset_link= "reset.php?user=".$username;
// Create an array to store the exam names and details
$exams = array();

// Loop through the result of the logged-in user's exams
while ($row = mysqli_fetch_assoc($result)) {
    $examID = $row['exam_id'];
    $status = $row['status'];
    $scores = $row['scores']; 
    
    //$totatExamCount = $row['totalExams']; COUNT(exam_id) AS totalExams
    // Retrieve the specific exam details from the "exams" table based on the exam ID
    $query = "SELECT title, duration FROM exams WHERE id = '$examID'";
    $examResult = mysqli_query($conn, $query);

    if (mysqli_num_rows($examResult) == 1) {
        $examRow = mysqli_fetch_assoc($examResult);
        $examName = $examRow['title'];
        $duration = $examRow['duration'];

        // Check the status of the exam
        if ($status == "pending") {
            $statusText = "Not taken";
            $score = 'N/A';
            $action = "<a href=\"quiz.php?examID=" . urlencode($examID) . "\"><button class='btn btn-success'>Proceed</button></a>";
        } elseif ($status == "in_progress") {
            $statusText = "In progress";
            $score = 'N/A';
            $action = "<a href=\"start_exam.php?examID=" . urlencode($examID) . "\"><button class='btn btn-primary'>Continue</button></a>";;
        } elseif ($status == "completed") {
            $statusText = "Taken";
            $score = $scores;
            $action = "<button class='btn btn-info'>Completed</button>";
        }

        // Store the exam details in the array
        $exams[] = array(
            'name' => $examName,
            'duration' => $duration,
            'scores' => $score,
            'status' => $statusText,
            'action' => $action
            
        );
    }
}

mysqli_close($conn);
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
  <link rel="stylesheet" href="bootstrap_v4/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="style.css"> -->

<!-- highchart lib -->
  <script src="highchartsLib/code/highcharts.js"></script>
<script src="highchartsLib/code/modules/accessibility.js"></script>

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
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">User Dashboard</a>
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
      <div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-user"></i> Profile
          </div>
          <div class="card-body">
            <h5 class="card-title">Confirm Datails Here.</h5>
        <center> <div id="passportCont" style="width: 180px; height: 180px;">
               <img src="<?php echo $src; ?>" alt="" style="width: 180px; height: 180px;" class="rounded-circle img-thumbnail">
        </div></center>

            <p class="card-text">Names: <?php echo $_SESSION['name'];  ?></p>
			<p class="card-text">Username: <?php echo $_SESSION['username'];  ?></p>
            <p class="card-text">Default Role: Candidate</p>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewProfileModal">View Profile</button>
          </div>
        </div>
      </div>
<!--  -->

<div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-clipboard-list"></i> Exams
          </div>
          <div class="card-body">
            <h5 class="card-title">Available Exams</h5>
            <p class="card-text">Click The Button Below To View Number Of Exams You Have.</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary text-white" data-toggle="modal" data-target="#examsModal">View Exams</a>
          </div>
        </div>
      </div>
<!--  -->

  <div class="col-lg-4 mb-4">
    <div class="card">
      <div class="card-header">
        <i class="fas fa-chart-line"></i> Performance
      </div>
      <div class="card-body">
        <h5 class="card-title">Your Performance</h5>
       
        <div id="chartContainer"></div><br>
        <div id="pieChartContainer"></div>
        
       
    
      </div>
      <div class="card-footer">
	  <a href="#" class="btn btn-primary text-white" data-toggle="modal" data-target="#performanceModal">View Performance</a>
      </div>
    </div>
  </div>
</div>
</div>
<!--  -->

 <!-- View Profile Modal -->
 <div class="modal fade" id="viewProfileModal" tabindex="-1" role="dialog" aria-labelledby="viewProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewProfileModalLabel">User Profile Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
		<h5>Name: <?php echo $_SESSION['name'];  ?></h5></b>
		<hr>
       <b> <p>Email: <?php echo $_SESSION['emailAddrs'];  ?></p></b>
		<hr>
		<b> <p>Username: <?php echo $_SESSION['username'];  ?></p></b>
		<hr>
		<b><p>Gender: <?php echo $_SESSION['gender']; ?></p></b>
		<hr>
		<b><p>Job Applied For: <?php echo $_SESSION['app']; ?></p></b>
	
        </div></b>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--  -->

<!-- Exams Modal -->
<div class="modal fade" id="examsModal" tabindex="-1" role="dialog" aria-labelledby="examsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="examsModalLabel">Exams</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <table class="table">
    <thead>
        <tr>
            <th>Exam Name</th>
            <th>Duration</th>
            <th>Status</th>
            <th>Scores</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($exams as $exam) { ?>
            <tr>
                <td><?php echo $exam['name']; ?></td>
                <td><?php echo $exam['duration']; ?></td>
                <td><?php echo $exam['status']; ?></td>
                 <td><?php echo $exam['scores']."%"; ?></td> 
                <td><?php echo $exam['action']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

      </div>
      <div class="modal-footer">
        <!-- <a type="button" class="btn btn-danger" href="<?php echo $reset_link; ?>">Reset Exams (For demo only)</a> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--  -->

<!-- Performance Modal -->
<div class="modal fade" id="performanceModal" tabindex="-1" role="dialog" aria-labelledby="performanceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="performanceModalLabel">Performance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <label for="app">Select exam :</label>
        <select id="examSelect" name="examSelect" class="form-control">
           <option value="">Select exam </option> 
        <?php
include 'connection.php';

// Fetch completed exams of a particular user from the database
$userId = $_SESSION['id']; // Replace '1' with the actual user ID
$sql = "SELECT ue.id, e.id AS exam_id, e.title FROM users_exam ue
        INNER JOIN exams e ON ue.exam_id = e.id
        WHERE ue.status = 'completed' AND ue.user_id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fetch the exam title from the exams table
        $examId = $row['exam_id'];
        $examTitleSql = "SELECT title FROM exams WHERE id = $examId";
        $examTitleResult = $conn->query($examTitleSql);
        $examTitleRow = $examTitleResult->fetch_assoc();

        echo "<option value='" . $row['exam_id'] . "' title='" . $row['exam_id'] . "'>" . $examTitleRow['title'] . "</option>";
    }
}

$conn->close();
?>


        </select>
    </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--  -->

<!-- Add these script tags at the end of the HTML body -->

  
  <script>
$(document).ready(function() {
    $('#examSelect').change(function() {
        var examId = $(this).val();

        if (examId !== '') {
            // AJAX request to fetch exam details and scores
            $.ajax({
                url: 'get_exam_details.php',
                type: 'POST',
                data: { examId: examId },
                success: function(response) {
                    var examData = JSON.parse(response);
                    
                    // Convert scores to numeric values
                    var scores = parseFloat(examData.scores);
                    
                    // Generate the Highcharts chart
                    Highcharts.chart('chartContainer', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Exam Scores: ' + examData.examName
                        },
                        xAxis: {
                            categories: examData.categories
                        },
                        yAxis: {
                            title: {
                                text: 'Scores'
                            }
                        },
                        series: [{
                            name: 'Scores',
                            data: [scores], // Pass the scores as an array with a single value
                            color: '#FF0000' // Set the color to red (you can use any valid color value)
                        }]
                    });

                    // Generate the Highcharts pie chart
                    Highcharts.chart('pieChartContainer', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Exam Results: ' + examData.examName
                        },
                        series: [{
                            name: 'Categories',
                            colorByPoint: true,
                            data: Object.entries(examData.categories).map(([category, value]) =>
                                ({
                                    name: category,
                                    y: value
                                })
                            )
                        }]
                    });
                }
            });
        } else {
            $('#chartContainer').empty(); // Clear the chart container if no exam is selected
            $('#pieChartContainer').empty(); // Clear the pie chart container if no exam is selected
        }
    });
});

    </script>



<!--  -->


<script src="bootstrap_v4/js/bootstrap.min.js"></script>
  <!--  -->
  




</body>
</html>