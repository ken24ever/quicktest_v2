<?php
session_start();
  // Set database connection variables
  include("connection.php");

  // Retrieve the exam details from the query string
  $examID = $_GET["examID"];
  $userID = $_SESSION['id'] ;
  $passport = $_SESSION['passport'];
  $src = "admin/".$passport;

  // Retrieve and display the exam details from the database
  $sql = "SELECT title, duration FROM exams WHERE id = '$examID'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $examTitle = $row["title"];
    $duration = $row["duration"];

  } else {
    echo "Exam not found.";
  }

  // Close the database connection
  $conn->close();
  ?>

<?php
include("connection.php");

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the start_time
$sql1 = "SELECT DATE_FORMAT(start_time, '%H:%i:%s') AS start_time FROM users_exam WHERE exam_id = ? AND user_id = ?";

// Assuming you have the examID and userID available as GET parameters
$examID1 = $_GET["examID"];
$userID1 = $_SESSION['id'];

// Prepare the statement and bind the parameters
$stmt = $conn->prepare($sql1);
$stmt->bind_param("ss", $examID1, $userID1);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Fetch the row
  $row = $result->fetch_assoc();
  // Assuming the start_time is retrieved from the database in the format 'Y-m-d H:i:s'
$startTime = new DateTime($row["start_time"]);
$startTimeString = $startTime->format('Y/m/d H:i:s');

  // Return the start_time
  //echo $startTime;
} else {
  // No start_time found
  echo "No start time found for the exam.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
<?php

// Include your database connection logic here
// For example, if you are using mysqli, you might have something like this:
// include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Set up your database connection and perform the query
// Example using mysqli (replace with your database connection logic)
include("connection.php");

// Fetch the remaining_time from the users table
$query = "SELECT remaining_time FROM users WHERE id = $user_id";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $remaining_time = $row['remaining_time']; // The value is already an integer
       // echo json_encode(['remainingTime' => $remaining_time]);
    } else {
        echo ('User found, but remaining_time is NULL');
    }
} else {
    echo ('Query failed: ' . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CBT Exam Section</title>
  <link rel="stylesheet" href="bootstrap_v4/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">
	<!-- <link rel="stylesheet" href="style.css"> -->



	<!-- jquery library -->
	<script src="jquery/jquery-3.6.0.min.js"></script>

  <!-- sweet  alert 2 lib -->
  <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
<script src="sweetalert2/dist/sweetalert2.all.min.js"></script>

	

  <style>
  .container-fluid {
    margin-top: 50px; /* Adjust the value as needed */
  }
</style>
  
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

    .text-lg{
      font-size:20px !important
    }

    /* radio button styling */

    /* CSS */
input[type="radio"], input[type="checkbox"] {
  /* Increase the size of the radio button */
  width: 20px;
  height: 20px;
}

/* Optional: Style the radio button appearance */
input[type="radio"] {
  /* Hide the default radio button appearance */
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  /* Add custom styles for the radio button */
  border: 2px solid #999999;
  border-radius: 50%;
  background-color: #ffffff;
  outline: none;
}

/* Optional: Style the radio button when checked */
input[type="radio"]:checked, input[type="checkbox"]:checked {
  /* Add custom styles for the checked radio button */
  background-color: DodgerBlue;
  border-color: #000000;
}

/* toggle blink styling */

.blink-red {
  animation: blink 1s infinite;
}

@keyframes blink {
  0% {
    color: red;
  }
  50% {
    color: transparent;
  }
}


  </style>
<!--   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</head>

<body>
 

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Exam Started</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">

     <!--  <li class="nav-item active">
          <a class="nav-link" href="#"><strong><span id="timer">00:00:00</span></strong><span class="sr-only">(current)</span></a>
        </li>  -->
 
        <li class="nav-item active">
          <a class="nav-link" href="#"><strong>Candidate Name:</strong> <?php echo $_SESSION['name']; ?> <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="#"><strong>Job Applied For:</strong> <?php echo $_SESSION['app']; ?> <span class="sr-only">(current)</span></a>
        </li>

      <li class="nav-item active">
          <a class="nav-link" href="#"><strong>Exam Title:</strong> <?php echo $examTitle; ?> <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="#"><strong>Duration:</strong> <?php echo $duration; ?> minutes<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#"><button id="submit-exam-button" class="btn btn-primary">Submit Exam</button> <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="logout.php"><button id="logout" class="btn btn-danger">Logout </button><span class="sr-only">(current)</span></a>
        </li>
     
      </ul>
    </div>
  </nav>
    
  <!--  -->
  <hr>
                            <div class="container-fluid mt-10">
                            <div class="row">
                                          <div class="col-lg-5">

                                                   <div id="passportCont" style="width: 150px; height: 150px;">
                                                     <img src="<?php echo $src; ?>" alt="" style="width: 150px; height: 150px" class="rounded-circle img-thumbnail">
                                                   </div>
                                        </div>

                                        <div class="col-lg-7">
                                        <h3><p style="font-size:38px!important">TIME: <span class="simpleDisplay" style="font-size:38px!important"></span></p></h3>
                                        </div>
                          </div>
                          </div>
                          <hr>
<!--  -->
  <div class="container-fluid mt-10">
  <div class="row">
    <div class="col-lg-8">
      <!-- Content for the first column -->
      <div class="card">
        <div class="card-header">
          <!-- Header goes here -->
        </div>
        <div class="card-body">
          <!-- TODO: Load and display the exam questions using AJAX or PHP -->
          <div id="questions-container">
            <!-- Questions will be loaded and displayed here -->
          </div>
          <div id="pieChartContainer" style="display:none"></div> 
          <div id="pagination-container"></div>
          <span id="totalScore"></span>
        </div><!-- end of card-body -->
        <div class="card-footer">
          <!-- Footer content goes here -->
        </div><!-- end of card-footer -->
      </div><!-- end of card -->
    </div><!-- end of col-lg-8 -->

    <div class="col-lg-4">
      <!-- Content for the second column -->
      <div class="card">
        <div class="card-header">
          <!-- Header goes here -->
        </div>
        <div class="card-body">
          <center><div id="chart-container"></div></center>
        </div><!-- end of card-body -->
        <div class="card-footer">
          <!-- Footer content goes here -->
        </div><!-- end of card-footer -->
      </div><!-- end of card -->
    </div><!-- end of col-lg-4 -->

<!-- modals -->

<!-- Modal for Question Image -->
<div class="modal" id="questionImageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Question Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" alt="Question Image" class="img-fluid" id="questionImage">
      </div>
    </div>
  </div>
</div>

<!-- Modal for Option Image -->
<div class="modal" id="optionImageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Option Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" alt="Option Image" class="img-fluid" id="optionImage">
      </div>
    </div>
  </div>
</div>


<!-- end of modals -->

  </div><!-- end of row -->
</div><!-- end of container-fluid -->





<!-- Include the jQuery library -->
<script src="jquery/jquery-3.6.0.min.js"></script>
<script src="highchartsLib/code/highcharts.js"></script>
<script src="highchartsLib/code/modules/accessibility.js"></script>

<script>
$(document).ready(function() {
// Variable to store the selected options
var selectedOptions = {};

function finalSubmission() {
  // Function to display the modal with exam score and information
  var display = $('#timer');
  var chartContainer = $('#chart-container');

      display.text("00:00:00")
      chartContainer.text("Time out!")
  function showModal(response) {
    // Retrieve the exam score and other information from the response
    var totalScore = response.totalScore;
    var skippedQuestions = response.skippedQuestions;
    var incorrectQuestions = response.incorrectQuestions;
    var correctQuestions = response.correctQuestions;

    // Implement your logic to display the modal with the exam score and information
    // You can use a library like Bootstrap Modal or create your own custom modal

    // Example using Bootstrap Modal
    var modalContent = '<div class="modal-dialog modal-lg">' +
      '<div class="modal-content">' +
      '<div class="modal-header">' +
      '<h5 class="modal-title">Exam Score</h5>' + 
      '</div>' +
      '<div class="modal-body">' +
      '<b><p style="font-size:20px !important">Total Score: ' + totalScore + '%</p></b>' +
      '<b><p style="font-size:20px !important">Skipped Questions: ' + skippedQuestions + '</p></b>' +
      '<b><p style="font-size:20px !important">Incorrect Questions: ' + incorrectQuestions + '</p></b>' +
      '<b><p style="font-size:20px !important">Correct Questions: ' + correctQuestions + '</p></b>' +
      '</div>' +
      '<div class="modal-footer">' +
      '<a class="nav-link" href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>' +
      '</div>' +
      '</div>' +
      '</div>';

    // Append the modal HTML to the document body
    $('body').append('<div id="examScoreModal" class="modal">' + modalContent + '</div>');

    // Show the modal
    $('#examScoreModal').modal('show'); 
  }

  // Make an AJAX request to submit the exam
  $.ajax({
    url: 'finalSubmission.php', 
    type: 'POST',
    data: {
      examID: <?php echo $examID; ?>, // Pass the exam ID to the server
      userID: <?php echo $userID; ?>
    },
    dataType: 'json',
    success: function (response) {
      // Handle the success case
      // Display the modal with the exam score and other information 
      $('#pagination-container').hide();
      $('#questions-container').hide();
      // Display the pie chart
      displayPieChart(response);




      showModal(response);
    },
    error: function () {
      // Handle the error case
      alert('An error occurred. Please try again.');
    }
  });
//calls fnction to execute users who are submitting exam
  logScriptExecution() 
}//end of final submission


// Function to log script execution in script_execution_log table
function logScriptExecution() {
    // Make an AJAX request to store execution information in script_execution_log
    $.ajax({
        url: 'storeScriptExecution.php', // Replace with the actual PHP script to handle the storage
        method: 'POST',
        dataType: 'json',
        data: {
            // Include relevant information for logging (exam_id, user_id, etc.)
            exam_id:<?php echo $examID; ?>, // Assuming you have an input with id 'examId' for the exam ID
            user_id: <?php echo $userID; ?> , // Assuming you have an input with id 'userId' for the user ID
        },
        success: function (response) {
            // Handle success response if needed
            
            if (response.status){
              console.log(response.message);
            }
        },
        error: function (xhr, status, error) {
            // Handle error response if needed
            console.error('Error storing script execution information:', error);
        },
    });
}// end of logScriptExecution

function displayPieChart(data) {
  // Extract the data for the pie chart
  var totalScore = data.totalScore;
  var correctQuestions = data.correctQuestions;
  var incorrectQuestions = data.incorrectQuestions;
  var skippedQuestions = data.skippedQuestions;

  // Create the data array for the pie chart
  var pieData = [
    {
      name: 'Correct',
      y: correctQuestions,
      color: 'green'
    },
    {
      name: 'Incorrect',
      y: incorrectQuestions,
      color: 'red'
    },
    {
      name: 'Skipped',
      y: skippedQuestions
    }
  ];

  // Create the options for the pie chart
  var pieOptions = {
    chart: {
      type: 'pie'
    },
    title: {
      text: 'Exam Results'
    },
    plotOptions: {
      pie: {
        dataLabels: {
          enabled: true,
          format: '{point.name}: {point.y}'
        }
      }
    },
    series: [
      {
        name: 'Questions',
        data: pieData
      }
    ]
  };

  // Render the pie chart using Highcharts
  Highcharts.chart('pieChartContainer', pieOptions);

  // Display the total score
  $('#totalScore').html('<b style="font-size:30px">Total Score: ' + totalScore + '%</b>');

  // Show the pie chart container
  $('#pieChartContainer').show();
}
    

// Function to submit the exam and store the selected options
function submitExam() {
  // Convert the selectedOptions object to JSON
  var selectedOptionsJSON = JSON.stringify(selectedOptions);

  // Send an AJAX request to the server to store the selected options
  $.ajax({
    type: 'POST',
    url: 'submit_exam.php',
    data: { selectedOptions: selectedOptionsJSON, examID: <?php echo $examID; ?>},
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        console.log('Selected options stored successfully');
      } else {
        console.error('An error occurred while storing selected options');
      }


    },
    error: function(xhr, status, error) {
      console.error('An error occurred. Please try again.');
    }
  });
}

var userID = <?php echo $userID; ?>;
var userUniqueKey = "selectedOptions_" + userID;

// Add this block of code at the beginning of your script
var selectedOptions = JSON.parse(localStorage.getItem(userUniqueKey)) || {};
var currentPage = 0; // Current page index
var questions = []; // Array to store questions

// Placeholder for getOptionLabel function
function getOptionLabel(index) {
  return String.fromCharCode(65 + index); // ASCII code for 'A' is 65
}

// Add a new function for retrieving selected options
function retrieveSelectedOptions(questions, callback) {
  // Get the current active user ID 
  var userId = <?php echo $userID; ?>

  // Check if the user ID is available
  if (userId) {
    $.ajax({
      url: 'retrieve_selected_options.php',
      method: 'POST',
      data: { userId: userId },
      dataType: 'json',
      success: function (data) {
        if (Array.isArray(data)) {
          // Process the data and map it to the structure expected by displayQuestion
          var selectedOptions = {};
          data.forEach(function (item) {
            selectedOptions[item.question_id] = [item.selected_option];
            selectedOptions[item.user_exam_id] = [item.selected_option];
          });
          callback(selectedOptions);
        } else if (typeof data === 'object') {
          // If data is an object, handle it accordingly
          callback(data);
        } else {
          // Handle other cases or log an error
          console.error('Invalid data format in retrieveSelectedOptions');
          callback({});
        }
      },
      error: function (xhr, status, error) {
        console.error('Error retrieving selected options: ' + error);
        callback({});
      }
    });
  } else {
    console.error('User ID not available.'); 
    callback({});
  }
}



// Modify loadQuestions Function
function loadQuestions(page) {
  // First, retrieve questions
  $.ajax({
    url: 'get_questions.php',
    type: 'GET',
    data: {
      examID: <?php echo $examID; ?>,
      page: page
    },
    dataType: 'json',
    success: function (response) {
      if (response.status === 'success') {
        questions = response.questions;

                 // Display the completion message if available
    if (questions.message) {
          displayCompletionMessage(questions.message);
          return;
        }

        // Display the current question with selected options
        displayQuestion(questions[currentPage], selectedOptions);

        // Update the pagination buttons
        updatePagination(page);

        // Then, retrieve selected options for the current set of questions
        retrieveSelectedOptions(questions, function(selectedOptions) {
          // Do any additional processing if needed
        });
      } else {
        // Display an error message
        alert('Failed to retrieve questions.');
      }
    },
    error: function () {
      alert('An error occurred while retrieving questions.');
    }
  });
}

// Function to display the completion message
function displayCompletionMessage(message) {
  var questionsContainer = $('#questions-container');
  var completionMessage = $('<p>').addClass('completion-message');
  completionMessage.html('<strong style="color:red; font-size:18px">' + message + '</strong>');
  questionsContainer.empty().append(completionMessage);
  // Optionally, you can disable the next/previous buttons here
  $('#pagination-container button').prop('disabled', true);
}


function displayQuestion(question, selectedOptions) {

// Decrypt or deobfuscate the answer
var decryptedAnswer = atob(question.answer);

// console.log('Question:', question);
//console.log('Options Length:', decryptedAnswer.length);

var questionsContainer = $('#questions-container');
questionsContainer.empty(); // Clear the questions container

// Display the current page
var currentPageElement = $('<p>').addClass('current-page');
currentPageElement.text('QUESTION: ' + (currentPage + 1) + ' of ' + questions.length);
questionsContainer.append(currentPageElement);

// Create the question container
var questionContainer = $('<div>').addClass('question-container mb-4 font-weight-bold text-lg');
var questionText = $('<h3>').addClass('question-text');
questionText.text(question.question);

// Check if there's an image question
if (question.image_ques) {
  // Create the image element for the question
  var questionImage = $('<img>').addClass('question-image view-question-image-btn');
  questionImage.attr('src', 'admin/' + question.image_ques);
  questionImage.attr('width', 100 + 'px');
  questionImage.attr('height', 100 + 'px');
  questionContainer.append(questionImage);
}



// Create the options container
var optionsContainer = $('<div>').addClass('options-container');

// Iterate over the options and create the appropriate input elements
for (var j = 0; j < question.options.length; j++) {
  var option = question.options[j];

    // Determine the input type based on the number of options
var inputType = decryptedAnswer.length > 1 ? 'checkbox' : 'radio';
//console.log('Input Type:', inputType);

  // Create the input element (radio or checkbox) based on the determined input type
  var inputElement = $('<br><input>').addClass('option-input').attr({
    type: inputType,
    name: 'question',
    value: option.option_id
  });

  // Set the data-question-id attribute to capture the question ID
  inputElement.attr('data-question-id', question.id);

  // Create the label for the input element with the option label (A, B, C, D, ...)
  var label = $('<label>').text('(' + getOptionLabel(j) + ') ' + option.option_text);

  // Check if there's an image option
  if (option.option_image_path) {
    // Create the image element for the option
    var optionImage = $('<img>').addClass('option-image view-option-image-btn');
    optionImage.attr('src', 'admin/' + option.option_image_path);
    optionImage.attr('width', 100 + 'px');
    optionImage.attr('height', 100 + 'px');
    optionsContainer.append(optionImage);
  }

  // Append the input element and label to the options container
  optionsContainer.append(inputElement);
  optionsContainer.append(label);

  // Check if the option is selected in the retrieved data
  if (selectedOptions[question.id] && selectedOptions[question.id].includes(option.option_id)) {
    inputElement.prop('checked', true);
  }
}

// Append the question text and options container to the question container
questionContainer.append(questionText);
questionContainer.append(optionsContainer);

// Append the question container to the questions container
questionsContainer.append(questionContainer); 

// Handle the click event for the "View Question Image" button using event delegation
$('#questions-container').on('click', '.view-question-image-btn', function () {
  var imagePath = $(this).attr('src');
  $('#questionImage').attr('src', imagePath);
  $('#questionImageModal').modal('show');
});

// Handle the click event for the "View Option Image" button using event delegation
$('#questions-container').on('click', '.view-option-image-btn', function () {
  var imagePath = $(this).attr('src');
  $('#optionImage').attr('src', imagePath);
  $('#optionImageModal').modal('show');
});

// Add event listener to input elements to handle option selection
$(document).on('change', 'input.option-input', handleOptionSelection);
}



// Modify handleOptionSelection Function
function handleOptionSelection() {
  var questionId = $(this).attr('data-question-id');
  var selectedOption = $(this).val();

  if (!selectedOptions.hasOwnProperty(questionId)) {
    // If the questionId is not present in the selectedOptions object,
    // create a new entry with an array to hold multiple options for checkboxes
    selectedOptions[questionId] = [];
  }

  if ($(this).attr('type') === 'radio') {
    // For radio buttons, there's only one selected option, so assign directly
    selectedOptions[questionId] = [selectedOption];
  } else if ($(this).attr('type') === 'checkbox') {
    // For checkboxes, we need to gather all selected options and store them in an array
    var selectedOptionsArray = [];

    $('input.option-input[data-question-id="' + questionId + '"]:checked').each(function() { 
      selectedOptionsArray.push($(this).val());
    });

    selectedOptions[questionId] = selectedOptionsArray;
  }

  localStorage.setItem(userUniqueKey, JSON.stringify(selectedOptions));

  // Call the submitExam function here to save the updated selectedOptions
  submitExam();
}

// Function to clear stored selected options in local storage
function clearSelectedOptions() {
  // Remove the key's details
  localStorage.removeItem(userUniqueKey);
}

// On clicking the logout buttons, remove and clear key's record in local storage
//$(document).on('click', '#logout', clearSelectedOptions);

// Modify updatePagination Function
function updatePagination(page) {
  var paginationContainer = $('#pagination-container');
  paginationContainer.empty(); // Clear the pagination container

  // Check if questions array is defined
  if (questions && questions.length > 0) {
    // Create the pagination text (e.g., "1 of 10")
    var paginationText = $('<p>').addClass('pagination-text');
    paginationText.text('QUESTION: ' + (page + 1) + ' of ' + questions.length);
    paginationContainer.append(paginationText);

    // Create the previous button
    var previousButton = $('<button>').addClass('btn btn-primary mr-2');
    previousButton.text('Previous');
    if (page === 0) {
      previousButton.prop('disabled', true);
    } else {
      previousButton.click(function () {
        currentPage--;
        displayQuestion(questions[currentPage], selectedOptions);
        updatePagination(currentPage);
      });
    }

    // Create the next button
    var nextButton = $('<button>').addClass('btn btn-primary');
    nextButton.text('Next');
    if (page === questions.length - 1) {
      nextButton.prop('disabled', true);
    } else {
      nextButton.click(function () {
        currentPage++;
        displayQuestion(questions[currentPage], selectedOptions);
        updatePagination(currentPage);
      });
    }

    // Append the buttons to the pagination container
    paginationContainer.append(previousButton);
    paginationContainer.append(nextButton);
  }
}

// Load and display the exam questions
loadQuestions(currentPage);






// Function to initialize exam timer
function initializeExamTimer() {
    // Check if the exam has started
    $.ajax({
        url: 'getRemainingTime.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.remainingTime === null) {
                // Exam not started, initialize timer to 10 minutes
                var durationInSeconds = <?php echo $duration * 60; ?>;
                startExamTimer(durationInSeconds);
            } else {
                // Exam already started, load remaining time
                startExamTimer(response.remainingTime);
            }
        },
        error: function (error) {
            console.error('Error checking exam status:', error);
        }
    });
}

