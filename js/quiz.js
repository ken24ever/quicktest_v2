$(document).ready(function() {
    // Retrieve the exam details
    $.ajax({
        url: 'get_exam_details.php', // Replace with the actual PHP script that retrieves the exam details
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Display the exam details on the page
            $('#exam-title').text(response.title);
            $('#exam-duration').text('Duration: ' + response.duration + ' minutes');
            $('#exam-instructions').text(response.instructions);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    // Proceed button click event
    $('#proceed-button').click(function() {
        // Redirect the user to the quiz page
        window.location.href = 'quiz_questions.php';
    });
});
