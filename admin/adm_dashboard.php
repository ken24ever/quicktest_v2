<?php
session_start();

// Check if the user is logged in and has the Super Admin access level
if (!isset($_SESSION['user_id']) /* || !isset($_SESSION['access_level']) || $_SESSION['access_level'] !== 1 */) {
    // Redirect to the login page if not authenticated or authorized
    header("Location: index.php");
    exit();
}
else
{
  $fullNames = $_SESSION['user_name'];
$userID = $_SESSION['user_id']; 
}

?>
 
<!DOCTYPE html>
<html>
<head>
	<title>CBT Application</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../bootstrap_v4/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png">
  
   <!-- toast styling effect -->
   <link rel="stylesheet" href="node_modules/toastify-js/src/toastify.css" />
    

	<!-- jquery library -->
	<script src="jquery/jquery-3.6.0.min.js"></script>


	<!-- select2 library -->
	<link rel="stylesheet" href="node_modules/select2/dist/css/select2.min.css">
	<script src="node_modules/select2/dist/js/select2.min.js"></script>

  <!-- worksheet js api lib -->
  <script src="sheetjs/dist/xlsx.full.min.js"></script>

   <!-- sweet  alert 2 lib -->
   <link rel="stylesheet" href="datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <!-- sweet  alert 2 lib -->
  <link rel="stylesheet" href="../sweetalert2/dist/sweetalert2.min.css">
<script src="../sweetalert2/dist/sweetalert2.all.min.js"></script>

	
   <!-- DATE PICKER BOOTSTRAP -->
   <link rel="stylesheet" href="node_modules/select2/dist/css/select2.min.css">
	<script src="node_modules/select2/dist/js/select2.min.js"></script>
 


	<!-- import all custom js scripts -->
  <script src="js/usersBatchUpload.js"></script>
 <script src="js/fetchQues.js"></script>
    <script src="js/addUser.js"></script>
	<script src="js/search_users.js"></script>
	<script src="js/add_exam.js"></script>
	<script src="js/get_manage_exams.js"></script>
	<script src="js/addImageExams.js"></script>
	<script src="js/add_admin.js"></script>
  <script src="js/analysisExam.js"></script>
  <script src="js/dataRecovery.js"></script>
 <!--  <script src="js/sse.js"></script> -->

<!-- highchart lib -->
<script src="../highchartsLib/code/highcharts.js"></script>
<script src="../highchartsLib/code/modules/accessibility.js"></script>



  <!-- JQUERY SCRIPTS to track all event handlers upon clicking their respective buttons -->
<script>

  // ...

  $(document).ready(function() {
  // ...

  $('#addUsersThruForm,#largeDATA,#searchUserButton,#edit-user-btn').on('click', function() {
    // ...
        
    var names = $('#names').val();
    var editUsername = $('#edit-name').val();
    var searchUsername = $('#searchUsername').val();
    var user_batch_file = $('#user_batch_file').val();
    var description = ""; // Initialize description as an empty string

    // Check if the 'names' field is empty or not
    if (names === "") {
      description = 'User name field was empty when logged in user: (' + <?php echo json_encode($fullNames); ?> + ') clicked the submit button';
    } else {
      description = 'Logged in admin user: (' + <?php echo json_encode($fullNames); ?> + ') created this record with the name of: "' + names + '"';
    }

    // Now, prepare the data to be sent in the AJAX request
    var requestData = {
      names: names,
      editUsername: editUsername,
      user_batch_file: user_batch_file,
      searchUsername: searchUsername,
      description: description // Include the description in the request data
    };

        // Show loader while waiting for AJAX response
        showLoader();

    $.ajax({
      url: 'addUserThruForm.php',
      method: 'POST',
      dataType: 'json',
      data: requestData,
      success: function(response) {
        // ...
                    // Hide loader after AJAX response is received
                    hideLoader();
        if (response.success) {
          Toastify({
            text: response.message,
            duration: 5000,
            gravity: 'top',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
        } else {
          Toastify({
            text: response.message,
            duration: 5000,
            gravity: 'top',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
        }

      },
      error: function(xhr, status, error) {
        console.error('Error: ' + error);
           // Hide loader in case of an error
           hideLoader();
      }
    });
  });

  // ...
});

</script>


	<script>
$(document).ready(function() {

// Function to handle image preview and resize
function readImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      // Create an image element
      var img = document.createElement('img');
      img.onload = function() {
        // Create a canvas element to resize the image
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');

        // Set the canvas dimensions to the desired 80x80 size
        canvas.width = 80;
        canvas.height = 80;

        // Calculate the scale factor for resizing
        var scaleFactor = Math.min(80 / img.width, 80 / img.height);

        // Calculate the new width and height after resizing
        var newWidth = img.width * scaleFactor;
        var newHeight = img.height * scaleFactor;

        // Draw the image on the canvas with the new dimensions 
        ctx.drawImage(img, 0, 0, newWidth, newHeight);

        // Create a new image element with the resized image as the source
        var resizedImg = document.createElement('img');
        resizedImg.src = canvas.toDataURL();

        // Append the resized image element to the preview container
        $('#imagePreview').empty().append(resizedImg);
      };

      // Set the source of the image element to the data URL
      img.src = e.target.result;
    };

    // Read the selected image file as a data URL
    reader.readAsDataURL(input.files[0]);
  }
}

// Event listener for the userPassport input field change event
$('#userPassport').on('change', function() {
  readImage(this); // Call the readImage function with the selected input element
});


  $('#addUserForm').submit(function(e) {
    e.preventDefault(); // prevent default form submit behavior

    // Check if any input or select fields are empty
    var emptyFields = $(this).find('input, select').filter(function() {
      var value = $(this).val();
      return !value || $.trim(value) === '';
    });

    // If any fields are empty, display an error message
    if (emptyFields.length > 0) {
      Toastify({
        text: "Please Fill In All The Required Fields!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
    } else {
      // Validate user passport image format and size
      var userPassportInput = $('#userPassport')[0];
      var userPassportFile = userPassportInput.files[0];

      if (userPassportFile) {
        var allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
        var maxSize = 2 * 1024 * 1024; // 2MB in bytes

        if (allowedFormats.indexOf(userPassportFile.type) === -1) {
          Toastify({
            text: "Please upload a valid image in JPEG, PNG, or GIF format.",
            duration: 5000,
            gravity: 'top',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
          return;
        }

        if (userPassportFile.size > maxSize) {
          Toastify({
            text: "Please upload an image with a maximum size of 2MB.",
            duration: 5000,
            gravity: 'top',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
          return;
        }
      } 

      // Create a new FormData object to handle file upload
      var formData = new FormData(this);

      $.ajax({
        url: 'add_user.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // handle success response 
          console.log(response);
          Toastify({
            text: response,
            duration: 5000,
            gravity: 'bottom',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
          $('#addUserForm')[0].reset();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // handle error response
          console.log(textStatus, errorThrown);
        }
      });
    }
  });
});

	</script>
  <script src="js/batchQuestions.js"></script>

	<style>
/* .image-preview {
  width: 60px;
  height: 60px;
  overflow: hidden;
}

.image-preview img {
  width: 100%;
  height: auto;
  transition: transform 0.3s ease;
} */

.scroll-container {
  overflow-x: scroll;
  overflow-y: hidden;
  white-space: nowrap;
}

/* styling for all rectangular image in each module */
#addUsers{
  height: 50%; 
}

#addUsers img {
  height: 30% !important; 
  width: 100%  !important;
}
#searchUser{
  height: 50%; 
}

#searchUser img {
  height: 30% !important; 
  width: 100%  !important;
}

#addExams{
  height: 50%; 
}

#addExams img {
  height: 30% !important; 
  width: 100%  !important;
}

#manageExams{
  height: 50%; 
}

#manageExams img {
  height: 30% !important; 
  width: 100%  !important;
}