// Function to start and update the timer with the specified chart options
function startExamTimer(initialTime) {
    var remainingTime = initialTime ; // Convert to seconds
    var chartContainer = $('#chart-container');
    var display = $('#timer');
    var  alertShown = false;
    // Use the provided chart options
    var chartOptions = {
        chart: {
            type: 'pie',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Time Remaining'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>',
            style: {
                fontSize: '34px' // Adjust the font size as desired
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}'
                },
                innerSize: '70%',
            }
        },
        series: [{
            name: 'Time',
            colorByPoint: true,
            data: [{
                name: 'Hours',
                y: 0
            }, {
                name: 'Minutes',
                y: 0
            }, {
                name: 'Seconds',
                y: 0
            }]
        }]
    };

    // Create the doughnut chart
    var chart = Highcharts.chart('chart-container', chartOptions); // Create the doughnut chart

    // Update remaining time every second
    var timerInterval = setInterval(function () {
        // Update Highcharts data
        var chartData = [{
            name: 'Hours',
            y: Math.floor(remainingTime / 3600)
        }, {
            name: 'Minutes',
            y: Math.floor((remainingTime % 3600) / 60)
        }, {
            name: 'Seconds',
            y: remainingTime % 60
        }];

        chart.series[0].setData(chartData);

        // Update remaining time on the server
        $.ajax({
            url: 'updateRemainingTime.php',
            method: 'POST',
            data: { remaining_time: remainingTime },
            dataType: 'json',
            success: function (response) {
                //console.log(response);
            },
            error: function (error) {
                console.error('Error updating remaining time:', error);
            }
        });

     

        var hours = Math.floor(remainingTime / 3600);
        var minutes = Math.floor((remainingTime % 3600) / 60);
        var seconds = remainingTime % 60;

        chart.series[0].setData([
            { name: 'Hours', y: hours },
            { name: 'Minutes', y: minutes },
            { name: 'Seconds', y: seconds }
        ]);

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        display.text(hours + ':' + minutes + ':' + seconds);

        $(".simpleDisplay").text(hours + ':' + minutes + ':' + seconds);

  // Check if remaining time is less than 300 seconds and the alert hasn't been shown
  if (remainingTime <= 300 && !alertShown) {
        $(".simpleDisplay").toggleClass("blink-red");
        alertShown = true; // Set the flag to true so that the alert won't show again
        // Uncomment the lines below if you want to use SweetAlert instead of the browser's alert
        Swal.fire({
          title: "Time Alert",
          text: "Less than 5 minutes remaining!",
          icon: "warning",
          button: "OK",
        });
        
      }

           // Check if time has run out
           if (remainingTime <= 0) {
          clearInterval(timerInterval);
            finalSubmission();
            display.text('00:00:00');
            $(".simpleDisplay").text('00:00:00');
        } else {
            remainingTime--;
        }

    }, 1000);
}


// Call the function to initialize exam timer
initializeExamTimer();


  // Handle the final submit exam button click event
  $('#submit-exam-button').click(function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Confirm before submitting the exam
    Swal.fire({
                   title: 'Are You Sure You Want To Submit Exam?',
                   html: '<img src="img/quickTest.png"  height="50" width="50">',
                   icon: 'question',
                   showCancelButton: true,
                   confirmButtonColor: 'darkGreen',
                   cancelButtonColor: 'darkRed',
                   confirmButtonText: 'Yes, Submit!',
                   showLoaderOnConfirm: true,
               }).then((result) => {
                       if (result.isConfirmed)
                          {
                                 finalSubmission();
                                 //clearSelectedOptions()
                           }
                       });//end of thenables
});//end of click event


});



  
</script>



  
  <script src="bootstrap_v4/js/bootstrap.min.js"></script>
  
</body>
</html>
