$(document).ready(function () {
    // Handle add admin user form submission
    $("#addAdminForm").submit(function (event) {
        event.preventDefault(); // Prevent form from submitting normally

        var adminName = $("#adminName").val();
        var adminEmail = $("#adminEmail").val();
        var adminUsername = $("#adminUsername").val();
        var adminPassword = $("#adminPassword").val();
        var adminConfirmPassword = $("#adminConfirmPassword").val();
        var accessLevel = $("#accessLevel").val();


    // Check if any input or select fields are empty
    var emptyFields = $(this).find('input, select').filter(function() {
        var value = $(this).val();
        return !value || $.trim(value) === '';
      });
  
      // If any fields are empty, display an error message
      if (emptyFields.length > 0) {
        Toastify({
          text: "Please Fill In All The Required Fields!",
          duration: 5000,
          gravity: 'top',
          close: true,
          style: {
            background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
          }
        }).showToast();
      }

        // Check if passwords match
        if (adminPassword !== adminConfirmPassword) {
            //alert("Passwords do not match. Please try again.");

            Toastify({
                text: "Passwords do not match. Please try again.",
                duration: 5000,
                gravity: 'bottom',
                close: true,
                style: {
                  background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
                }
              }).showToast();
            return;
        }

        // Send add admin user request to PHP backend
        $.ajax({
            type: "POST",
            url: "add_admin.php",
            data: {
                adminName: adminName,
                adminEmail: adminEmail,
                adminUsername: adminUsername,
                adminPassword: adminPassword,
                accessLevel: accessLevel
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    //alert("Admin user added successfully.");
                    Toastify({
                        text: "Admin user added successfully.",
                        duration: 5000,
                        gravity: 'bottom',
                        close: true,
                        style: {
                          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
                        }
                      }).showToast();
                    // Clear form fields after successful addition
                    $("#adminName").val("");
                    $("#adminEmail").val("");
                    $("#adminUsername").val("");
                    $("#adminPassword").val("");
                    $("#adminConfirmPassword").val("");
                    $("#accessLevel").val("2"); // Reset Access Level to default
                } else {
                    //alert("Failed to add admin user. Please try again.");
                    Toastify({
                        text: "Failed to add admin user. Please try again.",
                        duration: 5000,
                        gravity: 'bottom',
                        close: true,
                        style: {
                          background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
                        }
                      }).showToast();
                }
            },
            error: function () {
                //alert("An error occurred while processing your request.");
                Toastify({
                    text: "An error occurred while processing your request.",
                    duration: 5000,
                    gravity: 'bottom',
                    close: true,
                    style: {
                      background: 'linear-gradient(to right, #FFA0A0, #B88AFF, #A0A0FF)',
                    }
                  }).showToast();
            }
        });
    });
});