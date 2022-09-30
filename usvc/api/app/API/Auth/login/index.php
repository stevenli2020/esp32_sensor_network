
<html lang="en">
<head>
	<title>Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../updatePassword/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../updatePassword/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../updatePassword/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../updatePassword/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../updatePassword/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../updatePassword/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../updatePassword/css/util.css">
	<link rel="stylesheet" type="text/css" href="../updatePassword/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../updatePassword/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form">
					<span class="login100-form-title">
						Login
					</span>

					<!-- <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz"> -->
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" id="login-username" type="text" name="email" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" id="login-password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>					
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick="login()" id="login-submit-btn" style="margin-bottom: 100px;">
							Submit
						</button>
					</div>
					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->

					<!-- <div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> -->
				</form>
				            
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="../updatePassword/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../updatePassword/vendor/bootstrap/js/popper.js"></script>
	<script src="../updatePassword/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../updatePassword/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../updatePassword/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
    <script src="../../../JS/config.js"></script>
	<script src="../../../JS/login.js"></script>

</body>
</html>