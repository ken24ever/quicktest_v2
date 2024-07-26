<!DOCTYPE html>
<html lang="en">

<head>

	<title>Live Scores Test</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- vendor css -->
	<link rel="stylesheet" href="css/style.css">
	
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon.png">


 <!-- toast styling effect -->
 <link rel="stylesheet" href="./admin/node_modules/toastify-js/src/toastify.css" />


<!-- Include the jQuery library -->
<script src="jquery/jquery-3.6.0.min.js"></script>

   <!-- sweet  alert 2 lib -->
   <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
<script src="sweetalert2/dist/sweetalert2.all.min.js"></script>

    	<!-- import all custom js scripts -->
      <script src="js/login.js"></script>
</head>
<body>
<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content text-center" style="margin-top:15px;">
		<div class="card borderless">
			<div class="row align-items-center ">
				<div class="col-md-12">
					<div class="card-body">
		<img src="img/sub2.jpg" alt="" class="img-fluid mb-4" width="30%">
						<form id="candidateLogin">
							<h4 class="mb-3 f-w-400"><strong>Enter your details below to login!</strong></h4>
							<hr>
							<div class="form-group mb-3">
								<input type="text" class="form-control" name="username" id="username" placeholder="Username">
							</div>
							<div class="form-group mb-4">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							</div>			
							<hr>
							<button type="submit" name="login_btn" class="btn btn-lg btn-success mb-4">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>

<script src="bootstrap_v4/js/bootstrap.min.js"></script>

<script src="assets/js/pcoded.min.js"></script>



</body>

</html>
