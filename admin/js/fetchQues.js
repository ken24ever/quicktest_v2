$(document).ready(function() {
  var examId;
  var pageNum = 1;
  var totalPages;

  // Handle form submission
  $('#exam_id').submit(function(e) {
    e.preventDefault(); // Prevent default form submission

    // Get the exam ID from the form input
    examId = $('input[name="examID"]').val();

    if (examId == ''){
      Toastify({
        text: "This Field Cannot Be Empty, Enter A Valid Exam ID!",
        duration: 4000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
      return false; 
    }
 
    // Send an AJAX request to fetch questions for the given exam ID and page number
    fetchQuestions(examId, pageNum);
  });

  

  // Function to fetch questions using AJAX
  function fetchQuestions(examId, pageNum) {
    $.ajax({
      url: 'fetchQuestions.php',
      method: 'POST',
      data: {
        exam_id: examId,
        page: pageNum
      },
      dataType: 'json',
      success: function(response) {
        if (response.status == 'success') {
          var questions = response.questions;
  
          // Clear the existing rows from the table
          var questionTable = $('#questionsTable').find('tbody');
          questionTable.empty();
  
          // Loop through each question and append it to the table
          for (var i = 0; i < questions.length; i++) {
            var question = questions[i];
            var questionRow = $('<tr></tr>');
  
            questionRow.append('<td>' + question.id + '</td>');
           
  
// Check if the question has an image
if (question.image_ques) {
  // Append a button to view the image question
  questionRow.append('<td>'+question.question+'<br><button class="view-image-btn btn btn-sm btn-primary" data-image-path="' + question.image_ques + '">View Question Image</button></td>');
} else {
  questionRow.append('<td>'+question.question+'</td>'); // Empty cell if no image
}

// Append options based on the presence of image options or text options
if (question.option_a_image_path || question.option_b_image_path || question.option_c_image_path || question.option_d_image_path || question.option_e_image_path) {
  if (question.option_a_image_path) {
    questionRow.append('<td>' + question.option_a + '<br> <button class="btn btn-sm btn-primary view-image-options-btn" data-image-path="' + question.option_a_image_path + '">View Image Option</button></td>');
  } else {
    questionRow.append('<td>' + question.option_a + '</td>');
  }

  if (question.option_b_image_path) {
    questionRow.append('<td>' + question.option_b + '<br> <button class="btn btn-sm btn-primary view-image-options-btn" data-image-path="' + question.option_b_image_path + '">View Image Option</button></td>');
  } else {
    questionRow.append('<td>' + question.option_b + '</td>');
  }

  if (question.option_c_image_path) {
    questionRow.append('<td>' + question.option_c + '<br> <button class="btn btn-sm btn-primary view-image-options-btn" data-image-path="' + question.option_c_image_path + '">View Image Option</button></td>');
  } else {
    questionRow.append('<td>' + question.option_c + '</td>');
  }

  if (question.option_d_image_path) {
    questionRow.append('<td>' + question.option_d + '<br> <button class="btn btn-sm btn-primary view-image-options-btn" data-image-path="' + question.option_d_image_path + '">View Image Option</button></td>');
  } else {
    questionRow.append('<td>' + question.option_d + '</td>');
  }

  if (question.option_e_image_path) {
    questionRow.append('<td>' + question.option_e + '<br> <button class="btn btn-sm btn-primary view-image-options-btn" data-image-path="' + question.option_e_image_path + '">View Image Option</button></td>');
  } else {
    questionRow.append('<td>' + question.option_e + '</td>');
  }
} else {
  // Append text options
  questionRow.append('<td>' + question.option_a + '</td>');
  questionRow.append('<td>' + question.option_b + '</td>');
  questionRow.append('<td>' + question.option_c + '</td>');
  questionRow.append('<td>' + question.option_d + '</td>');
  questionRow.append('<td>' + question.option_e + '</td>');
}

  
  
            questionRow.append('<td>' + question.answer + '</td>');
  
            var actions = $('<td></td>');
            var editBtn = $('<button class="btn btn-sm btn-primary edit-question-btn">Edit</button>');
            editBtn.data('question-id', question.id);
            actions.append(editBtn);
            questionRow.append(actions);
  
            questionTable.append(questionRow);
          }
  
          // Update the total number of pages and add pagination links
          totalPages = response.totalPages;
          updatePagination(response.currentPage);
  
   
  // Handle the click event for the "View Question Image" button using event delegation
$(document).on('click', '.view-image-btn', function() {
  var imagePath = $(this).data('image-path');
  // Set the image source and open the modal
  $('#questionImage').attr('src', imagePath);
  $('#questionImageModal').modal('show');
});


// Handle the click event for the "View Image Option" buttons
$('.view-image-options-btn').click(function() {
  var optionImagePath = $(this).data('image-path');
  // Open the image option in a new window
  window.open(optionImagePath);
});

  
       }
    },
      error: function(xhr, status, error) {
        console.error(error);
        alert('An error occurred while fetching questions. Please try again later.');
      }
      
    });
  }

  // Function to update the pagination links
                  function updatePagination(currentPage) 
  {
 
                 var pagination = $('#questionTablePagination');
                  pagination.empty();

                  

                            if (totalPages > 1) 
                            {
                                          // Add the "previous" link
                                            if (currentPage == 1) 
                                             {
                                                   pagination.append('<li class="page-item disabled" ><span class="page-link">Previous</span></li>');
                                             } 
                                             else
                                             {
                                                   pagination.append('<li class="page-item" title="'+(currentPage - 1)+'"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '">Previous</a></li>');
                                             }

                                          // Add the numbered page links
                                           for (var i = 1; i <= totalPages; i++) 
                                          {
                                                   if (i == currentPage) 
                                                    {
                                                         pagination.append('<li class="page-item active" title="'+i+'"><span class="page-link">' + i + '</span></li>');
                                                    } 
                                                    else 
                                                    {
                                                          pagination.append('<li class="page-item" title="'+i+'"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
                                                    }
                                           }
                                          // Add the "next" link
                                      if (currentPage == totalPages) {
    pagination.append('<li class="page-item disabled" ><span class="page-link">Next</span></li>');
} else {
    pagination.append('<li class="page-item" title="'+(parseInt(currentPage) + 1)+'"><a class="page-link" href="#"  data-page="' + (parseInt(currentPage) + 1) + '">Next</a></li>');
}


                                            // Bind the click event to the pagination links
                                          pagination.find('a').click
                                          (   function(e) 
                                           {
                                               e.preventDefault();
                                               var page = $(this).data('page');
                                               fetchQuestions(examId, page);
                                           }
                                          );
                             }//end of if (totalPages > 1) 
  }// function updatePagination(currentPage) 


    // When the edit button is clicked, show the edit question modal
    $('#questionsTable').on('click', '.edit-question-btn', function() {
      var questionId = $(this).data('question-id');
    
      $.ajax({
        url: 'update_questions.php',
        method: 'POST',
        data: { question_id: questionId },
        dataType: 'json',
        success: function(response) {
          if (response.status == 'success') {
            var question = response.question;
    
            // Set the form values
            $('#editQuestionForm input[name="questionId"]').val(question.id);
            $('#editQuestionForm textarea[name="question"]').val(question.question);
            $('#editQuestionForm input[name="optionA"]').val(question.option_a);
            $('#editQuestionForm input[name="optionB"]').val(question.option_b);
            $('#editQuestionForm input[name="optionC"]').val(question.option_c);
            $('#editQuestionForm input[name="optionD"]').val(question.option_d);
            $('#editQuestionForm input[name="optionE"]').val(question.option_e);
            $('#editQuestionForm input[name="answer"]').val(question.answer);
            $('#editQuestionForm input[name="question_image_"]').text(question.image_ques);
            $('#editQuestionForm input[name="image_optionA"]').text(question.option_a_image_path);
            $('#editQuestionForm input[name="image_optionB"]').text(question.option_b_image_path);
            $('#editQuestionForm input[name="image_optionC"]').text(question.option_c_image_path);
            $('#editQuestionForm input[name="image_optionD"]').text(question.option_d_image_path);
            $('#editQuestionForm input[name="image_optionE"]').text(question.option_e_image_path);
     
            // Show the question image preview
            if (question.image_ques) {
              $('#editQuestionForm .question-image-preview').html('<img src="' + question.image_ques + '" class="img-thumbnail " width="70px" height="70px">');
<<<<<<< HEAD
              //  $('#question_image_').attr('value', question.image_ques);
=======
<<<<<<< HEAD
              //  $('#question_image_').attr('value', question.image_ques);
=======
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
            } else {
              $('#editQuestionForm .question-image-preview').html('');
            }
    
            // Show the option A image preview
            if (question.option_a_image_path) {
              $('#editQuestionForm .option-a-image-preview').html('<img src="' + question.option_a_image_path + '" class="img-thumbnail " width="70px" height="70px">');
            } else {
              $('#editQuestionForm .option-a-image-preview').html('');
            }
    
            // Show the option B image preview
            if (question.option_b_image_path) {
              $('#editQuestionForm .option-b-image-preview').html('<img src="' + question.option_b_image_path + '" class="img-thumbnail " width="70px" height="70px">');
            } else {
              $('#editQuestionForm .option-b-image-preview').html('');
            }
    
            // Show the option C image preview
            if (question.option_c_image_path) {
              $('#editQuestionForm .option-c-image-preview').html('<img src="' + question.option_c_image_path + '" class="img-thumbnail " width="70px" height="70px">');
            } else {
              $('#editQuestionForm .option-c-image-preview').html('');
            }
    
            // Show the option D image preview
            if (question.option_d_image_path) {
              $('#editQuestionForm .option-d-image-preview').html('<img src="' + question.option_d_image_path + '" class="img-thumbnail " width="70px" height="70px">');
            } else {
              $('#editQuestionForm .option-d-image-preview').html('');
            }
    
            // Show the option E image preview
            if (question.option_e_image_path) {
              $('#editQuestionForm .option-e-image-preview').html('<img src="' + question.option_e_image_path + '" class="img-thumbnail " width="70px" height="70px">');
            } else {
              $('#editQuestionForm .option-e-image-preview').html('');
            }
    
              // Show the modal
          $('#editQuestionModal').modal('show');
        } else {
          alert('Failed to fetch question from the database');
        }
      },
      error: function() {
        alert('Failed to fetch question from the database');
      }
    });
  });

  // Add hover effects to the image preview sections
  $('#editQuestionForm .image-preview').hover(
    function() {
      $(this).find('img').css('transform', 'scale(4.4)');
    },
    function() {
      $(this).find('img').css('transform', 'scale(1)');
    }
  );
  

  
  
// Image preview function with resizing
function previewImage(input, previewContainer) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      var image = new Image();
      image.src = e.target.result;

      image.onload = function() {
        // Resize the image if needed
        var maxWidth = 70;
        var maxHeight = 70;
        var width = image.width;
        var height = image.height;

        if (width > maxWidth || height > maxHeight) {
          var aspectRatio = width / height;

          if (width > height) {
            width = maxWidth;
            height = width / aspectRatio;
          } else {
            height = maxHeight;
            width = height * aspectRatio;
          }
        }

        // Create a canvas element for image resizing
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(image, 0, 0, width, height);

        // Get the resized image data URL
        var resizedDataURL = canvas.toDataURL('image/jpeg');

        // Create the image preview
        var imagePreview = '<img src="' + resizedDataURL + '" alt="Image Preview">';
        $(previewContainer).html(imagePreview);
      }
    }

    reader.readAsDataURL(input.files[0]);
  }
}

var match = ['pdf', 'jpeg', 'png', 'jpg']; // define allowed file types here

function validateFileType(file) {
  var fileType = file.type.split("/")[1]; // Get the file extension from the file type
  if (match.indexOf(fileType.toLowerCase()) === -1) {
    return false; // File type doesn't match
  }
  return true; // All file types match
}

// Image preview on file input change with file size validation
$('#question_image_,#image_optionA,#image_optionB,#image_optionC,#image_optionD,#image_optionE').change(function() {
  var inputId = $(this).attr('id');
  var previewContainer = '.' + inputId + '-preview'; 
  var maxFileSize = 2 * 1024 * 1024; // 2MB
  var files = $(this)[0].files; // Get selected files

  for (var i = 0; i < files.length; i++) {
    if (!validateFileType(files[i])) {
      //alert("Error: System Can Only Accept PNG, JPEG, JPG, PDF Formats!");
      Toastify({
        text: "Error: System Can Only Accept PNG, JPEG, JPG, PDF Formats!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
      $(this).val(''); // Clear the file input field
      return false; // File type doesn't match
    }
  }

  if (this.files[0].size <= maxFileSize) {
    previewImage(this, previewContainer);
  } else {
    // Clear the file input and preview container
    $(this).val('');
    $(previewContainer).html('');
  
    /* display message to the screen */
    Toastify({
      text: 'File size exceeds the maximum limit of 2MB.',
      duration: 5000,
      gravity: 'top',
      close: true,
      style: {
        background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
      }
    }).showToast();

  }
});

  

  // Add event listener for the form submit button
// Form submission
$('#editQuestionForm').submit(function(e) {
  e.preventDefault();

  var formData = new FormData(this);

  $.ajax({
    url: 'submit_question.php',
    type: 'POST',
    data: formData,
    dataType: 'json',
    contentType: false,
    processData: false,
    success: function(response) {
      if (response.status === 'success') {
        // Handle success response
        //hide modal
        $('#editQuestionModal').modal('hide');
        Swal.fire({
          icon: 'success',
          html: '<b style="color:green">Exam Question Successfully Updated!</b>'
                 }); 

        fetchQuestions(examId, pageNum);
      } else {
        //hide modal
        $('#editQuestionModal').modal('hide');
        // Handle error response
        Swal.fire({
          icon: 'success',
          html: '<b style="color:red">Form submission failed!</b>'
                 });
        console.error('Form submission failed.');
      }
    },
    error: function() {
      console.error('Form submission failed.');
    }
  });
});


    



  

    });//END OF $(document).ready(function() 
  


    