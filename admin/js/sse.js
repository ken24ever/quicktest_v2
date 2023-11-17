$(document).ready(function() {
// Create a new EventSource instance and specify the SSE endpoint
var eventSource = new EventSource('sse.php');

// Listen for messages from the server
eventSource.addEventListener('message', function(event) {
    $('#auditTrayEntries').empty();
    // Handle the received data
    var newData = JSON.parse(event.data);
    console.log('Received SSE message:', event.data);
    // Update your UI with the new data
    newData.forEach(function(entry) {
        var row = $('<tr>');
        row.append($('<td>').text(entry.id));
        row.append($('<td>').text(entry.user_name));
        row.append($('<td>').text(entry.action));
        row.append($('<td>').text(entry.description));
        row.append($('<td>').text(entry.created_at));
        $('#auditTrayEntries').prepend(row); // Add the new row to the top of the table
    });
    
});

}); 