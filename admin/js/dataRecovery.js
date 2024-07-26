$(document).ready(function () {
    $('#searchBtn').on('click', function () {
        // Fetch search parameters
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var searchTerm = $('#searchTerm').val();

        // Make an Ajax request
        $.ajax({
            type: 'POST',
            url: 'dataRecovery.php',
            data: {
                startDate: startDate,
                endDate: endDate,
                searchTerm: searchTerm
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    displaySearchResults(response.users);
                } else {
                    displayMessage(response.message);
                }
            },
            error: function () {
                displayMessage('Error in the Ajax request');
            }
        });
    });

    function displaySearchResults(users) {
        var resultContainer = $('#searchResults');
        resultContainer.empty();

        if (users.length > 0) {
            var table = '<table>';
            table += '<tr><th>User ID</th><th>Name</th><th>Email</th><th>Username</th><th>Created At</th><th>Scores</th></tr>';

            $.each(users, function (index, user) {
                table += '<tr>';
                table += '<td>' + user.id + '</td>';
                table += '<td>' + user.name + '</td>';
                table += '<td>' + user.email + '</td>';
                table += '<td>' + user.username + '</td>';
                table += '<td>' + user.created_at + '</td>';
                table += '<td>' + user.scores + '</td>';
                table += '</tr>';
            });

            table += '</table>';
            resultContainer.append(table);
        } else {
            displayMessage('No results found');
        }
    }

    function displayMessage(message) {
        var resultContainer = $('#searchResults');
        resultContainer.empty();
        resultContainer.text(message);
    }
});
