$(document).ready(function () {
  // Define global variables to store counts
  var inProgressCount = 0;
  var completedCount = 0;
  var transactionCount = 0;
  var dataSize = 0;

  // Set an interval to update the chart every 1000 milliseconds
  setInterval(function () {
    fetchExamData();
    $('#transactionCount').html('Transaction Count: ' + transactionCount);
    $('#inProgressCount').html('Active Exams: ' + inProgressCount);
    $('#totalUsers').html('Total Users: ' + dataSize);
   
  }, 10000);

  // Function to fetch exam data and update the chart
  function fetchExamData() {
    $.ajax({
      url: 'fetchExamData.php',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        // Check if data is undefined or null
        if (!data) {
          console.error('Error: No data received from the server.');
          return;
        }

        // Update the in-progress count, completed count, and transaction count
        inProgressCount = data.inProgressCount;
        completedCount = data.completedCount;
        transactionCount = data.transactionCount;
        dataSize = data.totalUsers;
       
        // Update the progress bars based on the percentage of active exams and completed exams
        var percentageForIn_progress = (inProgressCount / dataSize) * 100;
        var percentageForCompleted = (completedCount / dataSize) * 100;
               // check if the percentageForIn_progress is NaN
        if (isNaN(percentageForIn_progress)){
          percentageForIn_progress = 0;
        }
        
   /*      if (isNaN(percentageForCompleted)){
          percentageForCompleted = 0;
        } */
        updateProgressBar(percentageForIn_progress,inProgressCount );

        // Show the percentage tips
        showPercentageTips(percentageForIn_progress);

        // Update the doughnut chart and check for peak level engagement
        updateDoughnutChart(percentageForIn_progress, percentageForCompleted, transactionCount);

            // Threshold and Peak Level Check
    checkForPeakLevelEngagement(data.thresholdStatus);
      },
      error: function (xhr, status, error) {
        console.error('Error: ' + error);
      }
    });
  }

  // Function to update the doughnut chart based on the in-progress count
  function updateDoughnutChart(percentageForIn_progress, percentageForCompleted, transactionCount) {
   
    // Round up the values to the nearest whole number
    var roundedIn_progress = Math.ceil(percentageForIn_progress);
    var roundedCompleted = Math.ceil(percentageForCompleted);
     

    // Check if Highcharts is defined
    if (typeof Highcharts !== 'undefined') {
      // Get the doughnut chart container
      var chartContainer = $('#doughnutChartContainer');

      // Initialize or update the chart
      if (!chartContainer.highcharts()) {
        chartContainer.highcharts({
          chart: {
            type: 'pie',
          },
          title: {
            text: 'Exam Analysis Breakdown <br> <span style="font-size: 12px !important; font-weight: bold; color: #808080;">Info: ' + transactionCount + 'Engagement</span>',
            style: {
              color: '#808080', // Grey color for the title
            },
          },
          plotOptions: {
            pie: {
              innerSize: '70%', // Adjust the size of the doughnut hole
              dataLabels: {
                enabled: true,
                format: '{point.name}: {point.y:.0f}%' // Include the percentage sign in the label
              },
              showInLegend: true,
            },
          },
          series: [
            {
              name: 'Exams',
              data: [
                { name: 'In Progress', y: roundedIn_progress, color: '#3498db' },
                { name: 'Completed', y: roundedCompleted, color: '#2ecc71' },
              ],
            },
          ],
        });
      } else {
        // Update the existing chart with new data
        var chart = chartContainer.highcharts();
        chart.series[0].setData([
          { name: 'In Progress', y: roundedIn_progress, color: '#3498db' },
          { name: 'Completed', y: roundedCompleted, color: '#2ecc71' },
        ]);
        // Update the chart title with adjusted font-size
chart.setTitle({
  text: '<h2>Exam Analysis Breakdown</h2> <br> INFO: ' + transactionCount + ' Engagement(s) Within 5 Minutes ',
  style: {
    fontSize: '13px', // Adjust the font size as needed
  },
});
      }
    } else {
      console.error('Highcharts library is not loaded.');
    }


  }

  // Function to update the progress bar based on the percentage
  function updateProgressBar(percentageForIn_progress, inProgressCount) {
    var elem = $('#myBar');
   

    var barColor = getProgressBarColor(percentageForIn_progress);

    elem.stop().animate({ width: percentageForIn_progress + '%' }, 500);

    // Show tooltip if the threshold is exceeded and inProgressCount is greater than 250
    if (percentageForIn_progress > 60 && inProgressCount > 250) {
      $('#tooltip').show();
    } else {
      $('#tooltip').hide();
    }

    // Use .css() to set the background color directly
    elem.css('background-color', barColor);
  }

  // Function to get the progress bar color based on the percentage and the inProgressCount is greater than 250
  function getProgressBarColor(percentageForIn_progress, inProgressCount) {
    // Set the color to red when the percentage exceeds 60%, otherwise use the default color
    var barColor = percentageForIn_progress > 60  && inProgressCount > 250 ? 'red' : '#04AA6D'; // Change '#04AA6D' to your desired default color
    //console.log('Bar Color:', barColor);
    return barColor;
  }

  // Function to show percentage tips
  function showPercentageTips(percentageForIn_progress) {
    var percentageTips = $('#percentageTips');
    percentageTips.html('(Progress: ' + Math.ceil(percentageForIn_progress) + '%)');
  }

// Function to check for peak level engagement and display a message alert
function checkForPeakLevelEngagement(thresholdStatus) {
    // Display a message alert based on the threshold status
    switch (thresholdStatus) {
        case 'Normal':
            // No action needed for normal engagement
            $('#peakLevel').hide();
            break;
        case 'Cautionary':
            // Cautionary range, may require attention
            // Implement actions or notifications as needed
            $('#peakLevel').text('Cautionary Engagement: The engagement is in a cautionary range.').show();
            break;
        case 'Critical':
            // Critical range, potential concerns
            // Implement actions or alerts, e.g., notify administrators
            $('#peakLevel').text('Critical Engagement: The engagement is at its peak level.').show();
            break;
        default:
            // Handle unexpected threshold status
            console.error('Unexpected threshold status: ' + thresholdStatus);
            break;
    }
}


  // Call the fetchExamData function initially
  fetchExamData();
});
