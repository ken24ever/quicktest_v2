// Function to start the timer
// Function to start the timer
function startTimer( duration, display) {
    var chartOptions = {
      chart: {
        type: 'pie',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false
      },
      title: {
        text: 'Time Remaining'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>',
        style: {
          fontSize: '34px' // Adjust the font size as desired
        }
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.y}'
          },
          innerSize: '70%',
        }
      },
      series: [{
        name: 'Time',
        colorByPoint: true,
        data: [{
          name: 'Hours',
          y: 0
        }, {
          name: 'Minutes',
          y: 0
        }, {
          name: 'Seconds',
          y: 0
        }]
      }]
    };
  
    var chart = Highcharts.chart('chart-container', chartOptions); // Create the doughnut chart
  
    var remainingTime = duration; // Set remaining time to the total duration initially
  
    var interval = setInterval(function() {
      remainingTime--; // Decrease remaining time by 1 second
  
      if (remainingTime < 0) {
        clearInterval(interval);
        // Automatically submit the exam when the timer reaches 0
        finalSubmission();
        display.text("00:00:00"); // Set the timer display to 00:00:00
        $(".simpleDisplay").text("00:00:00");
        return;
      }
  
      var hours = Math.floor(remainingTime / 3600);
      var minutes = Math.floor((remainingTime % 3600) / 60);
      var seconds = remainingTime % 60;
  
      // Update the doughnut chart data
      chart.series[0].setData([{
        name: 'Hours',
        y: hours
      }, {
        name: 'Minutes',
        y: minutes
      }, {
        name: 'Seconds',
        y: seconds
      }]);
  
      // Add leading zeros if necessary
      hours = hours < 10 ? "0" + hours : hours;
      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;
  
      // Update the timer display
      display.text(hours + ":" + minutes + ":" + seconds);
      $(".simpleDisplay").text(hours + ":" + minutes + ":" + seconds);
  
      // Check if remaining time is less than 3 minutes (180 seconds)
      if (remainingTime <= 180) {
        // Toggle the blinking effect by adding/removing the 'blink-red' class
        $(".simpleDisplay").toggleClass("blink-red");
  
        // alert("Time is less than 3 minutes!")
      }
    }, 1000);
  }
  
  