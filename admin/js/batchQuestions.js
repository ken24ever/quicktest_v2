$(document).ready(function(){

// Submit form event handler
$(document).on('submit','#addExamForm1',function(e) {
    e.preventDefault(); // Prevent default form submission
    // Check if input fields are not empty
    if($.trim($('#exam_title1').val()) == '' || $.trim($('#exam_description1').val()) == '' || $.trim($('#exam_duration1').val()) == '' && $.trim($('#batch_file').val()) ){
      //alert('Error: Please provide exam details.');
      
      Toastify({
        text: 'Error: Please provide exam details.',
        duration: 3000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();

      return false;
    } 

    var formData = new FormData(this); // Create a FormData object
    $.ajax({
      url: 'process_exam_upload.php',
      method: 'POST',
      data: formData,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: function(response) {
        // Handle the response from the server
        if (response.success) {
          // Display a success message
          //alert(response.message);
          Toastify({
            text: response.message,
            duration: 6000,
            gravity: 'top',
            close: true,
            style: {
              background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
            }
          }).showToast();
        } else {
          // Display an error message
          //alert(response.error);

          Toastify({
            text: response.message,
            duration: 6000,
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
       // alert('An error occurred during the file upload.');

        Toastify({
          text: 'An error occurred during the file upload. Please check the file again!',
          duration: 6000,
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