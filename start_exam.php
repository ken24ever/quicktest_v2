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
          <a class="nav-link" href="dashboard.php"><button  class="btn btn-info">Go Back To Dashboard</button> <span class="sr-only">(current)</span></a>
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
  <div class="modal-dialog" role="document">
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
  <div class="modal-dialog" role="document">
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
  function showModal(response) {
    // Retrieve the exam score and other information from the response
    var totalScore = response.totalScore;
    var skippedQuestions = response.skippedQuestions;
    var incorrectQuestions = response.incorrectQuestions;
    var correctQuestions = response.correctQuestions;

    // Implement your logic to display the modal with the exam score and information
    // You can use a library like Bootstrap Modal or create your own custom modal

    // Example using Bootstrap Modal
    var modalContent = '<div class="modal-dialog">' +
      '<div class="modal-content">' +
      '<div class="modal-header">' +
      '<h5 class="modal-title">Exam Score</h5>' +
      '</div>' +
      '<div class="modal-body">' +
      '<p>Total Score: ' + totalScore + '%</p>' +
      '<p>Skipped Questions: ' + skippedQuestions + '</p>' +
      '<p>Incorrect Questions: ' + incorrectQuestions + '</p>' +
      '<p>Correct Questions: ' + correctQuestions + '</p>' +
      '</div>' +
      '<div class="modal-footer">' +
      '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>' +
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
}

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

function displayQuestions(questions, currentPage, totalPages) {
  var questionsContainer = $('#questions-container');
  questionsContainer.empty(); // Clear the questions container

  // Display the current page
  var currentPageElement = $('<p>').addClass('current-page');
  currentPageElement.text('QUESTION: ' + currentPage + ' of ' + totalPages);
  questionsContainer.append(currentPageElement);

  // Retrieve the selected options from the server
  $.ajax({
    url: 'retrieve_selected_options.php',
    method: 'POST',
    dataType: 'json',
    success: function(data) {
      // Function to get option label by index (0 = A, 1 = B, 2 = C, etc.)
      function getOptionLabel(index) {
        return String.fromCharCode(65 + index); // ASCII code for 'A' is 65
      }

      // Iterate over the questions and create the HTML elements
      for (var i = 0; i < questions.length; i++) {
        var question = questions[i];
        var questionNumber = i + 1;
        var correctAnswerSize = question.answer.length;

        // Create the question container
        var questionContainer = $('<div>').addClass('question-container mb-4 font-weight-bold text-lg');

        // Create the question text
        var questionText = $('<p>').addClass('question-text');
        questionText.text(question.question);

        // Create the options container
        var optionsContainer = $('<div>').addClass('options-container');

        // Check if there's an image question
        if (question.image_ques) {
          // Create the image element for the question
          var questionImage = $('<img>').addClass('question-image view-question-image-btn');
          questionImage.attr('src', 'admin/' + question.image_ques);
          questionImage.attr('width', 100 + 'px');
          questionImage.attr('height', 100 + 'px');
          questionContainer.append(questionImage);
        }

        // Iterate over the options and create the appropriate input elements
        for (var j = 0; j < question.options.length; j++) {
          var option = question.options[j];
          var inputType = 'radio'; // Default to radio buttons

          // Change to checkboxes if the correctAnswerSize is greater than one
          if (correctAnswerSize > 1) {
            inputType = 'checkbox';
          }

          // Create the input element (radio or checkbox)
          var inputElement = $('<br><input><span style="padding:2px !important"></span>').addClass('option-input').attr({
            type: inputType,
            name: 'question' + questionNumber,
            value: option.option_id
          });

          // Set the data-question-id attribute to capture the question ID
          inputElement.attr('data-question-id', question.id);

          // Create the label for the input element with the option label (A, B, C, D, ...)
          var label = $('<label>').text('('+ getOptionLabel(j) + ')' + '. ' + option.option_text);

          // Check if there's an image option
          if (option.option_image_path) {
            // Create the image element for the option
            var optionImage = $('<br><img>').addClass('option-image view-option-image-btn');
            optionImage.attr('src', 'admin/' + option.option_image_path);
            optionImage.attr('width', 100 + 'px');
            optionImage.attr('height', 100 + 'px');
            optionsContainer.append(optionImage);
          }

          // Append the input element and label to the options container
          optionsContainer.append(inputElement);
          optionsContainer.append(label);

          // Check if the option is selected in the retrieved data
          if (data[question.id] && data[question.id].includes(option.option_id)) {
            inputElement.prop('checked', true);
          }
        }

        // Append the question text and options container to the question container
        questionContainer.append(questionText);
        questionContainer.append(optionsContainer);

        // Append the question container to the questions container
        questionsContainer.append(questionContainer);
      }
    },
    error: function(xhr, status, error) {
      // Handle the error case
      console.error('Error: ' + error);
    }
  });

  // Handle the click event for the "View Question Image" button using event delegation
  $('#questions-container').on('click', '.view-question-image-btn', function() {
    var imagePath = $(this).attr('src');
    $('#questionImage').attr('src', imagePath);
    $('#questionImageModal').modal('show');
  });

  // Handle the click event for the "View Option Image" button using event delegation
  $('#questions-container').on('click', '.view-option-image-btn', function() {
    var imagePath = $(this).attr('src');
    $('#optionImage').attr('src', imagePath);
    $('#optionImageModal').modal('show');
  });
}


