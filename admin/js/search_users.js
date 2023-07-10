$(document).ready(function(){
    $('#searchUserForm').submit(function(e){
      e.preventDefault();
   var search = $('#searchUsername').val()
      if (search == ''){
        Toastify({
          text: "Type something in the search field!",
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
        return false;
      }
    
      searchUsers();
    });
  
    function searchUsers() {
      $.ajax({
        url: 'search_user.php',
        method: 'POST',
        data: $('#searchUserForm').serialize(),
        success: function(response){
          $("#searchUsers").html(response);
          $('#searchUserForm').trigger('reset');
        }
      });
    } 
  
    // Edit button click event
    $(document).on('click', '.edit-button', function() {
      // Retrieve the data attributes from the edit button
      var id = $(this).attr("data-id");
      var name = $(this).attr("data-name");
      var username = $(this).attr("data-username");
      var email = $(this).attr("data-email");
      var password = $(this).attr("data-password");
      var examName = $(this).attr("data-exam-name");
      var scores = $(this).attr("data-exam-scores");
  
      // Populate the form fields in the modal with the data
      $("#edit-id").val(id);
      $("#edit-name").val(name);
      $("#edit-username").val(username);
      $("#edit-email").val(email);
      $("#edit-password").val(password);
      $("#edit-examName").val(examName);
      $("#edit-scores").val(scores);
  
      // Show the edit modal
      $('#edit-modal').modal('show');
    });

    $(document).on('click', '.reset', function() {
        var username = $(this).attr('id');
        
        // Show confirmation dialog using SweetAlert
        Swal.fire({
            title: 'Reset Exams',
            html: 'Enter the Exam Name: <input id="resetCode" class="swal2-input">',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reset Exams'
        }).then((result) => 
         {
            if (result.isConfirmed)
             {
                var resetCode = $('#resetCode').val();
    
                if (resetCode.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Please enter a valid exam name.'
                    });
                } else {
                    // User confirmed and entered the reset code
                    // Send AJAX request to reset the user's exams
                    $.ajax({
                        url: 'reset_exams.php',
                        method: 'GET',
                        dataType: 'JSON',
                        data: { user: username, resetCode: resetCode },
                        success: function(response) {
                            // Show success message with the username and exam title
                            Swal.fire({
                                icon: 'success',
                                title: 'Exams Reset',
                                html: 'Exams reset for the user: ' + username + '<br>with exam title as ' + response['with exam title as']
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            }
        });
    });
    
  
    // Submit the edit form
    $(document).on('submit','#edit-form',function(e) {
      e.preventDefault();
  
      // Get the form data
      var id = $('#edit-id').val();
      var name = $('#edit-name').val();
      var username = $('#edit-username').val();
      var email = $('#edit-email').val();
      var password = $('#edit-password').val();
      var examName = $('#edit-examName').val();
      
  
      // Send the AJAX request to update the record
      $.ajax({
        url: 'editUsers.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id: id,
          name: name,
          username: username,
          email: email,
          password: password,
          examName: examName
          
        },
        success: function(response) {
          // Hide the edit modal
          $('#edit-modal').modal('hide');

            // Show success message with the username and exam title
            Swal.fire({
              icon: 'success',
              html: response.message
          });

          // Reload the table data
          $('#table-container').load('table.php');
        }
      });
    });
  
    $(document).on('click', '.delete-button', function() {
        var username = $(this).attr("id");


         // Show confirmation dialog using SweetAlert
         Swal.fire({
          icon: 'question',
          html: '<b>Are you sure you want to delete  <span style="color:red">'+ username +'</span></b>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oh, Yep!'
      }).then((result) => {

        if (result.isConfirmed)
        {

               // Send the AJAX request to delete the record
          $.ajax({
            url: 'deleteUsers.php',
            type: 'POST',
            data: { username: username },
            success: function(response) {
              // Reload the table data
              
               // Show success message with the username and exam title
                 Swal.fire({
                            icon: 'success',
                            html: '<b style="color:green">'+response+'</b>'
                         });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus)
              //alert("Error adding exam: " + textStatus);
            }
          });//end of ajax request

        }//end of result.isConfirmed
        else {

   // Show display when you click cancel
   Swal.fire({
    icon: 'info',
    html: '<b>You backed out!</b>'
     });
        }//end of else

      })//end of thenable
        
      
      });//end of on click delete user
    });    
  