
<?php
include ('connect.php');

$message = '';
if( $_SERVER["REQUEST_METHOD"] == "POST") //if login btn was pressed
{

	if (empty($_POST['username']) || empty($_POST['password']))
	{
		$message = "Username or password is  invalid!";
	}
	else
	{
		$username = mysqli_real_escape_string($db_connect, $_POST['username']);// avoid unwanted chr like ' " \
		$pass = mysqli_real_escape_string($db_connect, $_POST['password']);// avoid unwanted chr like ' " \

		$password = hash("sha256",$pass);

	
	// select user with $usename and $password eq to sent values

	$sql = "select * from users where nickname = '$username' and password='$password' ";
	$result = mysqli_query($db_connect,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$row_count = mysqli_num_rows($result);

	if ($row_count == 1)
	{
		$message = "You login was successful";
	}
	else
	{
		$message = "Wrong username and password";
	}
}
}


?>