// Add event listener to input elements to handle option selection
$(document).on('change', 'input.option-input', handleOptionSelection);


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

  // Call the submitExam function here to save the updated selectedOptions
  submitExam();
}





 // Function to load and display the exam questions
function loadQuestions(page) {
  $.ajax({
    url: 'get_questions.php',  
    type: 'GET',
    data: {
      examID: <?php echo $examID; ?>,
      page: page
    },
    dataType: 'json',
    success: function(response) {
       // console.log(response)
      if (response.status === 'success') {
        var questions = response.questions;
        var currentPage = page; // Use the provided page parameter
        var totalPages = response.totalPages;

        // Update the pagination buttons
        updatePagination(currentPage, totalPages);

          // Display the questions and total pages
          displayQuestions(questions, currentPage, totalPages);

        // Update the pagination buttons again (to handle the case when there are no questions on the last page)
       // updatePagination(currentPage, totalPages);
      } else {
        alert('Failed to retrieve questions.');
      }
    },
    error: function() {
      alert('An error occurred while retrieving questions.');
    }
  });
}

// Function to update the pagination buttons
function updatePagination(currentPage, totalPages) {
  var paginationContainer = $('#pagination-container');
  paginationContainer.empty(); // Clear the pagination container

  // Create the pagination text (e.g., "1 of 50")
  var paginationText = $('<p>').addClass('pagination-text');
  paginationText.text('QUESTION: ' + currentPage + ' of ' + totalPages);
  paginationContainer.append(paginationText);

  // Create the previous button
  var previousButton = $('<button>').addClass('btn btn-primary mr-2');
  previousButton.text('Previous');
  if (currentPage === 1) {
    previousButton.prop('disabled', true);
  } else {
    previousButton.click(function() {
      loadQuestions(currentPage - 1);
    });
  }

  // Create the next button
  var nextButton = $('<button>').addClass('btn btn-primary');
  nextButton.text('Next');
  if (currentPage === totalPages) {
    nextButton.prop('disabled', true);
  } else {
    nextButton.click(function() {
      loadQuestions(currentPage + 1);
    });
  }

  // Append the buttons to the pagination container
  paginationContainer.append(previousButton);
  paginationContainer.append(nextButton);
}




  // Load and display the exam questions
  loadQuestions(1);
 
// Function to start the timer
function startTimer(startTime, duration, display) {
  var startTimestamp = Math.floor(Date.parse(startTime) / 1000); // Convert start time to timestamp
  var endTimestamp = startTimestamp + duration; // Calculate end timestamp

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

  var chart = Highcharts.chart('chart-container', chartOptions); // Create the doughnut chart

  var interval = setInterval(function() {
    var currentTimestamp = Math.floor(Date.now() / 1000); // Get current timestamp
    var remainingTime = endTimestamp - currentTimestamp; // Calculate remaining time in seconds

    if (remainingTime < 0) {
      clearInterval(interval);
      // Automatically submit the exam when the timer reaches 0
      finalSubmission();
      display.text("00:00:00"); // Set the timer display to 00:00:00
      $(".simpleDisplay").text("00:00:00");
      return;
    }

    var hours = Math.floor(remainingTime / 3600);
    var minutes = Math.floor((remainingTime % 3600) / 60);
    var seconds = remainingTime % 60;

    // Update the doughnut chart data
    chart.series[0].setData([{
      name: 'Hours',
      y: hours
    }, {
      name: 'Minutes',
      y: minutes
    }, {
      name: 'Seconds',
      y: seconds
    }]);

    // Add leading zeros if necessary
    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    // Update the timer display
    display.text(hours + ":" + minutes + ":" + seconds);
    $(".simpleDisplay").text(hours + ":" + minutes + ":" + seconds);

  // Check if remaining time is less than 3 minutes (180 seconds)
  if (remainingTime <= 180) {
      // Toggle the blinking effect by adding/removing the 'blink-red' class
      $(".simpleDisplay").toggleClass("blink-red");

      //alert("Time is less than 3 minutes!")
    }



  }, 1000);
}

// Start the timer
var startTimeString = '<?php echo $startTimeString ; ?>';
var durationInSeconds = <?php echo $duration * 60; ?>;
var display = $('#timer');
startTimer(startTimeString, durationInSeconds, display);

  // Handle the submit exam button click event
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
                           }
                       });//end of thenables
});//end of click event


});



  
</script>



  
  <script src="bootstrap_v4/js/bootstrap.min.js"></script>
  
</body>
</html>
