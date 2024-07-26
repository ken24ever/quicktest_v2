$(document).ready(function () {
 // Define constants for pagination
 const ITEMS_PER_PAGE = 500; // Number of items per page
 let currentPage = 1; // Current page
 
 
 // Function to handle the search input within the table
 function handleSearchInput(searchQuery) {
   searchQuery = searchQuery.toLowerCase(); // Convert search query to lowercase for case-insensitive search
   var visibleRows = $('#users-table-body').find('tr'); // Get all visible rows in the table body
 
   visibleRows.each(function () {
     var row = $(this);
     var username = row.find('td:nth-child(3)').text().toLowerCase(); // Adjust the index based on the column containing username
     var name = row.find('td:nth-child(1)').text().toLowerCase(); // Adjust the index based on the column containing name
     var password = row.find('td:nth-child(5)').text().toLowerCase();
     if (username.includes(searchQuery) || name.includes(searchQuery) || password.includes(searchQuery)) {
       row.show(); // Show the row if it matches the search query
     } else {
       row.hide(); // Hide the row if it does not match the search query
     }
   });
 }
 
 // Event listener for search input changes
 $('#search-input').on('input', function () {
   var searchQuery = $(this).val();
   handleSearchInput(searchQuery);
 });
 
 
 
 // Function to fetch users' details with pagination
 function fetchUsersDetails() {
   $.ajax({
     url: 'fetch_users_data.php',
     method: 'GET',
     dataType: 'json',
     success: function (data) {
       // Save the data in a variable
       const usersData = data.users;
 
       // Calculate total pages based on the number of users and items per page
       const totalPages = Math.ceil(usersData.length / ITEMS_PER_PAGE);
 
       // Update pagination buttons
       updatePaginationButtons(currentPage, totalPages, usersData);
 
       // Display initial page
       renderTableRows(usersData, 0, ITEMS_PER_PAGE, $('#users-table-body'));
 
         
     },
     error: function (xhr, status, error) {
       console.error('Error: ' + error);
     }
   });
 }
 
 // Call fetchUsersDetails initially
 fetchUsersDetails();
 
 /* // Function to render table rows for a specific page with checkboxes
 function renderTableRows(data, start, end, usersTableBody) {
   usersTableBody.empty();
 
   if (data && Array.isArray(data)) {
     for (var i = start; i < end && i < data.length; i++) {
       var user = data[i];
       var userRow = $('<tr>'); // Create the user row element
 
       
 
       // Add data-user-id and data-user-name attributes to the checkbox
       var checkbox = $('<input type="checkbox" class="user-checkbox" value="' + user.id + '">');
       checkbox.attr('data-user-id', user.id);
       checkbox.attr('data-user-name', user.name);
       userRow.append($('<td>').html(checkbox)); // Append checkbox to user row
 
       
 
       // Append other user data to the user row
       userRow.append($('<td>').text(user.id));
       userRow.append($('<td>').text(user.name));
       userRow.append($('<td>').html('<img src="' + user.userPassport + '" width="50" height="50" alt="User Image">'));
       userRow.append($('<td>').text(user.username));
       userRow.append($('<td>').text(user.email));
       userRow.append($('<td>').text(user.password));
       userRow.append($('<td>').text(user.application));
       userRow.append($('<td>').text(user.examName));
       userRow.append($('<td>').text(user.examStatusElement));
    
 
       // Append the user row to the table body
       usersTableBody.append(userRow);
     }
   } else {
     console.error('Error: Invalid data format');
   }
 } */
 
 function renderTableRows(data, start, end, usersTableBody) {
  usersTableBody.empty();

  if (data && Array.isArray(data)) {
    for (var i = start; i < end && i < data.length; i++) {
      var user = data[i];
      var userRow = $('<tr>'); // Create the user row element

      // Add data-user-id and data-user-name attributes to the checkbox
      var checkbox = $('<input type="checkbox" class="user-checkbox" value="' + user.id + '">');
      checkbox.attr('data-user-id', user.id);
      checkbox.attr('data-user-name', user.name);
      userRow.append($('<td>').html(checkbox)); // Append checkbox to user row

      // Create an element for displaying exam details (including a button and list)
      var examStatusElement = $('<div class="exam-status-container">\
                                 <button class="btn btn-primary view-exams-btn" data-user-id="' + user.id + '">View Exams</button>\
                                 <div class="exam-status-content" data-user-id="' + user.id + '">\
                                   <ul class="exam-status-list">\
                                     \
                                   </ul>\
                                 </div>\
                               </div>');
      var examStatusList = examStatusElement.find('.exam-status-list');

/*       if (user.exams && Array.isArray(user.exams) && user.exams.length > 0) {
        var viewExamsText = user.exams.length > 1 ? 'View Exams (' + user.exams.length + ')' : 'View Exam';
        examStatusElement.find('.view-exams-btn').text(viewExamsText);

        for (var j = 0; j < user.exams.length; j++) {
          var exam = user.exams[j];
          var examItem = $('<li>').text(exam.title + ': ' + exam.status);
          examStatusList.append(examItem);
        }
      } else {
        examStatusElement.find('.view-exams-btn').text('No Exams');
      } */

      if (user.exams && Array.isArray(user.exams) && user.exams.length > 0) {
        var viewExamsText = user.exams.length > 1 ? 'View Exams (' + user.exams.length + ')' : 'View Exam';
        examStatusElement.find('.view-exams-btn').text(viewExamsText);
      
        for (var j = 0; j < user.exams.length; j++) {
          var exam = user.exams[j];
          var examItem = $('<li>').text(exam.title + ': ' + exam.status);
          examStatusList.append(examItem);
      
          // Get the button element for this exam
          var examButton = examStatusElement.find('.view-exams-btn');
      
          // Set button background color based on exam status
          switch (exam.status.toLowerCase()) {
            case 'in_progress':
              examButton.css('background-color', 'orange'); // Change to dark yellow
              examButton.css('color', '#000000')
              
              break;
            case 'pending':
              // No change needed, default blue remains
              break;
            case 'completed':
              examButton.css('background-color', 'MediumSeaGreen'); // Change to light green
              examButton.css('color', '#000000')
              
              break;
            default:
              console.warn('Unknown exam status:', exam.status); // Handle unknown status
          }
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
      userRow.append($('<td>').text(user.application));
      userRow.append($('<td>').text(user.examName));
      userRow.append($('<td>').append(examStatusElement));

      // Append the user row to the table body
      usersTableBody.append(userRow);

      // Handle the click event for the "View Exams" button
      examStatusElement.find('.view-exams-btn').on('click', function () {
        var userId = $(this).data('user-id');
        $('.exam-status-content').not('[data-user-id="' + userId + '"]').hide();
        $('.exam-status-content[data-user-id="' + userId + '"]').slideToggle();
      });
    }
  } else {
    console.error('Error: Invalid data format');
  }
}

 
 // Function to update pagination buttons including "Next", "Previous", and Eclipse pagination
 function updatePaginationButtons(currentPage, totalPages, usersData) {
   const pagination = $('#pagination');
   pagination.empty();
 
   // Previous button
   const prevButton = $('<button class="btn btn-primary pagination-btn">Previous</button>');
   if (currentPage === 1) {
     prevButton.prop('disabled', true);
   } else {
     prevButton.on('click', function () {
       currentPage--;
       renderTableRows(usersData, (currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE, $('#users-table-body'));
       updatePaginationButtons(currentPage, totalPages, usersData);
     });
   }
   pagination.append(prevButton);
 
   // Eclipse style pagination
   const eclipsePages = 5; // Number of pages to show around the current page
   let startPage = Math.max(1, currentPage - eclipsePages);
   let endPage = Math.min(totalPages, currentPage + eclipsePages);
 
   if (endPage - startPage < eclipsePages * 2) {
     if (startPage === 1) {
       endPage = Math.min(totalPages, startPage + eclipsePages * 2);
     } else if (endPage === totalPages) {
       startPage = Math.max(1, endPage - eclipsePages * 2);
     }
   }
 
   for (let i = startPage; i <= endPage; i++) {
     const pageButton = $('<button class="btn btn-primary pagination-btn">' + i + '</button>');
     if (i === currentPage) {
       pageButton.addClass('active');
     }
     pageButton.on('click', function () {
       currentPage = i;
       renderTableRows(usersData, (currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE, $('#users-table-body'));
       updatePaginationButtons(currentPage, totalPages, usersData);
     });
     pagination.append(pageButton);
   }
 
   // Next button
   const nextButton = $('<button class="btn btn-primary pagination-btn">Next</button>');
   if (currentPage === totalPages) {
     nextButton.prop('disabled', true);
   } else {
     nextButton.on('click', function () {
       currentPage++;
       renderTableRows(usersData, (currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE, $('#users-table-body'));
       updatePaginationButtons(currentPage, totalPages, usersData);
     });
   }
   pagination.append(nextButton);
 }

// Function to reset selected users' exams
function resetSelectedUsersExams(userIds) {
  // Show loader while waiting for AJAX response
  showLoader();

  $.ajax({
    url: 'reset_selected_users_exam.php',
    method: 'POST',
    dataType: 'json',
    data: { userIds: userIds },
    success: function (data) {
      // Hide loader after AJAX response is received
      hideLoader();

      Toastify({
        text: data.message,
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
      console.log(data.message);
    },
    error: function (xhr, status, error) {
      // Hide loader in case of an error
      hideLoader();

      console.error('Error: ' + error);
    }
  });
}

// Function to show loader
function showLoader() {
  // Create a loader element and append it to the body
  var loader = $('<div>').addClass('loader');
  $('body').append(loader);
}

// Function to hide loader
function hideLoader() {
  // Remove the loader element from the body
  $('.loader').remove();
}


// Handle the click event for the "Reset User Exams" button
$('#reset-exams').on('click', function () {
  var selectedUserIds = $('.user-checkbox:checked').map(function () {
    return $(this).data('user-id');
  }).get();

  var selectedUserCount = selectedUserIds.length;
  var selectedUserName = (selectedUserCount > 1) ? selectedUserCount + ' users' : $('.user-checkbox:checked').first().data('user-name');

  Swal.fire({
    title: 'Are You Sure?',
    text: 'You want to reset exams for ' + selectedUserName + '?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, reset it!'
  }).then((result) => {
    if (result.isConfirmed) {
      resetSelectedUsersExams(selectedUserIds);
    }
  });
});


// Function to reset selected users' exams
function batchLogOut(userIds) {

    // Show loader while waiting for AJAX response
    showLoader();

  $.ajax({
    url: 'batchLogOut.php', 
    method: 'POST',
    dataType: 'json',
    data: { userIds: userIds },
    success: function (data) {

            // Hide loader after AJAX response is received
            hideLoader();

      Toastify({
        text: data.message,
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
      console.log(data.message);
    },
    error: function (xhr, status, error) {
      console.error('Error: ' + error);
            // Hide loader in case of an error 
            hideLoader();
    }
  });
}




// Handle the click event for the "Reset User Exams" button
$('#logoutUsers').on('click', function () {
  var selectedUserIds = $('.user-checkbox:checked').map(function () {
    return $(this).data('user-id');
  }).get();

  var selectedUserCount = selectedUserIds.length;
  var selectedUserName = (selectedUserCount > 1) ? selectedUserCount + ' users' : $('.user-checkbox:checked').first().data('user-name');

  Swal.fire({
    title: 'Are You Sure?',
    text: 'You want to log out for ' + selectedUserName + '?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, logout!'
  }).then((result) => {
    if (result.isConfirmed) {
      batchLogOut(selectedUserIds);
    }
  });
});


  // Delete selected button click event
  $('#deleteSelectedUsers').click(function () {
    var selectedUserIds = $('.user-checkbox:checked').map(function () {
      return $(this).data('user-id');
    }).get();

    if (selectedUserIds.length > 0) {
      var selectedUserCount = selectedUserIds.length;
      var selectedUserName = (selectedUserCount > 1) ? selectedUserCount + ' users' : $('.user-checkbox:checked').first().data('user-name');

      Swal.fire({
        title: 'Are You Sure?',
        text: 'You want to delete: ' + selectedUserName + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteSelectedUsers(selectedUserIds);
        }
      });

    } else {
      // Show a message that no users are selected
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

  // Function to delete selected users
  function deleteSelectedUsers(userIds) {

        // Show loader while waiting for AJAX response
        showLoader();

    $.ajax({
      url: 'usersBatchDel.php',
      method: 'POST',
      data: { userIds: userIds },
      dataType: 'json',
      success: function (response) {

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

          // Initial call to fetchUsersDetails to load the first page
          fetchUsersDetails(currentPage);

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
      error: function () {
        // Handle error case
              // Hide loader in case of an error
      hideLoader();
      }
    });
  }

  // Handle the click event for the "Check All" checkbox
  $('#check-all').on('click', function () {
    $('.user-checkbox').prop('checked', $(this).prop('checked'));
  });

  $('#searchUserForm').submit(function (e) {
    e.preventDefault();
    var search = $('#searchUsername').val()
    if (search == '') {
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
      success: function (response) {
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
    if (result.isConfirmed) {
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
      });
    } else {
      // Show display when you click cancel
      Swal.fire({
        icon: 'info',
        html: '<b>You backed out!</b>'
      });
    }
  });
 });
});