#editQuestionsSection{
  height: 50%; 
}
#editQuestionsSection img {
  height: 30% !important; 
  width: 100%  !important;
}

#generateReports {
  height: 50%;
}

#generateReports img {
  height: 30% !important; 
  width: 100%  !important;
}

#audit_tray {
  height: 50%;
}

#audit_tray img {
  height: 30% !important; 
  width: 100%  !important;
}

#create_admin{
  height: 50%; 
}
#create_admin img {
  height: 30% !important; 
  width: 100%  !important;
}

@keyframes heartbeat {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
}

.container img {
  animation: heartbeat 30s ease-in-out infinite;
  animation-iteration-count: 1;
}

#pagination {
  margin-top: 20px;
  text-align: center;
}

#pagination a {
  display: inline-block;
  padding: 5px 10px;
  margin-right: 5px;
  border: 1px solid #ccc;
  background-color: #f5f5f5;
  color: #333;
  text-decoration: none;
}

#pagination a.active {
  background-color: #007bff;
  color: #fff;
}


      /* Define the heartbeat animation */
      @keyframes logo {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }

  /* Apply the heartbeat animation to the image */
  .heartbeat-image {
    animation: logo 4s infinite;
  }

  /* Add CSS for the collapsible effect */
.exam-status-container {
  position: relative;
}

.exam-status-content {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 5px;
  z-index: 1;
}

/* progress bar styling */
#myProgress {
  width: 40%;
  background-color: #ddd;
  border-radius: 15px !important;
}

#myBar {
  width: 10%; /* Change this to a higher initial value, like 10% */
  height: 30px;
  background-color: #04AA6D;
  transition: background-color 0.5s; /* Add transition for background-color */
}

#tooltip, #peakLevel {
  display: none;
  position: absolute;
  background-color: red;
  color: white;
  padding: 8px;
  border-radius: 5px;
  top: 10px; /* Adjust based on your layout */
  left: 50%; /* Adjust based on your layout */
  transform: translateX(-50%);
}



	</style>

<style>
.accordion {
  background-color: #eee;
  color: green;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border-left: 1px double hsl(0, 1%, 85%) !important;
  border-right: 1px double hsl(0, 1%, 85%) !important;
  border-top: 1px double hsl(0, 1%, 85%) !important;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}
.active_pane, .accordion:hover {
  background-color: #ccc;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active_pane:after {
  content: "\2212";
}

.panel_base {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow:auto;
  transition: max-height 0.2s ease-out;
}

/* data recovery style stays here */


.search_container {
   font-family: Arial, sans-serif;
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

.search-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
}

input, button {
    padding: 10px;
    font-size: 14px;
}

button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
}

#searchResults {
    margin-top: 20px;
}

