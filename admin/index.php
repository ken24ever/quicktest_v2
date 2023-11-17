<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
<?php
session_start();

// Check if the user is logged in and has the Super Admin access level
if (isset($_SESSION['user_id'])) {
    // Redirect to the login page if not authenticated or authorized
    header("Location: adm_dashboard.php");
   // exit();
}
?>
<<<<<<< HEAD
=======
=======


>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
<!DOCTYPE html>
<html>
<head>
  <title>CBT Application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap_v4/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon.png">
   <!-- toast styling effect -->
   <link rel="stylesheet" href="node_modules/toastify-js/src/toastify.css" />


  <!-- Include the jQuery library -->
<<<<<<< HEAD
  <script src="jquery/jquery-3.6.0.min.js"></script> 
=======
  <script src="jquery/jquery-3.6.0.min.js"></script>
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742

     <!-- sweet  alert 2 lib -->
     <link rel="stylesheet" href="../sweetalert2/dist/sweetalert2.min.css">
<script src="../sweetalert2/dist/sweetalert2.all.min.js"></script>

  <style>
   /* Font import */
   @import url('../bubblegumFont/BubblegumSans-Regular.ttf');

<<<<<<< HEAD
    /* Custom CSS for the layout */
    body {
      background-image: url('../img/admin.png');
=======
<<<<<<< HEAD
    /* Custom CSS for the layout */ 
    body {
      background-image: url('../img/login.png');
=======
    /* Custom CSS for the layout */
    body {
      background-image: url('../img/admin.png');
>>>>>>> 6a18945e5e75c81531b1898c231a67172bfdc3d7
>>>>>>> c4384ae4e664a8dce411d4549ad4b7f4bbe6f742
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

  /* Modal container */
.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

/* Modal content */
.modal-content {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

/* Loading image */
.loading-modal img {
  display: block;
  margin: 0 auto;
}

  </style>

  	<!-- import all custom js scripts -->
    <script src="js/login.js"></script>
</head>
<body>

<!-- toast effect -->
<script src="node_modules/toastify-js/src/toastify.js"></script>

<!-- Navbar -->
<nav class="navbar navbar-expand-md bg-white navbar-dark">
  <a class="navbar-brand text-dark" href="#"><img src="../img/quickTest.png" alt="" width="80" height="80" class="heartbeat-image"></a>
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
                Get Into Your Dashboard
                
               
              </button>
            </h5>
          </div>
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionInstructions">
            <div class="card-body">
            <form id="loginForm">
                <h3 class="text-center mb-3">Admin Login</h3>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="text" name="username" id="username" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" >
                </div>
                <button type="submit" name="login_btn" class="btn btn-primary btn-block">Login</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../bootstrap_v4/js/bootstrap.min.js"></script>
</body>
</html>
