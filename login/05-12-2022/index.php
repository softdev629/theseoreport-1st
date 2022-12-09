<?PHP 
include("includes/common.php"); 

if(@$_POST['username']!='')
	{
$query=mysqli_query($link,"select * from rl_login where email='" .$_POST['username']. "' and password='" .$_POST['password'] ."' and status=1 ");
$rows = mysqli_num_rows($query);
if($rows!='0')
{
	$fetch=mysqli_fetch_array($query);

$_SESSION['username'] = $fetch['email'];
$_SESSION['UID'] = $fetch['id'];
$_SESSION['name'] = $fetch['name'];
$_SESSION['usertype'] = $fetch['userType'];


$IPP = $_SERVER['REMOTE_ADDR'];

$date=date("Y-m-d");
$offset=5*60*60+1800;
$dateFormat="Y-m-d H:i:s";
$today=gmdate($dateFormat, time()+$offset);			

			$query = mysqli_query($link,$qq);
			header("location: dashboard.php");
			exit;
}
	else
		{
			$_SESSION['message']='Username and password does not match!!';
			header("location: index.php");
			exit;	
		}	
	}
	
if(@$_SESSION['username']!='')
	{
		header('Location: dashboard.php');
		exit;	
	}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/favicon.png"/>
<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				
                <form class="login100-form validate-form" action="" method="post">
					<span class="logo_login">
					 </span>
					<div style="margin:20px; color:#fb6f6b;"><?PHP echo $_SESSION['message']; $_SESSION['message']=''; ?>	</span>
                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Type your username">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Type your password">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>
					
					<div class="text-right p-t-8 p-b-31">
						<a href="forgot_password.php">
							Forgot password?
						</a>
					</div>
					
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Login
							</button>
						</div>
					</div>




				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>

</body>
</html>