/* loader style sheet */
.loader {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


</style>

	<script src="FileSaver.js/dist/FileSaver.js"></script>
	<!-- script toggle -->
	
</head>
<body>
<!-- toast effect -->
<script src="node_modules/toastify-js/src/toastify.js"></script>




<!-- Add your HTML markup here -->
<!-- Navbar -->
<nav class="navbar navbar-expand-md bg-white navbar-dark">
  <a class="navbar-brand text-dark" href="#"><img src="../img/quickTest.png" alt="" width="60" height="60" class="heartbeat-image"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
  <ul class="navbar-nav ml-auto"> <!-- Added 'ml-auto' class -->
 <!--  <li class="nav-item">
        <a class="nav-link text-dark" href="#"> <b> Permission Duration: <?php echo $_SESSION['exp_data']; ?> </b> </a>
      </li>  -->
  <li class="nav-item">
        <a class="nav-link text-dark" href="#"> <b> Welcome, <?php echo $_SESSION['user_name']; ?> </b> </a>
      </li>  
    
      <li class="nav-item">
        <a class="nav-link text-dark" href="logout.php"> <b>Logout</b> </a>
      </li>    
    </ul>
  </div>
</nav>

<div class="container mt-5">
<!-- Message alert section for threshold -->
<div id="tooltip">Active users exceeded 60% threshold!</div>
         <div id="peakLevel"></div>

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="#addUser" data-toggle="tab" class="nav-link active">Add User</a>
		</li>
		<li class="nav-item">
			<a href="#searchUser" data-toggle="tab" class="nav-link">Search User</a>
		</li>
		<li class="nav-item">
			<a href="#addExam" data-toggle="tab" class="nav-link">Add Exam</a>
		</li>
		<li class="nav-item">
			<a href="#manageExam" data-toggle="tab" class="nav-link">Manage Exam</a>
		</li>
		<li class="nav-item">
			<a href="#editQuestion" data-toggle="tab" class="nav-link">Edit Text Questions</a>
		</li>
		<li class="nav-item">
			<a href="#report" data-toggle="tab" class="nav-link">Report Generation</a>
		</li>
    <?php
       if ($_SESSION['access_level'] === 1 ){
       echo ' <li class="nav-item">
        <a href="#audit" data-toggle="tab" class="nav-link">Audit Trail</a>
      </li>';
       }
    ?>
    <?php
       if ($_SESSION['access_level'] === 1 ){
       echo ' <li class="nav-item">
       <a href="#createAccessLevel" data-toggle="tab" class="nav-link">Create Admin User(s)</a>
     </li>';
       }
    ?>
   
	</ul>
	<div class="tab-content mt-3">
		<div id="addUser" class="tab-pane active">
		
			<!-- Add the form for adding user here -->
				<div id="addUsers"><img src="img/add_Users.png" alt="" class="img-fluid img-thumbnail">	</div>				
				<hr>
   							 <form id="addUserForm" enctype="multipart/form-data">
                  <h3>Fill The Form </h3> 
								<div class="form-group">
           							 			<label for="Fullname:">Fullname:<b style="color:red; font-size:12px">*</b></label>
           							 				<input type="text" class="form-control" id="names" name="names" placeholder="Enter Name"  >
									 </div>

       								 <div class="form-group">
           							 			<label for="username_">Username:<b style="color:red; font-size:12px">*</b></label>
           							 				<input type="text" class="form-control" id="username" name="username" placeholder="Enter username"  >
									 </div>
        							<div class="form-group">
            									<label for="password">Password:<b style="color:red; font-size:12px">*</b></label>
           										 <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" >
        							</div>
       								 <div class="form-group">
         										   <label for="email">Email:<b style="color:red; font-size:12px">*</b></label>
          										   <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" >
        							 </div>

									 <div class="form-group">
         										   <label for="gender">Gender:<b style="color:red; font-size:12px">*</b></label>
        											<select name="gender" id="gender" class="form-control"  >
														<option value=""> Select Gender</option>
														<option value="male"> Male</option>
														<option value="female"> Female</option> 
													</select>
									  </div>

                    <div class="form-group">
                          <label for="userPassport">User Passport:</label>
                          <input type="file" class="form-control"  accept="image/" capture="environment" id="userPassport" name="userPassport">
                     </div>

                       <!-- Container for image preview -->
                       <hr>
                        
                          <!-- Container for image preview -->
                          <div id="imagePreview" style="width: 80px; height: 80px;"></div>
                        <hr>
                    <div class="form-group">
         										   <label for="app">Applying For:<b style="color:red; font-size:12px">*</b></label>
          										   <input type="text" class="form-control" id="app" name="app" placeholder="Enter Job Position"  >
        							 </div>

                       <div class="form-group">
  <label for="examName">
    Exam Name: <b style="color:red; font-size:12px"> * (You can select more than one exam name!)</b>
  </label>
  <select name="examsList[]" id="examsList" class="examslist form-control"  multiple  ></select>
</div>

       									 <button type="submit" id="addUsersThruForm" class="btn btn-primary">Submit</button>
   								 </form>
                      <!--  -->
                      
                    <form enctype="multipart/form-data" id="addUserForm1" style="display:none">
                    <h3>Add Large Candidates Records.</h3>
                    <div class="btn-group">
    <button type="submit" class="btn btn-primary mt-2" id="largeDATA">Submit</button>
				<input type="file" class=" btn btn-dark mt-2" name="user_batch_file" id="user_batch_file" value="Add Users File">
		</div>
          
    </form>

    <!-- modal for matched records -->

        <!-- Modal for displaying matched records -->
        <div id="matchedRecordsModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <center> <h5 class="modal-title"></h5> </center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <center>
        <br>
        <div id="MatchedRecordsPagination"></div>
        <br>
      </center>
      <div class="modal-body">
        <table id="matchedRecordsTable" class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Username</th>
            </tr>
          </thead>
          <tbody>
            <!-- Records will be inserted here -->
          </tbody>
        </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- end of modal for matched records -->

<!--  -->
<div id="formToggle">
												<div class="btn-group">
  																	<button id="userFormBtn1" class="btn btn-primary mt-2">Click For Small Data Upload</button>
  																	<button id="userFormBtn" class="btn btn-danger mt-2">Click For Large Data Upload</button>
																	  </div>
														</div>

														<script>
															$(document).ready(function()
															 {
  																		// Show Form 1 by default
  																		
 																		 $('#addExamForm1').hide();

  																			// Button click event handlers
  																		$('#userFormBtn1').click(function() {
  																		  $('#addUserForm1').hide();
  																			  $('#addUserForm').show();
  																		});

 																		 $('#userFormBtn').click(function() {
  																		  $('#addUserForm').hide();
  																		  $('#addUserForm1').show();
 																		 });
																	});

														</script>
                            
												
<!--  -->
			

		</div>
						<div id="searchUser" class="tab-pane">
            <div id="searchUser"><img src="img/searchUsers.png" alt="" class="img-fluid img-thumbnail">	</div>
									<!-- <h3>Search User</h3> -->
										<!-- Add the form for searching user here -->
													<hr>		
                          <!-- modern Accordion Starts here -->
    <!--  -->                      <button class="accordion"> <i><b>SEARCH USERS / PRINT / EDIT</b></i> </button>
<div class="panel_base">
  <br>
  <br>
<form id="searchUserForm">
       						 				
                            <div class="input-group mb-3">
    <input type="text" id="searchUsername" name="searchUsername" placeholder="SEARCH BY: USERNAME OR NAME OR PASSWORD" class="form-control">
    <div class="input-group-append">
      <button class="btn btn-info" id="searchUserButton">Search</button>
    </div>
  </div>
                          </form>
                        <br>
                        <hr> 
                            <div id="searchUsers" class="responsive"></div>
                        <hr>
                        <br>
                        <br>
</div>
<!--  -->
<button class="accordion"> <i><b> RESET / ARCHIVE / EXAM ANALYSIS BREAKDOWN</b></i> </button>
<div class="panel_base">
  <!-- accordion content starts here -->
  <br>
  <hr>
         <center><i><b id="totalUsers"></b></i>&nbsp;&nbsp;|&nbsp;&nbsp;<i><b id="inProgressCount"></b></i>&nbsp;<i><span id="percentageTips"></span></i> &nbsp;| &nbsp;&nbsp;<i><b id="transactionCount"></b></i>
        
         <div id="myProgress">
            <div id="myBar"></div>
          </div>
          <div id="doughnutChartContainer" style="width: 320px; height: 320px;"></div>
        </center>
       

         <hr>
            <input type="text" id="search-input" class="form-control" placeholder="Search by Username or Name">
         <hr>
         <div id="pagination"></div>
       <br>
      <!-- users table -->
      <div class="container-fluid responsive overflow-auto" style="max-height: 600px;">
        <!-- HTML Table -->
        <table id="users-table" class="table table-striped">
          <thead>
            <tr>
              <th>
                <input type="checkbox" id="check-all">
              </th>
              <th>ID</th>
              <th>Name</th>
              <th>User Image</th>
              <th>Username</th>
              <th>Email</th>
              <th>Password</th>
              <th>Job Position</th>
              <th>Exam Name</th>
              <th>Exam Status</th>
            </tr>
          </thead>
          <tbody id="users-table-body"> 
            <!-- User details will be appended here using jQuery -->
          </tbody>
        </table>
      </div>

      <hr>
      <center> 
        <div class="btn-group">
    
                  <button id="reset-exams" class="btn btn-primary">Reset Selected Users Exam</button>
                <button id="deleteSelectedUsers" class="btn btn-danger">Archive Selected</button>
                <button id="logoutUsers" class="btn btn-secondary" >Batch Users Logout</button>
            
				</div>
        </center>
      <hr>
<br><br>
      <!-- end of users table -->

  <!-- accordion content ends here -->
</div>
<!--  -->
 <button class="accordion"><i><b> DATA RECOVERY</b></i></button>
<div class="panel_base">
<!-- data recovery section begins here! -->

     <div class="search_container">
        <h2>Archived Data Recovery</h2>
        <form >
        <div class="search-form">
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate" name="startDate">

    <label for="endDate">End Date:</label>
    <input type="date" id="endDate" name="endDate">

    <!-- Update the onclick attribute to call the export function with selected date range -->
    <button id="exportHistory" >Export History</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#exportHistory').on('click', function (e) {
          e.preventDefault()
            // Get selected start and end dates
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            // Construct the export link with date parameters
            var exportLink = 'exportHistory.php?startDate=' + startDate + '&endDate=' + endDate;

            // Redirect to the export link
            window.location.href = exportLink;
        });
    });
