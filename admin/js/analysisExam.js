// exams analysis script section
$(document).ready(function () {
  // Define global variables to store counts
  var inProgressCount = 0;
  var completedCount = 0;
  var dataSize = 0;

  // Set an interval to update the chart every 1000 milliseconds
  setInterval(function () {
    fetchExamData();
    $('#inProgressCount').html('Active Exams: ' + inProgressCount);
  }, 1000);

  // Function to fetch exam data and update the chart
  function fetchExamData() {

    $.ajax({
      url: 'fetchExamData.php',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        // Log the values used in the calculation
      

        // Check if data is undefined or null
        if (!data) {
          console.error('Error: No data received from the server.');
          return;
        }

        // Update the in-progress count
        inProgressCount = data.inProgressCount;

        // Uncomment if needed: Update the completed exams count
        completedCount = data.completedCount;

        // Save the data size in a variable
        dataSize = data.totalUsers; // Move this line here

        // Update the progress bars based on the percentageForIn_progress of active exams and completed exams
        var percentageForIn_progress = (inProgressCount / dataSize) * 100;
        var percentageForCompleted = (completedCount / dataSize) * 100;
   
        updateProgressBar(percentageForIn_progress);

        // Show the percentage tips
        showPercentageTips(percentageForIn_progress);

        // Update the doughnut chart
        updateDoughnutChart(percentageForIn_progress, percentageForCompleted);
      },
      error: function (xhr, status, error) {
        console.error('Error: ' + error);
      }
    });
  }

  // Function to update the doughnut chart based on the in-progress count
  function updateDoughnutChart(percentageForIn_progress, percentageForCompleted) {


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
            text: 'Exam Analysis Breakdown',
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
                // Uncomment if needed
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
          // Uncomment if needed
           { name: 'Completed', y: roundedCompleted, color: '#2ecc71' },
        ]);
      }
    } else {
      console.error('Highcharts library is not loaded.');
    }
  }

// Function to update the progress bar based on the percentage
function updateProgressBar(percentageForIn_progress) {
  var elem = $('#myBar');
  var barColor = getProgressBarColor(percentageForIn_progress);

  elem.stop().animate({ width: percentageForIn_progress + '%' }, 500);

    // Show tooltip if the threshold is exceeded
    if (percentageForIn_progress > 60) {
      $('#tooltip').show();
    } else {
      $('#tooltip').hide();
    }

  // Use .css() to set the background color directly
  elem.css('background-color', barColor);

}

// Function to get the progress bar color based on the percentage
function getProgressBarColor(percentageForIn_progress) {
  // Set the color to red when the percentage exceeds 60%, otherwise use the default color
  var barColor = percentageForIn_progress > 60 ? 'red' : '#04AA6D'; // Change '#04AA6D' to your desired default color
  console.log('Bar Color:', barColor);
  return barColor;
}




  // Function to show percentage tips
  function showPercentageTips(percentageForIn_progress) {
    var percentageTips = $('#percentageTips');
    percentageTips.html('(Progress: ' + Math.ceil(percentageForIn_progress) + '%)');
  }

  // Call the fetchExamData function initially
  fetchExamData();
});
// end of exams analysis script
