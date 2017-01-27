	<?php 
	include('connect.php');

	

		//remove injected charachters
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	class UserIp{

		const TIMEOUT_HOUR = 1;
		public $ipAdress;

		 function __construct()
		 {
		 	//getting ip from client
		 	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $this->ipAdress=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $this->ipAdress=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else	{
	      $this->ipAdress=$_SERVER['REMOTE_ADDR'];
	    }
		 }

		 public function getIp()
		 {
		 	return $this->ipAdress;
		 }

		public function isBlackListed()
		{
			include('connect.php');
			$query = "SELECT * from `users` WHERE `ip_adress`= '".$this->ipAdress."' and TIMESTAMPDIFF(minute,reg_date,NOW())<".self::TIMEOUT_HOUR . ";";
			$result = mysqli_query($db_connect, $query);

			if( mysqli_num_rows($result) != 0 )
				return true;
			else 
				return false;
		}


	}



	$error=false;
	//data entry valiadtion
	if ($_SERVER["REQUEST_METHOD"] == "POST")//if submit was pressed
	{	
		$userIp =  new UserIp();
		if ( $userIp->isBlackListed() ) {

			$error = true;
			$message = "Only one registration is allowed during ". UserIP::TIMEOUT_HOUR ." hours";
		}
		$ip_adress = $userIp->getIp();


		$newuser = test_input($_POST['newuser']);
		$firstname= test_input($_POST['firstname']);
		$lastname = test_input($_POST['lastname']);
		$email= test_input($_POST['email']);
		$password= test_input($_POST['newpass']);
		$password_conf= test_input( $_POST['newpass1'] );
		$date_of_birth = $_POST['birthdate'];

		if ( !empty($newuser) ) {
			if (strlen($newuser) < 3)	{
				$usererr = "User must have at least 3 charachters!";
				$error=true;
			}
		}	
		else {		
			$usererr = "Please provide an username!<br>";
			$error=true;
		}
		
		if ( !empty($firstname) ) 	{
			if (strlen($firstname) < 2)		{
				$firsterr= "Firstname should be at least 2 charachters!";
				$error=true;
			}
		}
		else	{	
			$firsterr="Please provide the firstname!<br>";
			$error=true;
		}

		if ( !empty( $lastname ))	{
			
			if (strlen($lastname) < 2)		{
				$lasterr= "Firstname should be at least 2 charachters!";
				$error=true;
			}
		}
		else	{	
			$lasterr="Please provide the lastname!<br>";
			$error=true;
		}
		if ( !empty($email) )	{		
			if ( !filter_var ($email, FILTER_VALIDATE_EMAIL))		{
				$emailerr= "Please provide a valid email";
				$error=true;
			}
			else		{
				$query = "select * from users where email = '$email' ";
				$result = mysqli_query($db_connect,$query);
				$count = mysqli_num_rows($result);

				if($count != 0){
					$emailerr = "Provided email is already used";
					$error=true;
				}

			}
		}
		else	{	
			$emailerr="Please provide an email address!<br>";
			$error=true;
		}

		if ( !empty( $password ) ) 	{
			if (strlen($password) <=8) 		{
				$passerr= "Password must be at least 8 charachters";
				$error=true;
			}
			else
			{
				$pass= hash("sha256",$password);
			}

		}
		else	{	
			$passerr="Please provide a password!<br>";
			$error=true;
		}

		if ( empty( $password_conf ) ) {
			$passErrorConf="Please  confirm the password!<br>";
			$error=true;
		}
		else 
		{
			$passwordConf= hash("sha256",$password_conf);
		}

		if ((isset($pass) && isset($passwordConf)) && ($pass!== $passwordConf) ){
			$passErrorConf = "Passwords do not match!";
			$error=true;
		}

		if ( isset($date_of_birth ) ) {

			$dateOfBirth=date("Y-m-d",strtotime($date_of_birth));
			
			if ($dateOfBirth > date("Y-m-d") )	{
				$birthError ="Your birthdate can`t be later than today";
				$error=true;
			}
		}
		else
		{	
			$birthError= "Please select your birthdate!<br>";
			$error=true;
		}	
	  
	  	
	    if (!$error)   {	
	        $insert = "INSERT INTO `users`  (`nickname`, `firstname`, `lastname`, `email`, `password`, `birthdate`, `ip_adress`) VALUES  ('$newuser', '$firstname', '$lastname','$email', '$pass', '$dateOfBirth', '$ip_adress');";
	       
	    	 $signUp = mysqli_query($db_connect,$insert);	

	    	 	   	if($signUp){
	    	 	   		$message = "You have been succesfully signed up!";

	    	 	   		}	
	    	 	   		else{
	    	 	   		$message = "Something went wrong! Try again later! ";	
	    	 	   		}	 

	    }
	}


	 ?>

	<html>
			<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<link rel="stylesheet" href="style.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		  <script src="js\RegValid.js"></script>
				<title>User Registration</title>
				
			</head>

	<body>
	<div class="container auth-tab" >
				<div class="modal-body">
					<div class="well">

						<ul class="nav nav-tabs">
							<li>
								<a href="/form_auth/index.php">Login</a>
							</li>
							<li class="active">
							<a href="/form_auth/register.php" >Create Account</a>
							</li>
						</ul>

						<div class="tab-content">
						<div class="tab-pane active" >

								<form action="register.php" method="POST" id="tab" class=" form-horizontal">
								<div id="legend">
								<legend>Register</legend>
								</div>
									<div class="control-group"><span class="required"> Required fields * </span></div>
									<div class="row">								
									<label for="newuser" class="col-xs-12 col-md-4">Username</label>								
									<input type="text" name="newuser" id="newuser"  placeholder=""  class="col-xs-9 col-md-7 ">			
									<span class="required">*</span>				
									</div>
									<span class="text-danger col-md-offset-4">
										<?php if(isset($usererr))
										echo $usererr;  ?>
									</span>	
									

									<div class="row media">
									<label for="firstname" class="col-xs-12 col-md-4">Firstname</label>									
									<input type="text" name="firstname" id="firstname" placeholder="" class="col-xs-9 col-md-7">		
									<span class="required">*</span>						
									</div>
									<span class="text-danger col-md-offset-4">
										<?php if(isset($firsterr))
										echo $firsterr;  ?>
									</span>	

									<div class="row media">
									<label for="lastname" class="col-xs-12 col-md-4">Lastname</label>								
									<input type="text" name="lastname" id="lastname" placeholder=""  class="col-xs-9 col-md-7">
									<span class="required">*</span>
									</div>
									

									<span class="text-danger col-md-offset-4">
										<?php if(isset($lasterr))
										echo $lasterr;  ?>
									</span>	
									<div class="row media">
									<label for="email" class="col-xs-12 col-md-4">Email address</label>								
									<input type="text" name="email" id="email" placeholder="" class="col-xs-9 col-md-7">
									<span class="required">*</span>
									</div>
									<span class="text-danger col-md-offset-4">
										<?php if(isset($emailerr))
										echo $emailerr;  ?>
									</span>	

									<div class="row media">
									<label for="newpass" class="col-xs-12 col-md-4">Password</label>
									<input type="password" name="newpass" id="newpass" placeholder=""  class="col-xs-9 col-md-7">
									<span class="required">*</span>
									</div>	
									<span class="text-danger col-md-offset-4">
										<?php if(isset($passerr))
										echo $passerr;  ?>
									</span>	
									<div class="row media">
									<label for="newpass1" class="col-xs-12 col-md-4">Re-type password</label>
									<input type="password" name="newpass1" id="newpass1" placeholder=""  class="col-xs-9 col-md-7">
									<span class="required">*</span>
									</div>	
									<span class="text-danger col-md-offset-4">
										<?php if(isset($passErrorConf))
										echo $passErrorConf;  ?>
									</span>	
									<div class="row media">
									<label for="birthdate" class="col-xs-12 col-md-4">Date of birth</label>
									<input type="date" name="birthdate" id="birthdate"  class="col-xs-9 col-md-7">
									<span class="required">*</span>
									</div>	
									<span class="text-danger col-md-offset-4">
										<?php if(isset($birthError))
										echo $birthError;  ?>
									</span>	


									<div class="row media">
											
									<input type="submit" name="register" id="submit" value="Register" class="btn btn-info btn-large col-xs-offset-6 col-md-offset-9">
									</div>

									
										<?php if(isset($message))

										echo '<div class="alert alert-info">'.$message.'</div>'
										?>
									
									


								</form>
							</div>
							<!--form2-->
							
						</div>
	 
	</div>
	</div>
	</div>
	</body>
	</html>