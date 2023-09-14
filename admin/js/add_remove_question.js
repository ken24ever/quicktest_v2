<<<<<<< HEAD
var questionCount = 0; // Initialize with one question
$(document).ready(function(){
  var maxQuestions = 10; // Maximum number of questions that can be added

=======
$(document).ready(function(){
  var maxQuestions = 10; // Maximum number of questions that can be added
  var questionCount = 0; // Initialize with one question
   
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7


  $("#addQuestionBtn").click(function(){
    if(questionCount < maxQuestions){
      questionCount++;
      function countNumOfQues(){ 
   
       
        return output= $('.countQuestions').text(questionCount)
      }
       setInterval(countNumOfQues, 1000)
      var questionHTML = '<div class="card mt-3">' +
        '<div class="card-body">' +
          '<h5 class="card-title">Question ' + questionCount + '</h5>' +
          '<div class="form-group">' +
            '<label for="question' + questionCount + '">Question:</label>' +
            '<textarea class="form-control" id="question' + questionCount + '" name="question' + questionCount + '" rows="3" required></textarea>' +
          '</div>' +
          '<div class="form-group">'+
          '<label for="question_image_' + questionCount + '">Question Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-primary" id="question_image_' + questionCount + '" name="question_image_' + questionCount + '">'+
          '</div>'+
          '<div class="form-group">' +
            '<input type="hidden" class=" form-control" name="question_count" id="question_count" value="'+ questionCount + '" required>' +
          '</div>' +
      
          '<div class="form-group">' +
            '<label for="option1' + questionCount + '">Option A:</label>' +
            '<input type="text" class=" form-control" id="option_a' + questionCount + '" name="option_a' + questionCount + '" placeholder="Enter option A" required>' +
          '</div>' +
          '<div class="form-group">'+
          '<label for="option_a_image_' + questionCount + '">Option A Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-dark" id="option_a_image_' + questionCount + '" name="option_a_image_' + questionCount + '">'+
          '</div>'+

          '<div class="form-group">' +
            '<label for="option2' + questionCount + '">Option B:</label>' +
            '<input type="text" class=" form-control" id="option_b' + questionCount + '" name="option_b' + questionCount + '" placeholder="Enter option B" required>' +
          '</div>' +
          '<div class="form-group">'+
          '<label for="option_b_image_' + questionCount + '">Option B Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-dark" id="option_b_image_' + questionCount + '" name="option_b_image_' + questionCount + '">'+
          '</div>'+

          '<div class="form-group">' +
            '<label for="option3' + questionCount + '">Option C:</label>' +
            '<input type="text" class=" form-control" id="option_c' + questionCount + '" name="option_c' + questionCount + '" placeholder="Enter option C" required>' +
          '</div>' +
          '<div class="form-group">'+
          '<label for="option_c_image_' + questionCount + '">Option C Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-dark" id="option_c_image_' + questionCount + '" name="option_c_image_' + questionCount + '">'+
          '</div>'+

          '<div class="form-group">' +
            '<label for="option4' + questionCount + '">Option D:</label>' +
            '<input type="text" class=" form-control" id="option_d' + questionCount + '" name="option_d' + questionCount + '" placeholder="Enter option D" required>' +
          '</div>'+
          '<div class="form-group">'+
          '<label for="option_d_image_' + questionCount + '">Option D Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-dark" id="option_d_image_' + questionCount + '" name="option_d_image_' + questionCount + '">'+
          '</div>'+

          '<div class="form-group">' + 
            '<label for="option5' + questionCount + '">Option E:</label>' +
            '<input type="text" class="form-control" id="option_e' + questionCount + '" name="option_e' + questionCount + '" placeholder="Enter option E" required>' +
          '</div>' +
          '<div class="form-group">'+
          '<label for="option_e_image_' + questionCount + '">Option E Image <b>(Optional)</b>:</label>'+
          '<br><input type="file" class="btn btn-dark" id="option_e_image_' + questionCount + '" name="option_e_image_' + questionCount + '">'+
          '</div>'+

<<<<<<< HEAD
        // Updated section for checkboxes
      '<div class="form-group">' +
      '<label for="correct' + questionCount + '">Correct Answer:</label><br>' +
      '<label class="checkbox-label"><input type="checkbox" name="correct' + questionCount + '[]" value="A"> Option A</label><br>' +
      '<label class="checkbox-label"><input type="checkbox" name="correct' + questionCount + '[]" value="B"> Option B</label><br>' +
      '<label class="checkbox-label"><input type="checkbox" name="correct' + questionCount + '[]" value="C"> Option C</label><br>' +
      '<label class="checkbox-label"><input type="checkbox" name="correct' + questionCount + '[]" value="D"> Option D</label><br>' +
      '<label class="checkbox-label"><input type="checkbox" name="correct' + questionCount + '[]" value="E"> Option E</label><br>' +
      '</div>' +
=======
          '<div class="form-group">' +
            '<label for="correct' + questionCount + '">Correct Answer:</label>' +
            '<select class="form-control" id="correct' + questionCount + '" name="correct' + questionCount + '" required>' +
            '<option value="">Select Correct Answer</option>' +  
            '<option value="A">Option A</option>' +
              '<option value="B">Option B</option>' +
              '<option value="C">Option C</option>' +
              '<option value="D">Option D</option>' +
              '<option value="E">Option E</option>' +
            '</select>' +
          '</div>' +
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7

          '<button type="button" class="btn btn-danger remove-question-btn">Remove Question</button>' +

        '</div>' +

      '</div>';
      $("#questionsContainer").append(questionHTML);
    } else {
      Toastify({
        text: "You have reached the maximum number of questions!",
        duration: 5000,
        gravity: 'top',
        close: true,
        style: {
          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
        }
      }).showToast();
    }
  });

  $("#questionsContainer").on("click", ".remove-question-btn", function(){
    $(this).closest(".card").remove();
    questionCount--;
  });
});
