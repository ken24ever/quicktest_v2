<!DOCTYPE html>
<html>
<head>
	<title>CBT Application</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../bootstrap_v4/css/bootstrap.min.css">
  
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
   <link rel="stylesheet" href="../sweetalert2/dist/sweetalert2.min.css">
<script src="../sweetalert2/dist/sweetalert2.all.min.js"></script>


	<!-- import all custom js scripts -->
  <script src="js/usersBatchUpload.js"></script>
 <script src="js/fetchQues.js"></script>
    <script src="js/addUser.js"></script>
	<script src="js/search_users.js"></script>
	<script src="js/add_exam.js"></script>
	<script src="js/get_manage_exams.js"></script>
	
	<script src="js/addImageExams.js"></script>
	
	
  

	<script>
		$(document).ready(function(){

		
        $('#addUserForm').submit(function(e) {
            e.preventDefault(); // prevent default form submit behavior
          
              // Check if any input or select fields are empty
    var emptyFields = $(this).find('input, select').filter(function() {
      var value = $(this).val();
      return !value || $.trim(value) === '';
    });

    // If any fields are empty, display an error message
    if (emptyFields.length > 0) {
      //$('#errorMessage').text('Please fill in all the required fields.').show();
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
      
      $.ajax({
                url: 'add_user.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // handle success response
                    console.log(response);
                    //alert(response) 

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




    } // end of else statement 
            
    });// end of $('#addUserForm')



		})
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
     
    
      <li class="nav-item">
        <a class="nav-link text-dark" href="index.php"> <b>Logout</b> </a>
      </li>    
    </ul>
  </div>
</nav>

<div class="container mt-5">
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
	</ul>
	<div class="tab-content mt-3">
		<div id="addUser" class="tab-pane active">
		
			<!-- Add the form for adding user here -->
				<div id="addUsers"><img src="img/add_Users.png" alt="" class="img-fluid img-thumbnail">	</div>				
				<hr>
   							 <form id="addUserForm" >
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
         										   <label for="app">Applying For:<b style="color:red; font-size:12px">*</b></label>
          										   <input type="text" class="form-control" id="app" name="app" placeholder="Enter Job Position"  >
        							 </div>

                       <div class="form-group">
  <label for="examName">
    Exam Name: <b style="color:red; font-size:12px"> * (You can select more than one exam name!)</b>
  </label>
  <select name="examsList[]" id="examsList" class="examslist form-control"  multiple  ></select>
</div>

       									 <button type="submit" class="btn btn-primary">Submit</button>
   								 </form>
                      <!--  -->
                      
                    <form enctype="multipart/form-data" id="addUserForm1" style="display:none">
                    <h3>Add Large Candidates Records.</h3>
                    <div class="btn-group">
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
				<input type="file" class="btn btn-dark mt-2" name="user_batch_file" id="user_batch_file" value="Add Users File">
		</div>
          
    </form>

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
    										<form id="searchUserForm">
       						 				
													<div class="input-group mb-3">
  <input type="text" id="searchUsername" name="searchUsername" placeholder="SEARCH BY: USERNAME OR NAME OR PASSWORD" class="form-control">
  <div class="input-group-append">
    <button class="btn btn-info">Search</button>
  </div>
</div>
    										</form>
											<br>
													<div id="searchUsers" class="responsive"></div>

						<!-- modal effects for searched results when an edit button is clicked -->
					

<!-- Edit modal form -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                        <label for="edit-examName">Exam Name: <b style="color:red; font-size:12px">*  (Use comma to separate exam if you are adding more than one with no space in between!)</b></label>
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
  <div class="modal-dialog" role="document">
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
    												<h2>Use This Form To Upload Bulky Records/Data</h2>
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
																			<th>Duration</th>
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
  <input type="text" id="examID" name="examID" placeholder="Enter exam ID"class="form-control">
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
								<label for="editAnswer">Answer</label>
								<!-- <input type="text" class="form-control" id="answer" name="answer"> -->
                <select class="form-control" id="answer" name="answer" required>
                  <option value="">Select Answer</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
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
  <button id="deleteSelectedButton" class="btn btn-danger">Delete Selected</button>
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
exportButton.on('click', function() {
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
  var usersToExport = response.users;
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






<script src="../bootstrap_v4/js/bootstrap.min.js"></script>

</body>
</html>
