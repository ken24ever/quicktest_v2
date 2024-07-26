$(document).ready(function() {
  $("#loginForm").submit(function(event) {
      event.preventDefault();

      var username = $('#username').val();
      var password = $('#password').val();

      // Check if input fields are not empty
      if (username === '' || password === '') {
          Toastify({
              text: 'Error: Please provide login details.',
              duration: 5000,
              gravity: 'top',
              close: true,
              style: {
                  background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
              }
          }).showToast();

          return false;
      }

      $.ajax({
          url: 'login.php', 
          method: 'POST',
          data: {
              username: username,
              password: password
          },
          dataType: 'json',
          beforeSend: function() {
              var modalContent = '<div class="loading-modal">' +
                  '  <img src="../img/quickTest.png" alt="" width="110" height="80" alt="Loading" />' +
                  '</div>';

              // Create a modal element and add the loading content
              var modalElement = $('<div>').addClass('modal').append(modalContent);

              // Append the modal element to the document body
              $('body').append(modalElement);

              // Show the modal
              modalElement.modal({ backdrop: 'static', keyboard: false });
          },
          success: function(response) {
              $('.modal').modal('hide'); // Hide the modal

              if (response.success) {
                  // Successful login,  show success message with SweetAlert
                  Swal.fire({
                      icon: 'success',
                      title: 'Login Successful',
                      text: 'You have been logged in successfully.',
                      timer: 3000, // Show the alert for 3 seconds
                      showConfirmButton: false
                  });

                  // Redirect to the dashboard after the success message
                  setTimeout(function() {
                      window.location.href = 'adm_dashboard.php';
                  }, 3000);
              } 
               if (!response.success ) {
                  // Error occurred, show error message with SweetAlert
                  Swal.fire({
                      icon: 'error',
                      title: 'Login Failed',
                      text: response.message
                  });
              }
          },
          error: function(xhr, status, error) {
              // Handle error case
              $('.modal').modal('hide'); // Hide the modal

              // Show error message with SweetAlert
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'An error occurred while processing your request.'
              });
          },
          complete: function() {
              $('.modal').remove(); // Remove the modal element from the document body
          }
      });
  });
});
