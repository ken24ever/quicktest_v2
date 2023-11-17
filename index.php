<!DOCTYPE html>
<html>
<head>
  <title>QuickTest | CBT Application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap_v4/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">


  <!-- Include the jQuery library -->
  <script src="jquery/jquery-3.6.0.min.js"></script>

  <style>
   /* Font import */
   @import url('./bubblegumFont/BubblegumSans-Regular.ttf');

    /* Custom CSS for the layout */ 
    body {
      background-image: url('img/image.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      animation: zoomInBackground 40s infinite;
    }

    @keyframes zoomInBackground {
      0% {
        background-size: 110% 110%;
      }
      100% {
        background-size: 100% 100%;
      }
    }

    .container {
      display: flex;
      justify-content: flex-start;
      align-items: flex-start;
      height: 100vh;
    }

    .column1 {
  padding-right: 0px; /* Adjust the padding value as per your preference */
  background-color: rgba(255, 255, 255, 0.9);
}
/* small logo style */


    .flash {
      animation: flashing 2s infinite;
    }

    @keyframes flashing {
      0% { opacity: 1; }
      50% { opacity: 0; }
      100% { opacity: 1; }
    }

    /* Instructions section font */
    .card-body {
      font-family: 'Bubblegum Sans', cursive;
      font-size: 25px;
      background-color: rgba(255, 255, 255, 0.5);
      padding: 20px;
      border-radius: 10px;
    }

    /* Login button font */
    .btn-login {
      font-family: 'Bubblegum Sans', cursive;
      font-size: 30px;
      
    }

    /* Navbar brand font */
    .navbar-brand {
      font-family: 'Bubblegum Sans', cursive;
    }

      /* Define the heartbeat animation */
  @keyframes heartbeat {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }

  /* Apply the heartbeat animation to the image */
  .heartbeat-image {
    animation: heartbeat 4s infinite;
  }
  </style>
</head> 
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-md bg-white navbar-dark">
  <a class="navbar-brand text-dark" href="#"><img src="img/quickTest.png" alt="" width="80" height="80" class="heartbeat-image"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
  <ul class="navbar-nav ml-auto"> <!-- Added 'ml-auto' class -->
     
    
      <li class="nav-item">
        <a class="nav-link text-dark" href="#"> <b>Contact Us</b> </a>
      </li>    
    </ul>
  </div>
</nav>

<!-- Single column layout -->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-12 column1">
      <div class="accordion" id="accordionInstructions">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Instructions
                
               
              </button>
            </h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionInstructions">
            <div class="card-body">
              <!-- Insert your instructions here -->
              <p>Welcome to the <span style="font-family: 'Bubblegum Sans', cursive;">QUICKTEST</span> App!</p>
              <p>Please follow the steps below:</p>
              <ul style="list-style-type: none;">
                <li>Step 1: Login to your account using the provided credentials.</li>
                <li>Step 2: Navigate to the desired section or exam.</li>
                <li>Step 3: Read the instructions carefully before starting the exam.</li>
                <li>Step 4: Answer the questions to the best of your ability.</li>
                <li>Step 5: Submit your answers when you are done.</li>
              </ul>
              <a href="login.php"><button class="btn btn-primary flash btn-login">Login</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="bootstrap_v4/js/bootstrap.min.js"></script>
</body>
</html>
