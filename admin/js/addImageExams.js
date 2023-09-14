$(document).ready(function(){
    var questionCount = 0;
    var maxQuestions = 10;
    $('#addGraphicalExam').click(function(){


        if (questionCount < maxQuestions) 
        {
            questionCount++;

            //display the number of questions per click
            function countNumOfQues(){
     
         
                return output= $('.imageryQuesCount').text(questionCount)
              }
               setInterval(countNumOfQues, 1000)


            var questionFormHtml = '<div class="question-form mt-3">';
            questionFormHtml += '<h5>Question ' + questionCount + '</h5>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="question_text_' + questionCount + '">Question Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="question_text_' + questionCount + '" name="question_text_' + questionCount + '" rows="3"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="question_image_' + questionCount + '">Question Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="question_image_' + questionCount + '" name="question_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_a_text_' + questionCount + '">Option A Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="option_a_text_' + questionCount + '" name="option_a_text_' + questionCount + '" rows="2"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_a_image_' + questionCount + '">Option A Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="option_a_image_' + questionCount + '" name="option_a_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_b_text_' + questionCount + '">Option B Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="option_b_text_' + questionCount + '" name="option_b_text_' + questionCount + '" rows="2"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_b_image_' + questionCount + '">Option B Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="option_b_image_' + questionCount + '" name="option_b_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_c_text_' + questionCount + '">Option C Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="option_c_text_' + questionCount + '" name="option_c_text_' + questionCount + '" rows="2"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_c_image_' + questionCount + '">Option C Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="option_c_image_' + questionCount + '" name="option_c_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_d_text_' + questionCount + '">Option D Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="option_d_text_' + questionCount + '" name="option_d_text_' + questionCount + '" rows="2"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_d_image_' + questionCount + '">Option D Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="option_d_image_' + questionCount + '" name="option_d_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_e_text_' + questionCount + '">Option E Text:</label>';
            questionFormHtml += '<textarea class="form-control" id="option_e_text_' + questionCount + '" name="option_e_text_' + questionCount + '" rows="2"></textarea>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="option_e_image_' + questionCount + '">Option E Image:</label>';
            questionFormHtml += '<input type="file" class="form-control-file" id="option_e_image_' + questionCount + '" name="option_e_image_' + questionCount + '">';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<label for="correct_option_' + questionCount + '">Correct Option:</label>';
            questionFormHtml += '<select class="form-control" id="correct_option_' + questionCount + '" name="correct_option_' + questionCount + '">';
            questionFormHtml += '<option value=" ">SELECT ANSWER</option>';
            questionFormHtml += '<option value="a">Option A</option>';
            questionFormHtml += '<option value="b">Option B</option>';
            questionFormHtml += '<option value="c">Option C</option>';
            questionFormHtml += '<option value="d">Option D</option>';
            questionFormHtml += '<option value="e">Option E</option>';
            questionFormHtml += '</select>';
            questionFormHtml += '</div>';
            questionFormHtml += '<div class="form-group">';
            questionFormHtml += '<button type="button" class="removeQuestion btn btn-danger" data-questionCount="' + questionCount + '">Remove Question</button>';
            questionFormHtml +='</div>'
            questionFormHtml += '</div>'
            $('#GraphicalExamContainer').append(questionFormHtml);
            }
            
            })

            $('#GraphicalExamContainer').on('click', '.removeQuestion', function(){
                var questionNumber = $(this).data('questionCount');
                $(this).closest('.question-form').remove();
                questionCount--;
                for (var i = questionNumber + 1; i <= questionCount + 1; i++) {
                    var newQuestionNumber = i - 1;
                    $('.question-form:nth-child(' + i + ') h5').html('Question ' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="question_text_' + i + '"]').attr('name', 'question_text_' + newQuestionNumber).attr('id', 'question_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="question_image_' + i + '"]').attr('name', 'question_image_' + newQuestionNumber).attr('id', 'question_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="option_a_text_' + i + '"]').attr('name', 'option_a_text_' + newQuestionNumber).attr('id', 'option_a_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="option_a_image_' + i + '"]').attr('name', 'option_a_image_' + newQuestionNumber).attr('id', 'option_a_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="option_b_text_' + i + '"]').attr('name', 'option_b_text_' + newQuestionNumber).attr('id', 'option_b_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="option_b_image_' + i + '"]').attr('name', 'option_b_image_' + newQuestionNumber).attr('id', 'option_b_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="option_c_text_' + i + '"]').attr('name', 'option_c_text_' + newQuestionNumber).attr('id', 'option_c_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="option_c_image_' + i + '"]').attr('name', 'option_c_image_' + newQuestionNumber).attr('id', 'option_c_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="option_d_text_' + i + '"]').attr('name', 'option_d_text_' + newQuestionNumber).attr('id', 'option_d_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="option_d_image_' + i + '"]').attr('name', 'option_d_image_' + newQuestionNumber).attr('id', 'option_d_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') textarea[name="option_e_text_' + i + '"]').attr('name', 'option_e_text_' + newQuestionNumber).attr('id', 'option_e_text_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') input[name="option_e_image_' + i + '"]').attr('name', 'option_e_image_' + newQuestionNumber).attr('id', 'option_e_image_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') select[name="correct_option_' + i + '"]').attr('name', 'correct_option_' + newQuestionNumber).attr('id', 'correct_option_' + newQuestionNumber);
                    $('.question-form:nth-child(' + i + ') button.removeQuestion').attr('data-questionCount', newQuestionNumber);
                    }
                    });
                    

        });
           
        
        