$(document).ready(function(){
<<<<<<< HEAD
  
// Constants for pagination
const ITEMS_PER_PAGE = 150;
let currentPage = 1;


// Function to render the table rows for a specific page
function renderTableRows(data, start, end, usersTableBody) {
  usersTableBody.empty();

  if (data && data.users && Array.isArray(data.users)) {
    var users = data.users;
    for (var i = start; i < end && i < users.length; i++) {
      var user = users[i];
      var userRow = $('<tr>'); // Create the user row element

      // Add data-user-id attribute to the checkbox
      var checkbox = $('<input type="checkbox" class="user-checkbox" value="' + user.id + '">');
      checkbox.attr('data-user-id', user.id);
      userRow.append($('<td>').html(checkbox)); // Append checkbox to user row

      var examStatusElement = $('<div class="exam-status-container">\
                                  <button class="btn btn-primary view-exams-btn" data-user-id="' + user.id + '">View Exams</button>\
                                  <div class="exam-status-content" data-user-id="' + user.id + '">\
                                    <ul class="exam-status-list">\
                                      <!-- Exam status details will be dynamically added here -->\
                                    </ul>\
                                  </div>\
                                </div>');
      var examStatusList = examStatusElement.find('.exam-status-list');

      if (user.exams && Array.isArray(user.exams) && user.exams.length > 0) {
        if (user.exams.length > 1) {
          examStatusElement.find('.view-exams-btn').text('View Exams (' + user.exams.length + ')');
        } else {
          examStatusElement.find('.view-exams-btn').text('View Exam');
        }

        for (var j = 0; j < user.exams.length; j++) {
          var exam = user.exams[j];
          var examItem = $('<li>').text(exam.title + ': ' + exam.status);
          examStatusList.append(examItem);
        }
      } else {
        examStatusElement.find('.view-exams-btn').text('No Exams');
      }

      // Append other user data to the user row
      userRow.append($('<td>').text(user.id));
      userRow.append($('<td>').text(user.name));
      userRow.append($('<td>').html('<img src="' + user.userPassport + '" width="50" height="50" alt="User Image">'));
      userRow.append($('<td>').text(user.username));
      userRow.append($('<td>').text(user.email));
      userRow.append($('<td>').text(user.password));
      userRow.append($('<td>').text(user.examName));
      userRow.append($('<td>').append(examStatusElement));
      usersTableBody.append(userRow);

      // Handle the click event for the "View Exams" button
      examStatusElement.find('.view-exams-btn').on('click', function() {
        var userId = $(this).data('user-id');
        $('.exam-status-content').not('[data-user-id="' + userId + '"]').hide();
        $('.exam-status-content[data-user-id="' + userId + '"]').slideToggle();
      });
    }
  } else {
    console.error('Error: Invalid data format');
  }
}


// Function to handle the search input
function handleSearchInput(data) {
  var searchQuery = $('#search-input').val();
  var filteredData = data; // Initialize with all data

  if (searchQuery) {
    filteredData = data.users.filter(function (user) {
      var username = user.username.toLowerCase();
      var name = user.name.toLowerCase();
      searchQuery = searchQuery.toLowerCase();

      // Check if the search query is present in either the username or name
      return username.includes(searchQuery) || name.includes(searchQuery); 
    });
  }

  // Render the entire table with the filtered data or original data if searchQuery is empty
  var usersTableBody = $('#users-table-body');
  if (filteredData.length > 0) {
    renderTableRows({ users: filteredData }, 0, filteredData.length, usersTableBody);
  } else {
    renderTableRows(data, 0, ITEMS_PER_PAGE, usersTableBody);
  }
}



// Function to fetch users' details with pagination
function fetchUsersDetails(page) {
  $.ajax({
    url: 'fetch_users_data.php',
    method: 'GET',
    dataType: 'json',
    data: { page: page, itemsPerPage: ITEMS_PER_PAGE },
    success: function(data) {
      // Reset currentPage to 1 when new data is fetched
      page = 1;

       // Save the data in a variable and render the initial table
       var initialData = data;
       renderTableRows(initialData, 0, ITEMS_PER_PAGE, $('#users-table-body'));
 
       // Attach an event listener to the search input to call the handleSearchInput function
       $('#search-input').on('input', function () {
         handleSearchInput(initialData); // Pass the initialData to the handleSearchInput function
       });


      // Calculate the start and end index for the current page
      var start = (page - 1) * ITEMS_PER_PAGE;
      var end = start + ITEMS_PER_PAGE;

          // Get the table body element by ID
          var usersTableBody = $('#users-table-body');

          // Render the table rows for the current page
          renderTableRows(data, start, end, usersTableBody);
    

      // Update the pagination buttons
      updatePaginationButtons(page, Math.ceil(data.totalUsers / ITEMS_PER_PAGE));
    },
    error: function(xhr, status, error) {
      console.error('Error: ' + error);
    }
  });
}



// Function to update the pagination buttons
function updatePaginationButtons(currentPage, totalPages) {
  $('#pagination').empty();

  for (var i = 1; i <= totalPages; i++) {
    var pageButton = $('<button class="btn btn-primary pagination-btn" data-page="' + i + '">' + i + '</button>');
    if (i === currentPage) {
      pageButton.addClass('active');
    }
    $('#pagination').append(pageButton);
  }

  // Remove previous click event binding to avoid conflicts
  $('.pagination-btn').off().on('click', function() {
    currentPage = $(this).data('page');
    fetchUsersDetails(currentPage);
  });
}




// Initial call to fetchUsersDetails to load the first page
fetchUsersDetails(currentPage);


 // Function to reset selected users' exams
 function resetSelectedUsersExams(userIds) {
  $.ajax({
    url: 'reset_selected_users_exam.php', // Replace with the actual PHP script path 
    method: 'POST', // Use POST method to send the user IDs
    dataType: 'json',
    data: { userIds: userIds }, // Send the user IDs as an array in the request
    success: function(data) {
      // Handle the success response here (if needed)
      if (data.status === 'success'){
        Toastify({
          text: data.message,
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
      }
      else{
        Toastify({
          text: data.message,
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
      }
      console.log(data.message);
    },
    error: function(xhr, status, error) {
      console.error('Error: ' + error);
    }
  });
}

// Handle the click event for the "Reset Selected Users Exam" button
$('#reset-exams').on('click', function() {
  var selectedUserIds = $('.user-checkbox:checked').map(function() {
    return $(this).data('user-id');
  }).get();

  // Call the function to reset selected users' exams
  resetSelectedUsersExams(selectedUserIds);
});


// Delete selected button click event
$('#deleteSelectedUsers').click(function() {
  var selectedUserIds = $('.user-checkbox:checked').map(function() {
    return $(this).data('user-id');
  }).get();

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

         // Initial call to fetchUsersDetails to load the first page
fetchUsersDetails(currentPage);

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
        // Handle error case
        Toastify({
          text: 'No User(s) Was Selected!',
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
  }
});



    // Handle the click event for the "Check All" checkbox
    $('#check-all').on('click', function() {
      $('.user-checkbox').prop('checked', $(this).prop('checked'));
    });

  
  $('#searchUserForm').submit(function(e){
=======
    $('#searchUserForm').submit(function(e){
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
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
<<<<<<< HEAD
                        url: 'reset_exams.php', 
=======
                        url: 'reset_exams.php',
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
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
<<<<<<< HEAD
            success: function(response) { 
=======
            success: function(response) {
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
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
  