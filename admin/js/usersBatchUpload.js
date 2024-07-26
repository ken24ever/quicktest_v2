var match = ['.xls', '.xlt', '.xla', '.xlam', '.xltx', '.xlsx', '.xlsm']; // define allowed file extensions here

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
        text: "Error: System Can Only Accept Data File In Microsoft Excel Formats",
        duration: 5000,
        gravity: 'top',
        close: true,
        backgroundColor: "#ff0000",
      }).showToast();
      return; // Exit if any file extension doesn't match
    }
  }

  // Validate file size if required
});

$(document).on('submit', '#addUserForm1', function(e) {
  e.preventDefault();

  // Check if any input or select fields are empty
  var emptyFields = $(this).find('input, select').filter(function() {
    var value = $(this).val();
    return !value || $.trim(value) === '';
  });

  // If any fields are empty, display an error message
  if (emptyFields.length > 0) {
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
  

    var formData = new FormData(this);

    $.ajax({
      url: 'batch_upload.php',
      type: 'POST',
      beforeSend: function(){ 
         // Show loader while waiting for AJAX response
        showLoader();},
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        hideLoader();

        var toastBackgroundColor = "#4fbe87"; // Default green color for success
        var message = response.message;

        if (response.success) {
          if (response.matchedRecordsCount > 0) {
            message += ' ' + response.matchedRecordsCount + ' duplicate users found.';
            toastBackgroundColor = "#ff0000"; // Red color for matched records

            // Create a clickable button within the Toastify notification
            Toastify({
              text: message,
              duration: 5000,
              gravity: 'top',
              close: true,
              backgroundColor: toastBackgroundColor,
              onClick: function() {
                // Display matched records in the modal with MatchedRecordsPagination
                if (response.matchedRecords && response.matchedRecords.length > 0) {
                  showMatchedRecords(response.matchedRecords);
                }
              }
            }).showToast();
          } else {
            Toastify({
              text: message,
              duration: 5000,
              gravity: 'top',
              close: true,
              backgroundColor: toastBackgroundColor,
            }).showToast();
          }
        } else {
          toastBackgroundColor = "#ffcc00"; // Dark yellow color for errors
          Toastify({
            text: response.error,
            duration: 5000,
            gravity: 'top',
            close: true,
            backgroundColor: toastBackgroundColor,
          }).showToast();
        }
      },
      error: function(xhr, status, error) {
        hideLoader();
        Toastify({
          text: "An error occurred while uploading the file.",
          duration: 5000,
          gravity: 'top',
          close: true,
          backgroundColor: "#ffcc00", // Dark yellow color for errors
        }).showToast();
      }
    });
  }
});

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

// Function to show matched records with MatchedRecordsPagination
function showMatchedRecords(records) {
  var recordsPerPage = 10;
  var totalRecords = records.length;
  var totalPages = Math.ceil(totalRecords / recordsPerPage);
  var currentPage = 1;

  function renderPage(page) {
    var start = (page - 1) * recordsPerPage;
    var end = start + recordsPerPage;
    var paginatedRecords = records.slice(start, end);

    var matchedTableBody = $('#matchedRecordsTable tbody');
    var matchedTableTitle = $('.modal-title')

    matchedTableTitle.empty(); // Clear any previous titles
    matchedTableBody.empty(); // Clear any previous rows

    matchedTableTitle.html("<p style='font-size:35px !important'>Count Of Records Matched: <b style='color: red !important'>( "+totalRecords+" )</b> </p>")
    
    paginatedRecords.forEach(function(record) {
      var row = '<tr>' +
        '<td>' + record.id + '</td>' +
        '<td>' + record.name + '</td>' +
        '<td>' + record.email + '</td>' +
        '<td>' + record.username + '</td>' +
        '</tr>';
      matchedTableBody.append(row);

    });

    updateMatchedRecordsPagination(page);
  }

  function updateMatchedRecordsPagination(page) {
    var MatchedRecordsPagination = $('#MatchedRecordsPagination');
    MatchedRecordsPagination.empty(); // Clear previous MatchedRecordsPagination

    var previousButton = $('<button>').text('Previous').prop('disabled', page === 1).click(function() {
      if (currentPage > 1) {
        currentPage--;
        renderPage(currentPage);
      }
    });
    MatchedRecordsPagination.append(previousButton);

    var startPage = Math.max(1, page - 2);
    var endPage = Math.min(totalPages, page + 2);

    if (startPage > 1) {
      MatchedRecordsPagination.append($('<span>').text('...'));
    }

    for (var i = startPage; i <= endPage; i++) {
      var pageButton = $('<button>').text(i).addClass(i === page ? 'active' : '').click(function() {
        var newPage = parseInt($(this).text());
        currentPage = newPage;
        renderPage(currentPage);
      });
      MatchedRecordsPagination.append(pageButton);
    }

    if (endPage < totalPages) {
      MatchedRecordsPagination.append($('<span>').text('...'));
    }

    var nextButton = $('<button>').text('Next').prop('disabled', page === totalPages).click(function() {
      if (currentPage < totalPages) {
        currentPage++;
        renderPage(currentPage);
      }
    });
    MatchedRecordsPagination.append(nextButton);
  }

  renderPage(currentPage);

  // Show the modal
  $('#matchedRecordsModal').modal('show');
}
