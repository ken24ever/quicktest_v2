var match = ['.xls', '.xlt', '.xla', '.xlam', '.xltx', '.xlsx', '.xlsm', '.xltm']; // define allowed file extensions here

function validateFileType(file) {
  var fileName = file.name;
  var fileExtension = fileName.substr(fileName.lastIndexOf('.')).toLowerCase();
  if (match.indexOf(fileExtension) === -1) {
    return false; // File extension doesn't match
  }
  return true; // All file extensions match
}

// Image preview on file input change with file size validation
$(document).on('change', '#user_batch_file', function() {
  var files = $(this)[0].files; // Get selected files

  for (var i = 0; i < files.length; i++) {
    if (!validateFileType(files[i])) {
      Toastify({
        text: "Error: System Can Only Accept Data File In Microsoft Excel Formats!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
      $(this).val(''); // Clear the file input field
      return false; // File extension doesn't match
    }
  }
});






// Submit form event handler
$(document).on('submit','#addUserForm1',function(event) {
    event.preventDefault(); // Prevent default form submission

              
              // Check if any input or select fields are empty
     var emptyFields = $(this).find('input, select').filter(function() {
      var value = $(this).val();
      return !value || $.trim(value) === '';
    });

    // If any fields are empty, display an error message
    if (emptyFields.length > 0) {
      //$('#errorMessage').text('Please fill in all the required fields.').show();
      Toastify({
        text: "Input Field Cannot Be Empty, Select A File!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();

    } else {
      var formData = new FormData(this); // Create a FormData object
      $.ajax({
        url: 'batch_upload.php', 
        method: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
          // Handle the response from the server
          if (response.success) {
            // Display a success message
           // alert(response.message);
  
            Toastify({
              text: response.message,
              duration: 5000,
              gravity: 'bottom',
              close: true,
              style: {
                background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
              }
            }).showToast();
          } else {
            // Display an error message
            //alert(response.error);
  
            Toastify({
              text: response.error,
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
          alert('An error occurred during the file upload.');
        }
      });
    }  // end of else


  });
  