</script>
               
                <hr>
                <div id="searchResults"></div>
                <hr>
                
       
    </div> 


<!-- data recovery section ends here! -->
</div>
<!--  -->

<!-- modern Accordion ends here -->
                          
                         
						<!-- modal effects for searched results when an edit button is clicked -->
					

<!-- Edit modal form -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
				<div class="form-group">
                        <label for="edit-id">Candidate ID:<b style="color:red; font-size:12px">*</b> </label>
                        <input type="text" class="form-control" id="edit-id" name="edit-id" disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit-name">Name:<b style="color:red; font-size:12px">*</b></label>
                        <input type="text" class="form-control" id="edit-name" name="edit-name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-username">Username:<b style="color:red; font-size:12px">*</b></label>
                        <input type="text" class="form-control" id="edit-username" name="edit-username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email:<b style="color:red; font-size:12px">*</b></label>
                        <input type="email" class="form-control" id="edit-email" name="edit-email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Password:<b style="color:red; font-size:12px">*</b> </label>
                        <input type="password" class="form-control" id="edit-password" name="edit-password" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-examName">Exam Name: <b style="color:red; font-size:12px">*  (Use comma to separate exam name if you are adding more than one with no space in between. Always check (Manage Exam) section before adding exam names.)</b></label>
                        <input type="text" class="form-control" id="edit-examName" name="edit-examName" required>
                    </div>
                    
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit-user-btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal effects for searched results when an edit button is clicked -->

<!-- view scores modal section -->

<!-- Modal for View Scores -->
<div class="modal fade" id="scores-modal" tabindex="-1" role="dialog" aria-labelledby="scores-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="scores-modal-label">Candidate's Scores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="scores-container">
          <!-- Scores will be dynamically populated here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- end of view scores modal section -->

