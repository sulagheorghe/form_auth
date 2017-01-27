	<?php 
	include ('login.php');

	?>

	<html>
		<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <script src="js\logValid.js"></script>

			<title>User Authentification</title>
			
		</head>
	<body >
		<div class="container auth-tab" >
			<div class="modal-body">
				<div class="well">

					<ul class="nav nav-tabs">
						<li class="active">
							<a href="index.php">Login</a>
						</li>
						<li>
						<a href="register.php" >Create Account</a>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active">	

							<form action="" class="form-horizontal" method="POST">
								<div id="legend">
									<legend >Login</legend>
								</div>
								<div class="control-group"><span class="required"> Required fields * </span></div>

								
								<!--username-->
								<div class="control-group">
									<label for="username" class="control-label">Username</label>
									<div class="controls">
									<input type="text" id="username" name="username" placeholder="username" maxlength="25">
									<span class="required">*</span>
									</div>
								</div>
								<!--password-->
								<div class="control-group">
									<label for="password" class="control-label">Password</label>
									<div class="control">
									<input type="password" id="password" name="password" placeholder="password" maxlength="35">	
									<span class="required">*</span>
									</div>
								</div>

								<!--Login button-->

								<div class="control-group media">
									<div class="control">
									<input type="submit" class="btn btn-succes" id="submit" value="Log in"></input>
									</div>
								</div>
									<span class="text-danger col-md-offset-4">
									<?php if(isset($message))
									echo $message; 
									?>
									</span>


							</form>
							
						</div>
						


					</div>
				</div>
			</div>	
			</div>

	</body>
	</html>