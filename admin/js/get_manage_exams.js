$(document).ready(function(){

  // Function to fetch and display exams
  function fetchExams(page) {
   // Make an AJAX request to fetch the exams with pagination
   $.ajax({
     url: 'get_exams.php',
     type: 'GET',
     dataType: 'json',
     data: { page: page },
     success: function(response) {
       // Clear the existing rows in the table
       $('#examsTable tbody').empty();

       // Add each exam to the table
       $.each(response.exams, function(index, exam) {
         var tr = $('<tr>');
         tr.append($('<td>').text(exam.id));
         tr.append($('<td>').text(exam.title));
         tr.append($('<td>').text(exam.description));
         tr.append($('<td>').text(exam.duration));
         tr.append($('<td>').text(exam.num_questions));
         tr.append($('<td>').html('<div class="btn-group"><button class="btn btn-primary btn-edit">Edit</button> <button class="btn btn-danger btn-delete">Delete</button><button class="btn btn-info download">Download Questions</button></div>'));

         $('#examsTable tbody').append(tr);
       });

       // Update pagination information
       var totalPages = response.total_pages;
       updatePagination(page, totalPages);
     }
   });
 }

 // Function to update the pagination
 function updatePagination(currentPage, totalPages) {
   var paginationContainer = $('#paginationContainer');
   paginationContainer.empty();

   // Previous page button
   var previousButton = $('<li>').addClass('page-item');
   var previousLink = $('<a>').addClass('page-link').attr('href', '#').data('page', currentPage - 1).text('Previous');
   previousButton.append(previousLink);

   if (currentPage === 1) {
     previousButton.addClass('disabled');
   }

   paginationContainer.append(previousButton);

   // Page numbers
   for (var i = 1; i <= totalPages; i++) {
     var pageButton = $('<li>').addClass('page-item');
     var pageLink = $('<a>').addClass('page-link').attr('href', '#').data('page', i).text(i);
     pageButton.append(pageLink);

     if (i === currentPage) {
       pageButton.addClass('active');
     }

     paginationContainer.append(pageButton);
   }

   // Next page button
   var nextButton = $('<li>').addClass('page-item');
   var nextLink = $('<a>').addClass('page-link').attr('href', '#').data('page', currentPage + 1).text('Next');
   nextButton.append(nextLink);

   if (currentPage === totalPages) {
     nextButton.addClass('disabled');
   }

   paginationContainer.append(nextButton);
 }

 // Event handler for pagination links
 $(document).on('click', '.pagination .page-link', function(e) {
   e.preventDefault();

   // Get the page number from the clicked link's data-page attribute
   var page = $(this).data('page');

   // Call the fetchExams function with the selected page number
   fetchExams(page);
 });

 // Perform the initial fetch of exams on page load
 fetchExams(1);



   
// Handle download button click events
$(document).on("click", ".download", function() {
   // Get the exam ID
   var examId = $(this).closest("tr").find("td:first-child").text();
 
   // Initiate the download by sending a POST request to the download_questions.php script
   $.ajax({
     type: "POST",
     url: "download_questions.php",
     data: {
       examID: examId
     },
     xhrFields: {
       responseType: 'blob' // Set the response type to 'blob' to handle binary data
     },
     success: function(response, status, xhr) {
       // Save the file using FileSaver.js
       saveAs(response, "questions.xlsx");
     },
     error: function(xhr, status, error) {
       console.error('Error downloading questions: ' + error);
     }
   });
 });
   
    
   
       // Handle delete button click events
       $(document).on("click", ".btn-delete", function(){
           // Get the exam ID
           var examId = $(this).closest("tr").find("td:first-child").text();

              // Show confirmation dialog using SweetAlert
         Swal.fire({
          icon: 'question',
          html: '<b>Are you sure you want to delete exam ID: <span style="color:red">'+ examId +'</span></b>',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oh, Yep!'
      }).then((result) => {

        if (result.isConfirmed)
        {
         

              // Send the AJAX request to delete the record
              $.ajax({
                type: "POST",
                url: "delete_exam.php",
                dataType:'json',
                cache:false,
                data: { examId: examId },
                success: function(response) {
                  // Reload the table data
                       if(response.status == 'success'){

                           // Show success message with the username and exam title
                     Swal.fire({
                      icon: 'success',
                      html: '<b style="color:green">'+response.message+'</b>'
                             });
                              // Reload the exam table after the exam has been deleted
                              fetchExams();
                           
                          } else {
                                    // Show error message with the username and exam title
                     Swal.fire({
                      icon: 'error',
                      html: '<b style="color:red">'+response.message+'</b>'
                             });
                          }
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
            
         
       });
   
// Handle edit button click events
$("#manageExam").on("click", ".btn-primary", function(){
   // Get the table row and make its cells editable
   var tr = $(this).closest("tr");
   tr.find("td").prop("contenteditable", true);
   
   // Add an editing class to the row
   tr.addClass("editing");
   
   // Change the button text to "Save"
   $(this).text("Save");
   
   // Change the button class to "btn-success"
   $(this).removeClass("btn-primary");
   $(this).addClass("btn-success");
   
   // Select all buttons without the "ignore-edit" class and make them non-editable
   $("#manageExam button:not(.ignore-edit)").prop("contenteditable", false);
});

// Handle save button click events
$("#manageExam").on("click", ".btn-success", function(){
   // Get the table row and make its cells non-editable
   var tr = $(this).closest("tr");
   tr.find("td").prop("contenteditable", false);
   
   // Remove the editing class from the row
   tr.removeClass("editing");
   
   // Change the button text back to "Edit"
   $(this).text("Edit");
   
   // Change the button class back to "btn-primary"
   $(this).removeClass("btn-success");
   $(this).addClass("btn-primary");
   
   // Select all buttons without the "ignore-edit" class and make them editable again
   $("#manageExam button:not(.ignore-edit)").prop("contenteditable", true);
   
 // Send an AJAX request to update the exam
var examId = tr.find("td:first-child").text();
var examTitle = tr.find("td:nth-child(2)").text();
var examDesc = tr.find("td:nth-child(3)").text();
var examDuration = tr.find("td:nth-child(4)").text(); // update nth-child from 3 to 4


   $.ajax({
       type: "POST",
       url: "update_exam.php",
       data: {
           examId: examId,
           examTitle: examTitle,
           examDesc: examDesc,
           examDuration: examDuration
       },
       success: function(response){
           // Reload the exam table after the exam has been updated
           fetchExams();
          
            // Show display when edit is completed
       Swal.fire({
        icon: 'success',
        html: response
         });

       },
       error: function(jqXHR, textStatus, errorThrown){
           console.log(textStatus)
         //alert("Error adding exam: " + textStatus);
       }
   });
});


});