<!-- Script for View Scores and Print -->
<script>
$(document).ready(function() {
  // View Scores button click event
  $(document).on('click', '.view-scores-button',function() {
    var username = $(this).data('username');
     
    // AJAX request to retrieve the user's scores
    $.ajax({
      url: 'get_scores.php',
      type: 'POST',
      data: { username: username },
      dataType: 'html',
      success: function(response) {
		console.log(response)
        // Populate the modal with the response data
        $('#scores-modal #scores-container').html(response);


        // Show the modal
        $('#scores-modal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });


  // Print button click event
  $(document).on('click','.print-button',function() {
    var username = $(this).data('username');
    var scoresModal = $('#scores-modal');

    // Open the scores modal
    scoresModal.modal('show');

    // Print the scores modal content
    scoresModal.on('shown.bs.modal', function() {
      window.print();
    });

    // Hide the scores modal after printing
    scoresModal.on('hidden.bs.modal', function() {
      scoresModal.off('shown.bs.modal'); // Remove the event listener
    });
  });
});
</script>

<!-- modern Accordion Js script -->

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active_pane");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>


						</div>
						    <div id="addExam" class="tab-pane">
                <div id="addExams"><img src="img/addExam.png" alt="" class="img-fluid img-thumbnail">	</div>
									<hr>	
                <!-- <h3>Add Exam</h3> -->
											<!-- Add the form for adding exam here -->


														
												<form id="addExamForm" enctype="multipart/form-data"  > 
												<h2>Use This Form To Upload Small Records/Data</h2>
    												<div class="form-group">
     														   <label for="examName">Exam Name:</label>
      														  <input type="text" class="form-control" id="exam_title" name="exam_title" placeholder="Enter exam name">
    												</div>
  												    <div class="form-group">
      														  <label for="description">Description:</label>
      														  <textarea  class="form-control" id="exam_description" name="exam_description" rows="3"></textarea>
    												</div>
    												<div class="form-group">
       															 <label for="duration">Duration (minutes):</label>
       															 <input type="number" class="form-control" id="exam_duration" name="exam_duration" placeholder="Enter exam duration">
    												</div>
												
    															 <hr>
    															<h4>Question Count: <span class="countQuestions"></span></h4>
													<div id="questionsContainer" >
      												  <!-- Questions will be dynamically added here using jQuery -->
    												</div>
													
													<div class="btn-group">
    												<button type="button" class="btn btn-primary mt-2" id="addQuestionBtn">Add Question</button>
    												<button type="submit" class="btn btn-success mt-2">Submit</button>
													</div>
													</form>

													<form enctype="multipart/form-data" id="addExamForm1" style='display:none' >
                          <hr>
    												<h2>Use This Form To Upload Bulky Records/Data</h2>
                            <h6 style='color:red'>You can only upload data in Microsoft Excel format!</h6>
                          <hr>
													<div class="form-group">
     														   <label for="examName">Exam Name:</label>
      														  <input type="text" class="form-control" id="exam_title1" name="exam_title1" placeholder="Enter exam name" >
    												</div>
  												    <div class="form-group">
      														  <label for="description">Description:</label>
      														  <textarea  class="form-control" id="exam_description1" name="exam_description1" rows="3" ></textarea>
    												</div>
    												<div class="form-group">
       															 <label for="duration">Duration (minutes):</label>
       															 <input type="number" class="form-control" id="exam_duration1" name="exam_duration1" placeholder="Enter exam duration" >
    												</div>
												
    															 <hr>
    															
													<div id="questionsContainer" >
      												  <!-- Questions will be dynamically added here using jQuery -->
    												</div>
													
													<div class="btn-group">
    												<button type="submit" class="btn btn-success mt-2">Submit</button>
													<input type="file" class="btn btn-dark mt-2" name="batch_file" id="batch_file" value="Add File">
													</div>

													
												</form>

												<div id="formToggle">
												<div class="btn-group">
  																	<button id="form1Btn" class="btn btn-primary mt-2">Upload Small Data</button>
  																	<button id="form2Btn" class="btn btn-danger mt-2">Upload Large Data</button>
																	  </div>
														</div>

														<script>
															$(document).ready(function()
															 {
  																		// Show Form 1 by default
  																		
 																		 $('#addExamForm1').hide();

  																			// Button click event handlers
  																		$('#form1Btn').click(function() {
  																		  $('#addExamForm1').hide();
  																			  $('#addExamForm').show();
  																		});

 																		 $('#form2Btn').click(function() {
  																		  $('#addExamForm').hide();
  																		  $('#addExamForm1').show();
 																		 });
																	});

														</script>
														

														<!-- Add the following jQuery script to add and remove questions -->
														<script src="js/add_remove_question.js"></script>

														

							</div>
						<div id="manageExam" class="tab-pane">
            <div id="manageExams"><img src="img/manageExams.png" alt="" class="img-fluid img-thumbnail">	</div>
              
           															 <!-- <h3>Manage Exam</h3> -->
															<!-- Add the table for managing exam here -->
                                    <hr>
                                    <div id="paginationContainer" class="pagination"></div>
                                    
                                    <hr>

															<table class="table table-striped table-bordered" id="examsTable">
  																   <thead>
      														 			<tr>
																			<th>ID</th>
          															     	<th>Exam Name</th>
            																<th>Description</th>
																			<th>Duration (minutes)</th>
            																<th>Number of Questions</th>
            																<th>Actions</th>
        				   												</tr>
    																</thead>
    																<tbody>
    																</tbody>
															</table>

															<!-- Add the script for managing exams here -->
						  </div>
						  
						<div id="editQuestion" class="tab-pane">
            <div id="editQuestionsSection"><img src="img/editQuestions.png" alt="" class="img-fluid img-thumbnail">	</div>
              <hr>
							<!-- <h3>Edit Questions</h3> -->
							<!-- Table for the questions  -->

													<!-- form input to handle take in exam IDs -->
													<form id="exam_id">
							
							<div class="input-group mb-3">
  <input type="text" id="examID" name="examID" placeholder="Enter exam ID" class="form-control">
  <div class="input-group-append">
    <button class="btn btn-info">Search</button>
  </div>
</div>

							</form> <br>
							<!-- end of form for exam ID -->
							<hr>
							<ul class="pagination" id="questionTablePagination">
  
							</ul>
							 <hr>
	
							<div class="container">
  <div class="row">
    <div class="col">
      <div class="responsive overflow-hidden">
        <div class="scroll-container">
          <!-- Content goes here -->
		  <table id="questionsTable" class="table table-striped table-bordered">
    									<thead>
      											  <tr>
       												     <th>ID</th>
        											     <th>Question</th>
         											     <th>Option A</th>
      											         <th>Option B</th>
       												     <th>Option C</th>
        											     <th>Option D</th>
														 <th>Option E</th>
         											     <th>Answer</th>
          											     <th>Actions</th>
        										 </tr>
                                         </thead>
    									<tbody>

										</tbody>
					         </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal for image questions  -->
<!-- Add the modal markup -->
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

<!-- end of modal for image questions -->
					

							 <!--start of modal section -->

							 <div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editQuestionForm" enctype="multipart/form-data">
                    <input type="hidden" id="questionId" name="questionId">
                    <div class="form-group">
                        <label for="editQuestion">Question</label>
                        <textarea class="form-control" id="question" name="question"></textarea>
						<label for="imgQues">Image Questions:</label>
						<input type="file" class="form-control-file" id="question_image_" name="question_image_">
						<div class="question-image-preview image-preview question_image_-preview"></div>
                    </div>
                    <div class="form-group">
                        <label for="editOptionA">Option A</label>
                        <input type="text" class="form-control" id="optionA" name="optionA">
						<label for="imgOptionA">Image Option A:</label>
						<input type="file" class="form-control-file" id="image_optionA" name="image_optionA">
						<div class="option-a-image-preview image-preview image_optionA-preview"></div>
                    </div>
                    <div class="form-group">
                        <label for="editOptionB">Option B</label>
                        <input type="text" class="form-control" id="optionB" name="optionB">
						<label for="imgOptionB">Image Option B:</label>
						<input type="file" class="form-control-file" id="image_optionB" name="image_optionB">
						<div class="option-b-image-preview image-preview image_optionB-preview"></div>
                    </div>
                    <div class="form-group">
								<label for="editOptionC">Option C</label>
								<input type="text" class="form-control" id="optionC" name="optionC">
								<label for="imgOptionC">Image Option C:</label>
						<input type="file" class="form-control-file" id="image_optionC" name="image_optionC">
						<div class="option-c-image-preview image-preview image_optionC-preview"></div>
					</div>
					<div class="form-group">
								<label for="editOptionD">Option D</label>
								<input type="text" class="form-control" id="optionD" name="optionD">
								<label for="imgOptionD">Image Option D:</label>
						<input type="file" class="form-control-file" id="image_optionD" name="image_optionD">
						<div class="option-d-image-preview image-preview image_optionD-preview"></div>
					</div>
					<div class="form-group">
								<label for="editOptionE">Option E</label>
								<input type="text" class="form-control" id="optionE" name="optionE">
								<label for="imgOptionE">Image Option E:</label>
						<input type="file" class="form-control-file" id="image_optionE" name="image_optionE">
						<div class="option-e-image-preview image-preview image_optionE-preview"></div>
					</div>
					<div class="form-group">
								<label for="editAnswer">Answer : <b style="color:red; font-size:12px"> * (Separate your answer options with a comma and with NO space in between the commas and options (i.e A,B,C)!)</b></label>
								<input type="text" class="form-control" id="answer" name="answer">
					</div>
					<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>






							 <!-- end of modal -->

						</div>

						<div id="report" class="tab-pane">

            <div id="generateReports"><img src="img/generateReports.png" alt="" class="img-fluid img-thumbnail">	</div>
              <hr>
									<!-- <h3>Report Generation</h3> -->
							
									<div>
  <!-- HTML markup --> 


<div class="input-group mb-3">
  <input type="text" id="searchExamId" name="searchExamId" placeholder="Search By Exam IDs Only" class="form-control">
  <div class="input-group-append">
    <button id="searchButton" class="btn btn-info">Search</button>
  </div>
</div>

<!--  -->
<hr>
<div id="paginationInfo" ></div>

<div class="input-group-append">
<button id="prevPageButton" class="pagination btn btn-primary mr-2 p-2">Previous</button>
<button id="nextPageButton" class="pagination btn btn-primary p-2">Next</button>
</div>
<hr>
<!--  -->
<div class="responsive overflow-auto" style="max-height: 400px;">
<!--  -->
<table id="usersTable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Exam Names</th>
      <th>Scores</th>
	  <th>Dates</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <input type="text" id="searchInput" class="form-control" placeholder="Search Table Data">
  </tbody>
</table>
<!--  -->


 </div><!-- ebd of overflow-scroll -->
<div>
  <!-- <button id="deleteSelectedButton" class="btn btn-danger">Delete Selected</button> -->
  <button id="exportSelectedButton" class="exportButton btn btn-info">Export Selected</button>
</div>


<script>
  $(document).ready(function() {
// Function to fetch and display the users' details
function fetchUsers(examId, page) {
  $.ajax({
    url: 'fetch_users.php',
    method: 'POST',
    data: { examId: examId, page: page }, // Include the page parameter
    dataType: 'json',
    success: function(response) {
      if (response.success) { 
        var users = response.users;
        var tableBody = $('#usersTable tbody');
        tableBody.empty();

        users.forEach(function(user) {
          var row = $('<tr>');
          row.append('<td></td>');
          row.append('<td>' + user.id + '</td>');
          row.append('<td>' + user.name + '</td>');
          row.append('<td>' + user.username + '</td>');
          row.append('<td>' + user.email + '</td>');
          row.append('<td>' + user.exam_names + '</td>');
          row.append('<td data-sort="' + user.scores + '">' + user.scores + '</td>');
          row.append('<td>' + user.dates + '</td>');
          row.append('<td><input type="checkbox" value="' + user.id + '"></td>');
          tableBody.append(row);
        });

        // Update pagination information 
        var currentPage = response.page;
        var totalPages = response.total_pages;
        $('#paginationInfo').text('Page ' + currentPage + ' of ' + totalPages);

        // Enable/disable pagination buttons based on the current page
        $('#prevPageButton').prop('disabled', currentPage === 1);
        $('#nextPageButton').prop('disabled', currentPage === totalPages);

        
        // Add select all functionality
        var selectAllCheckbox = $('#selectAll'); 
        if (selectAllCheckbox.length === 0) {
          selectAllCheckbox = $('<input type="checkbox" id="selectAll">');
          $('#usersTable thead tr').prepend('<th></th>');
          $('#usersTable thead tr th:first-child').text('Mark All').append(selectAllCheckbox);
        }
        
        selectAllCheckbox.prop('checked', false); // Uncheck the select all checkbox

        selectAllCheckbox.on('click', function() {
          var isChecked = $(this).prop('checked');
          $('#usersTable tbody tr td:last-child input[type="checkbox"]').prop('checked', isChecked);
        });

        // Add sorting functionality
        var tableHeaders = $('#usersTable thead tr th[data-sort]');
        tableHeaders.off('click'); // Remove any existing click event handlers

        tableHeaders.on('click', function() {
          var sortType = $(this).data('sort');
          var sortOrder = $(this).data('order') === 'asc' ? 'desc' : 'asc';

          tableHeaders.removeClass('sorted-asc sorted-desc');
          $(this).addClass(sortOrder === 'asc' ? 'sorted-asc' : 'sorted-desc');

          sortTable(sortType, sortOrder);
        });

        function sortTable(sortType, sortOrder) {
          var rows = $('#usersTable tbody tr').toArray();

          rows.sort(function(a, b) {
            var aValue = $(a).find('td[data-sort]').data('sort');
            var bValue = $(b).find('td[data-sort]').data('sort');

            if (sortType === 'scores') {
              aValue = parseInt(aValue);
              bValue = parseInt(bValue);
            }

            if (aValue < bValue) {
              return sortOrder === 'asc' ? -1 : 1;
            } else if (aValue > bValue) {
              return sortOrder === 'asc' ? 1 : -1;
            } else {
              return 0;
            }
          });

          tableBody.empty();
          tableBody.append(rows);
        }

        // Add search functionality
        var searchInput = $('#searchInput');
        searchInput.off('keyup'); // Remove any existing keyup event handlers

        searchInput.on('keyup', function() {
          var searchText = $(this).val().toLowerCase();

          tableBody.find('tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            var isVisible = rowText.indexOf(searchText) !== -1;
            $(this).toggle(isVisible);
          });
        });
// Add export functionality
var exportButton = $('.exportButton');
            exportButton.off('click'); // Remove any existing click event handlers
exportButton.on('click', function() 
      {
          var selectedUserIds = [];
          $('#usersTable tbody tr').each(function() {
            var checkbox = $(this).find('input[type="checkbox"]');
            if (checkbox.prop('checked')) {
              selectedUserIds.push(checkbox.val());
            }
          });

          if (selectedUserIds.length === 0) {
            //alert();
            Toastify({
          text: 'No user(s) selected for export.',
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();


          return;
            }

            var selectedRows = $('#usersTable tbody tr').filter(function() {
              var checkbox = $(this).find('input[type="checkbox"]');
              return checkbox.prop('checked');
            });
            //var usersToExport = response.users;
            var clonedTable = $('<table>').append(selectedRows.clone());
            var workbook = XLSX.utils.table_to_book(clonedTable[0], { sheet: 'Sheet 1' });
            XLSX.writeFile(workbook, 'usersExamDetails.xlsx');
          /*   usersToExport.forEach(usersExported => {
              XLSX.writeFile(workbook, usersExported.exam_names + ' exam details.xlsx')
            }); */ 
  });

      }
    },
    error: function() {
      // Handle error case
    }
  });
}


// ...

// Previous page button click event
$('#prevPageButton').click(function() {
  var currentPage = parseInt($('#paginationInfo').text().split(' ')[1]);
  var examId = $('#searchExamId').val();
  fetchUsers(examId, currentPage - 1);
});

// Next page button click event
$('#nextPageButton').click(function() {
  var currentPage = parseInt($('#paginationInfo').text().split(' ')[1]);
  var examId = $('#searchExamId').val();
  fetchUsers(examId, currentPage + 1);
});

 // Search button click event
 $('#searchButton').click(function() {
  var examId = $('#searchExamId').val();
             
    
    // If any fields are empty, display an error message
    if (examId == '') {
      //$('#errorMessage').text('Please fill in all the required fields.').show();
      Toastify({
        text: "Input Field Cannot Be Empty, Enter An Exam ID!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();

    } else{

      fetchUsers(examId);
      
    }

  
});

// Delete selected button click event
$('#deleteSelectedButton').click(function() {
  var selectedUserIds = [];
  var examId = $('#searchExamId').val(); 
  $('#usersTable tbody input:checked').each(function() {
    selectedUserIds.push($(this).val());
  });

  if (selectedUserIds.length > 0) {
    $.ajax({
      url: 'usersBatchDel.php',
      method: 'POST',
      data: { userIds: selectedUserIds },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Handle success case
          Toastify({
        text: response.message,
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();

          fetchUsers(examId);
        } else {
          // Handle error case
          Toastify({
        text: response.message,
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
        }
      },
      error: function() {
        // Handle error case
      }
    });
  } else {
    // Show a message that no users are selected
  }
});

// Export selected button click event
$('#exportSelectedButton').click(function() {
  var selectedUserIds = [];
 



  $('#usersTable tbody input:checked').each(function() {
    selectedUserIds.push($(this).val());
   
  });
  

  if (selectedUserIds.length > 0) {
    // Create a form and submit it to the export script
    var form = $('<form method="POST" action="export_report.php">');
        
     
    form.append('<input type="hidden" name="userIds[]" value="' + selectedUserIds.join(',') + '">');
    $('body').append(form);
    form.submit();
  } else {
               // Show a message that no users are selected
  
          }//end of else


});// end of exportSelectedButton

$(document).on('click', '#exportSelectedButton', function() {
  // Find all the checked input fields within the table body
  var checkedInputs = $('#usersTable tbody input:checked');
  
  // Check if there are any checked input fields
  if (checkedInputs.length > 0) {
    // Get the value of the nth child (6th column) from the first checked input
    var exam_Title = checkedInputs.first().closest("tr").find("td:nth-child(6)").text();
    //console.log(exam_Title);
    
    // Count the number of checked input fields
    var checkedCount = checkedInputs.length;
    
    // Now, prepare the data to be sent in the AJAX request
    var requestData = {
      exam_Title: exam_Title, // Include the exam title
      checkedCount: checkedCount // Include the count of checked input fields
    };

    $.ajax({
      url: 'trackExportedScores.php',
      method: 'POST',
      dataType: 'json',
      data: requestData,
      success: function(response) {
        // Handle the success response from the server
        
      }/* ,
      error: function(xhr, status, error) {
        console.error('Error:', error);
      } */
    });
  } else {
    // No checked inputs found, handle this case (show an alert, etc.)
    console.log('No input field is checked.');
  }
});

  });
</script>
					<!-- scripts ends here! -->
						</div>

		<!-- <div id="editImgExam" class="tab-pane">
			<h3>Edit Graphical Questions Coming Soon!</h3>
		</div> -->
		
     </div> <!-- End of <div class="tab-content mt-3"> -->

     <div id="audit" class="tab-pane">
     <div id="audit_tray"><img src="img/audit_trail.png" alt="" class="img-fluid img-thumbnail">	</div>
     <hr>
             <!-- Audit Tray Section -->
<div class="container mt-5">

  <!-- Filters and Search Bar -->
  <div class="row mb-3">
    <div class="col-md-4">
      <label for="userFilter">Filter by User:</label>
      <select class="form-control" id="userFilter">
        <option value="">All Users</option>
        <!-- Dynamically populate user options using PHP -->
        <?php
          include('../connection.php');
          $sql = "SELECT DISTINCT user_name FROM audit_tray ORDER BY user_name ASC";
          $result = $conn->query($sql);
          if ($result) {
            while ($row = $result->fetch_assoc()) {
              echo '<option value="' . $row['user_name'] . '">' . $row['user_name'] . '</option>';
            }
          }
          $conn->close();
        ?>
      </select>
    </div>
    <div class="col-md-4">
      <label for="dateFilter">Filter by Date Range:</label>
      <input type="text" class="form-control" id="dateFilter" placeholder="Select date range">
    </div>
    <div class="col-md-4">
      <label for="searchQuery">Search Description:</label>
      <input type="text" class="form-control" id="searchQuery" placeholder="Search by description">
    </div>
  </div>
 <!-- audit tray pagination -->
   
 <nav aria-label="Audit Trail Pagination">
    <ul class="pagination justify-content-center" id="auditTrayPagination">
      <!-- Pagination links will be dynamically generated here -->
    </ul>
  </nav>

  <div class="container-fluid responsive overflow-auto" style="max-height: 600px;">
                  <!-- end of audit tray pagination -->
                    <table class="table table-striped">
                      <tbody id="auditTrayEntries">
                        <!-- AJAX will populate this tbody with audit trail entries -->
                      </tbody>
                    </table>
        </div><!-- end of class="container-fluid responsive overflow-auto" -->
<hr>
  <center><button class="btn btn-success" id="exportExcelBtn">Export Selected to Excel</button></center>
<hr>
</div>
<script src="js/audit_tray.js"></script>
			
		</div><!-- end of audit tray tab-pane -->

    <!-- create admin -->
    <div id="createAccessLevel" class="tab-pane">
    <div id="create_admin"><img src="img/create_admin.png" alt="" class="img-fluid img-thumbnail">	</div>
     <hr>
    <div class="container mt-5">
        <h3>Add Admin User</h3>
        <form id="addAdminForm">
            <div class="form-group">
                <label for="name">Name *:</label>
                <input type="text" class="form-control" id="adminName" name="adminName" >
            </div>
            <div class="form-group">
                <label for="email">Email *:</label>
                <input type="email" class="form-control" id="adminEmail" name="adminEmail" >
            </div>
            <div class="form-group">
                <label for="username">Username *:</label>
                <input type="text" class="form-control" id="adminUsername" name="adminUsername" >
            </div>
            <div class="form-group">
                <label for="password">Password *:</label>
                <input type="password" class="form-control" id="adminPassword" name="adminPassword" >
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password *:</label>
                <input type="password" class="form-control" id="adminConfirmPassword" name="adminConfirmPassword" >
            </div>
            <div class="form-group">
                <label for="accessLevel">Access Level *:</label>
                <select class="form-control" id="accessLevel" name="accessLevel" >
                    <option value="2">Admin User</option>
                    <option value="1">Super Admin User</option>
                </select>
            </div>
            <input type="hidden" id="clientIP" name="clientIP">
            <button type="submit" class="btn btn-primary">Add Admin User</button>
        </form>
    </div>

		</div><!-- end of createAccessLevel -->

<script src="../bootstrap_v4/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    // ...

    // Initialize date range picker
    $('#dateFilter').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      clearBtn: true,
      orientation: 'bottom',
      todayHighlight: true
    });

    // ...
  });
</script>
</body>
</html>
