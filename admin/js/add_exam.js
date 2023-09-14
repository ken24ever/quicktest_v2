$(document).ready(function(){

  var match = ['pdf', 'jpeg', 'png', 'jpg']; // define allowed file types here

  function validateFileType(file) {
    var fileType = file.type.split("/")[1]; // Get the file extension from the file type
    if (match.indexOf(fileType.toLowerCase()) === -1) {
      return false; // File type doesn't match
    }
    return true; // All file types match
  }

  $("#addExamForm").on('change', 'input[type="file"]', function() {
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

      if (files[i].size > 2 * 1024 * 1024) { // 2MB in bytes
        //alert("Error: File size should be less than 2MB!");
        Toastify({
          text: "Error: File size should be less than 2MB!",
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
        $(this).val(''); // Clear the file input field
        return false; // File size is too large
      }
    }
  });
  

  $("#addExamForm").submit(function(event){
    // Prevent default form submission behavior
    event.preventDefault();

    // Check if input fields are not empty
    if($.trim($('#exam_title').val()) == '' || $.trim($('#exam_description').val()) == '' || $.trim($('#exam_duration').val()) == '' ){
      //alert('Error: Please provide exam details.');
      
      Toastify({
        text: 'Error: Please provide exam details.',
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();

      return false;
    } 

    // Create a new FormData object
    var formData = new FormData();

    // Loop through each form field and append it to the FormData object
    $(this).find("input[type='text'], input[type='number'], input[type='file'], input[type='hidden'], select, textarea").each(function() {
      var name = $(this).attr("name");
      var type = $(this).attr("type");
      var value = $(this).val();

      // If the field is an image file input, append each file to the FormData object with a unique key
      if (type === "file" && (name.indexOf("question_image_") === 0 || name.indexOf("option_a_image_") === 0
        || name.indexOf("option_b_image_") === 0 || name.indexOf("option_c_image_") === 0 
        || name.indexOf("option_d_image_") === 0 || name.indexOf("option_e_image_") === 0)) {
        var files = $(this)[0].files;
        for (var i = 0; i < files.length; i++) {
          formData.append(name, files[i]);
        }
      } else {
        formData.append(name, value); 
      }
    });
  

    // Create an object to store the correct answers for each question
    var correctAnswers = {};

    // Loop through each question and get the selected correct answers
    for (var i = 1; i <= questionCount; i++) {
      var selectedAnswers = [];
      $('input[name="correct' + i + '[]"]:checked').each(function() {
        selectedAnswers.push($(this).val());
      });
      correctAnswers[i] = selectedAnswers;
    }

    // Add the correct answers data to a hidden input field in the form
    var correctAnswersJSON = JSON.stringify(correctAnswers);
    $('<input>').attr({
      type: 'hidden',
      name:'correctAnswers',
      value: correctAnswersJSON
    }).appendTo("#addExamForm");



// console.log(correctAnswersJSON )
    // Send the form data using an AJAX request
    $.ajax({
      url:"add_exam.php",
      type: 'POST', 
      data: formData,
      contentType: false,
      processData: false,
      success: function(response){ 
        // output 
       // alert(response);
        console.log(response)

        Toastify({
          text: response,
          duration: 5000,
          gravity: 'bottom',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
      },
      error: function(xhr, textStatus, errorThrown){
        // Display an error message
        Toastify({
          text: "Error: " + errorThrown,
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
      }
    });
  });

});
