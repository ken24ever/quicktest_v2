$(document).ready(function() {
    var currentPage = 1;
    var entriesPerPage = 500; // Number of entries to display per page
 
// Function to fetch and display audit trail entries
function fetchAuditTrailEntries(page) {
  $.ajax({
    url: 'get_audit_tray_entries.php?action=ajax&page=' + page, 
    method: 'GET',
    dataType: 'json',
   // data: { page: page },
    success: function(response) {
      if (response.success) {
        // Clear existing table entries
        $('#auditTrayEntries').empty();

        // Create the "Select All" checkbox 
        var selectAllCheckbox = $('<input>').attr({ 
          type: 'checkbox',
          id: 'selectAllCheckbox'
        });

        // Create the table header row with checkboxes
        var headerRow = $('<tr>');
        var headerCheckboxCell = $('<th>').append(selectAllCheckbox);
        headerRow.append(headerCheckboxCell);
        headerRow.append($('<th>').text('ID'));
        headerRow.append($('<th>').text('User'));
        headerRow.append($('<th>').text('Action'));
        headerRow.append($('<th>').text('Description'));
        headerRow.append($('<th>').text('Created At'));
        $('#auditTrayEntries').append(headerRow);

        // Iterate through each entry and append to the table
        response.data.forEach(function(entry) {
          var row = $('<tr>');

          // Add a checkbox for each row
          var checkboxCell = $('<td>').append($('<input>').attr({
            type: 'checkbox',
            class: 'selectEntryCheckbox',
            'data-entry-id': entry.id
          }));
          row.append(checkboxCell);

          // Add other columns
          row.append($('<td>').text(entry.id));
          row.append($('<td>').text(entry.user_name));
          row.append($('<td>').text(entry.action));
          row.append($('<td>').text(entry.description));
          row.append($('<td>').text(entry.created_at));

          $('#auditTrayEntries').append(row);
        });

        // Handle "Select All" checkbox change event
        selectAllCheckbox.change(function() {
          var isChecked = $(this).prop('checked');
          $('.selectEntryCheckbox').prop('checked', isChecked);
        });

        // Update pagination links
        initializePagination(response.total_pages, page);
      } else {
        // Handle error
        console.error('Failed to fetch audit trail entries');
      }
      
    },
    error: function(xhr, status, error) {
      console.error('Error: ' + error);
    }
  });
}

  
    
    // Fetch and display audit trail entries on page load
    fetchAuditTrailEntries(currentPage);

      // Set up SSE event listener
      setupSSEListener(); 

    // Function to set up SSE event listener
function setupSSEListener() {
  // Create a new EventSource instance and specify the SSE endpoint
  var eventSource = new EventSource('get_audit_tray_entries.php?action=sse'); // Specify the action parameter

  // Listen for messages from the server
  eventSource.addEventListener('message', function(event) {
      // Handle the received data
      var newData = JSON.parse(event.data);
      

        // Create the "Select All" checkbox 
        var selectAllCheckbox = $('<input>').attr({ 
          type: 'checkbox',
          id: 'selectAllCheckbox'
        });

        // Create the table header row with checkboxes
        var headerRow = $('<tr>');
        var headerCheckboxCell = $('<th>').append(selectAllCheckbox);
        headerRow.append(headerCheckboxCell);
        headerRow.append($('<th>').text('ID'));
        headerRow.append($('<th>').text('User'));
        headerRow.append($('<th>').text('Action'));
        headerRow.append($('<th>').text('Description'));
        headerRow.append($('<th>').text('Created At'));
        $('#auditTrayEntries').append(headerRow);

        // Iterate through each entry and append to the table
        newData.forEach(function(entry) {
          var row = $('<tr>');

          // Add a checkbox for each row
          var checkboxCell = $('<td>').append($('<input>').attr({
            type: 'checkbox',
            class: 'selectEntryCheckbox',
            'data-entry-id': entry.id
          }));
          row.append(checkboxCell);

          // Add other columns
          row.append($('<td>').text(entry.id));
          row.append($('<td>').text(entry.user_name));
          row.append($('<td>').text(entry.action));
          row.append($('<td>').text(entry.description));
          row.append($('<td>').text(entry.created_at));

          $('#auditTrayEntries').prepend(row);
        });

        // Handle "Select All" checkbox change event
        selectAllCheckbox.change(function() {
          var isChecked = $(this).prop('checked');
          $('.selectEntryCheckbox').prop('checked', isChecked);
        });


 
     // console.log('Received SSE message:', event.data);
  });
}
    
     
    // Function to fetch and display filtered audit trail entries with pagination
function fetchFilteredEntries(userFilter, dateFilter, searchQuery, page) {
    $.ajax({
      url: 'get_filtered_audit_tray_entries.php',
      method: 'POST',
      dataType: 'json',
      data: {
        userFilter: userFilter,
        dateFilter: dateFilter,
        searchQuery: searchQuery,
        page: page,
        entriesPerPage: entriesPerPage, // You should define this variable elsewhere
      },
      success: function(response) {
        if (response.success) {
          // Clear existing table entries 
          $('#auditTrayEntries').empty();
  
          // Create the "Select All" checkbox
          var selectAllCheckbox = $('<input>').attr({
            type: 'checkbox',
            id: 'selectAllCheckbox'
          });
  
          // Create the table header row with checkboxes
          var headerRow = $('<tr>');
          var headerCheckboxCell = $('<th>').append(selectAllCheckbox);
          headerRow.append(headerCheckboxCell);
          headerRow.append($('<th>').text('ID'));
          headerRow.append($('<th>').text('User'));
          headerRow.append($('<th>').text('Action'));
          headerRow.append($('<th>').text('Description'));
          headerRow.append($('<th>').text('Created At'));
          $('#auditTrayEntries').append(headerRow);
  
          // Iterate through each entry and append to the table
          response.data.forEach(function(entry) {
            var row = $('<tr>');
  
            // Add a checkbox for each row
            var checkboxCell = $('<td>').append($('<input>').attr({
              type: 'checkbox',
              class: 'selectEntryCheckbox',
              'data-entry-id': entry.id
            }));
            row.append(checkboxCell);
  
            // Add other columns
            row.append($('<td>').text(entry.id));
            row.append($('<td>').text(entry.user_name));
            row.append($('<td>').text(entry.action));
            row.append($('<td>').text(entry.description));
            row.append($('<td>').text(entry.created_at));
  
            $('#auditTrayEntries').append(row);
          });
  
          // Handle "Select All" checkbox change event
          selectAllCheckbox.change(function() {
            var isChecked = $(this).prop('checked');
            $('.selectEntryCheckbox').prop('checked', isChecked);
          });
  
          // Update pagination with the total number of entries and reset to page 1
          initializePagination(response.totalPages, page);
  
        } else {
          // Handle error
          console.error('Failed to fetch filtered audit trail entries');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + error);
      }
    });
  }
  


// Event listener for filters and search
$('#userFilter, #dateFilter, #searchQuery').on('change', function () {
  // Get the values of the filter and search inputs
  var userFilter = $('#userFilter').val();
  var dateFilter = $('#dateFilter').val();
  var searchQuery = $('#searchQuery').val();

  // Fetch total number of filtered entries and update pagination on success
  $.ajax({
    url: 'get_total_filtered_entries.php', // URL to fetch total number of filtered entries
    method: 'GET',
    dataType: 'json',
    data: {
      userFilter: userFilter,
      dateFilter: dateFilter,
      searchQuery: searchQuery
    },
    success: function (response) {
      if (response.success) {
        // Update pagination with the total number of entries and reset to page 1
        initializePagination(response.totalPages, 1); // Reset to page 1

        // Fetch and display filtered entries for the first page
        fetchFilteredEntries(userFilter, dateFilter, searchQuery, 1); // Fetch first page
      } else {
        // Handle error
        console.error('Failed to get total filtered entries');
      }
    },
    error: function (xhr, status, error) {
      console.error('Error: ' + error);
    }
  });
});

// Event listener for pagination clicks
$('.page-link').on('click', function () {
  var userFilter = $('#userFilter').val();
  var dateFilter = $('#dateFilter').val();
  var searchQuery = $('#searchQuery').val();
  var page = $(this).data('page');

  // Fetch and display filtered entries for the selected page
  fetchFilteredEntries(userFilter, dateFilter, searchQuery, page);
});

  

  // Function to fetch and display audit trail entries with filters and pagination
function fetchFilteredEntries(userFilter, dateFilter, searchQuery, page, entriesPerPage) {
    $.ajax({
      url: 'get_filtered_entries.php',
      method: 'GET',
      dataType: 'json',
      data: {
        userFilter: userFilter,
        dateFilter: dateFilter,
        searchQuery: searchQuery,
        page: page,
        entriesPerPage: entriesPerPage // Pass entriesPerPage to server
      },
      success: function(response) {
        if (response.success) {
          // Clear existing table entries
          $('#auditTrayEntries').empty();
  
        // Create the "Select All" checkbox
        var selectAllCheckbox = $('<input>').attr({
            type: 'checkbox',
            id: 'selectAllCheckbox'
          });
  
         // Create the table header row with checkboxes
         var headerRow = $('<tr>');
         var headerCheckboxCell = $('<th>').append(selectAllCheckbox);
         headerRow.append(headerCheckboxCell);
         headerRow.append($('<th>').text('ID'));
         headerRow.append($('<th>').text('User'));
         headerRow.append($('<th>').text('Action'));
         headerRow.append($('<th>').text('Description'));
         headerRow.append($('<th>').text('Created At'));
         $('#auditTrayEntries').append(headerRow);
 
         // Iterate through each entry and append to the table
         response.data.forEach(function(entry) {
           var row = $('<tr>');
 
           // Add a checkbox for each row
           var checkboxCell = $('<td>').append($('<input>').attr({
             type: 'checkbox',
             class: 'selectEntryCheckbox',
             'data-entry-id': entry.id
           }));
           row.append(checkboxCell);
 
           // Add other columns
           row.append($('<td>').text(entry.id));
           row.append($('<td>').text(entry.user_name));
           row.append($('<td>').text(entry.action));
           row.append($('<td>').text(entry.description));
           row.append($('<td>').text(entry.created_at));
 
           $('#auditTrayEntries').append(row);
         });
  
          // Handle "Select All" checkbox change event
          selectAllCheckbox.change(function() {
            var isChecked = $(this).prop('checked');
            $('.selectEntryCheckbox').prop('checked', isChecked);
          });
  
  
          // Update pagination links
          initializePagination(response.totalPages, currentPage, entriesPerPage);
        } else {
          // Handle error
          console.error('Failed to fetch audit trail entries');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error: ' + error);
      }
    });
  }

        // Add export functionality
        try {
          var exportButton = $('#exportExcelBtn');
          exportButton.off('click'); // Remove any existing click event handlers
          exportButton.on('click', function() {
            var selectedEntries = [];

            // Iterate through each checked checkbox and get its data-entry-id
            $('.table tbody tr').each(function() {
              var checkbox = $(this).find('input[type="checkbox"]');
              if (checkbox.prop('checked')) {
                selectedEntries.push(checkbox.val());
              }
            });

            if (selectedEntries.length === 0) {
              Toastify({
                text: 'No user(s) selected for export.',
                duration: 5000,
                gravity: 'top',
                close: true,
                style: {
                  background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
                }
              }).showToast();
              return;
            }

            // Create a new table and add selected rows
            var selectedRows = [];
            $('.table tbody tr').each(function() {
              var checkbox = $(this).find('input[type="checkbox"]');
              if (checkbox.prop('checked')) {
                selectedRows.push($(this).clone());
              }
            });

            var clonedTable = $('<table>').append($('<tbody>').append(selectedRows));

            // Convert the table to a workbook and save as Excel
            var workbook = XLSX.utils.table_to_book(clonedTable[0], { sheet: 'Sheet 1' });
            XLSX.writeFile(workbook, 'audit_tray.xlsx');
          });
        } catch (error) {
          console.error('Export error:', error);
        }
         // End Of Add export functionality

// Function to initialize pagination with ellipsis
function initializePagination(totalPages, currentPage) {
    var paginationContainer = $('#auditTrayPagination');
    paginationContainer.empty();
  
    // Define the maximum number of visible page links
    var maxVisiblePages = 1; // Adjust this value as needed
  
    // Create previous button
    var previousButton = $('<a>').attr('href', '#').addClass('page-link').text('Previous');
    if (currentPage === 1) {
      previousButton.addClass('disabled');
      previousButton.addClass('text-danger');
    } else {
      previousButton.click(function (e) {
        e.preventDefault();
        var page = currentPage - 1;
        fetchAuditTrailEntries(page);
      });
    }
  
    // Create next button
    var nextButton = $('<a>').attr('href', '#').addClass('page-link').text('Next');
    if (currentPage === totalPages) {
      nextButton.addClass('disabled');
      nextButton.addClass('text-danger');
    } else {
      nextButton.click(function (e) {
        e.preventDefault();
        var page = currentPage + 1;
        fetchAuditTrailEntries(page);
      });
    }
  
    // Create pagination container
    var paginationList = $('<ul>').addClass('pagination justify-content-center');
    var previousListItem = $('<li>').addClass('page-item').append(previousButton);
    var nextListItem = $('<li>').addClass('page-item').append(nextButton);
  
    // Calculate the range of visible page links
    var startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    var endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
  
    // Add ellipsis before the first page if needed
    if (startPage > 1) {
      var firstPageLink = $('<a>').attr('href', '#').addClass('page-link').text('1');
      firstPageLink.click(function (e) {
        e.preventDefault();
        fetchAuditTrailEntries(1);
      });
      var firstPageListItem = $('<li>').addClass('page-item').append(firstPageLink);
      paginationList.append(firstPageListItem);
      if (startPage > 2) {
        paginationList.append($('<li>').addClass('page-item').append($('<span>').addClass('page-link').text('...')));
      }
    }
  
    // Create page links
    for (var i = startPage; i <= endPage; i++) {
      var link = $('<a>').attr('href', '#').addClass('page-link').text(i);
      if (i === currentPage) {
        link.addClass('active');
      }
  
      // Bind click event to fetch transactions for the clicked page
      link.click(function (e) {
        e.preventDefault();
        var page = parseInt($(this).text());
        fetchAuditTrailEntries(page);
      });
  
      var listItem = $('<li>').addClass('page-item').append(link);
      paginationList.append(listItem);
    }
  
    // Add ellipsis after the last page if needed
    if (endPage < totalPages) {
      if (endPage < totalPages - 1) {
        paginationList.append($('<li>').addClass('page-item').append($('<span>').addClass('page-link').text('...')));
      }
      var lastPageLink = $('<a>').attr('href', '#').addClass('page-link').text(totalPages);
      lastPageLink.click(function (e) {
        e.preventDefault();
        fetchAuditTrailEntries(totalPages);
      });
      var lastPageListItem = $('<li>').addClass('page-item').append(lastPageLink);
      paginationList.append(lastPageListItem);
    }
  
    paginationList.prepend(previousListItem);
    paginationList.append(nextListItem);
    paginationContainer.append(paginationList);
  }
    
  

  
  });
  