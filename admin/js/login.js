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
<<<<<<< HEAD
          username: username, 
          password: password
        },
        dataType: 'json',
=======
          username: username,
          password: password
        },
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
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
  
<<<<<<< HEAD
          if (response.success) {
=======
          if (response === "") {
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
            // Successful login, show success message with SweetAlert
            Swal.fire({
              icon: 'success',
              title: 'Login Successful',
              text: 'You have been logged in successfully.',
              timer: 3000, // Show the alert for 3 seconds
              showConfirmButton: false
            });
  
            // Redirect to the dashboard after the success message
            setTimeout(function() {
              window.location.href = 'http://localhost/cbt_exam/admin/adm_dashboard.php';
            }, 3000);
          } else {
            // Error occurred, show error message with SweetAlert
            Swal.fire({
              icon: 'error',
              title: 'Login Failed',
              text: response
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
  