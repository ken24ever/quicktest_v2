
    $(document).ready(function() {
        // Populate the select dropdown with options using Select2
        function importExams() {
            $.ajax({
                url: 'examList.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var examOptions = [];
                    for (var i = 0; i < response.exams.length; i++) {
                        examOptions.push({
                            id: response.exams[i].title,
                            text: response.exams[i].title
                        });
                    }
        
                    $('.examslist').select2({
                        data: examOptions,
                        placeholder: 'Select exams name...',
                        multiple: true
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        importExams()
        
          
        
        
            
        
        });


 
