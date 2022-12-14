<?PHP
session_start();
include("includes/common.php");


if ($_POST['username'] != '') {

    $query = mysqli_query($link, "select * from rl_login where email='" . $_POST['username'] . "' and status=1 ");
    $rows = mysqli_num_rows($query);
    if ($rows != '0') {
        $fetch = mysqli_fetch_array($query);

        $email = $fetch['email'];
        $name = $fetch['name'];
        $password = $fetch['password'];


        $IPP = $_SERVER['REMOTE_ADDR'];

        $date = date("Y-m-d");
        $offset = 5 * 60 * 60 + 1800;
        $dateFormat = "Y-m-d H:i:s";
        $today = gmdate($dateFormat, time() + $offset);

        $msg = "<table width='600' border='0' cellspacing='0' cellpadding='0' >
  <tr>
    <td bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='4'>
      <tr>
        <td bgcolor='#EDEEF0' style='font-family:arial;line-height:30px;'>Dear " . $name . ",<br>Please find the below login detail: <br> 
		<strong>Login Url:</strong> ";
        $msg .= "https://reportslocker.com";
        $msg .= "<br /><strong>Username:</strong> ";
        $msg .= $email;
        $msg .= "<br /><strong>Password:</strong> ";
        $msg .= $password;
        $msg .= "</td>
      </tr>
    </table></td>
  </tr>
</table>";

        $msg .= "<br /><table width='600' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td bgcolor='#CCCCCC'><table width='100%' border='0' cellspacing='1' cellpadding='4'>
      <tr>
        <td bgcolor='#EDEEF0' style='font-family:arial;line-height:30px;'><strong>Requested Ip Address:</strong> ";
        $msg .= $_SERVER['REMOTE_ADDR'];
        $msg .= "<br /><strong>Requested From:</strong> ";
        $msg .= "https://reportslocker.com/forgot_password.php";
        $msg .= "<br /><strong>Date Time:</strong> ";
        $msg .= $today;
        $msg .= "<br /><strong>Login Status:</strong> ";
        $msg .= "Active";
        $msg .= "</td>
      </tr>
    </table></td>
  </tr>
</table><br><br><img src='https://reportslocker.com/images/logo.png' width='250' style='width:250px;'>";

        $subject = "Login detail from Reports Locker";
        $mailbcc = '';
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $header .= "From: Reports Locker <info@reportslocker.com>\r\n";
        //$mail=mail('info@reportslocker.com',$subject,$msg,$header);
        $mail = mail($email, $subject, $msg, $header);

        $_SESSION['message'] = 'Login detail sent to your registered email id.';
        header('Location: forgot_password.php');
        exit;
    } else {
        $_SESSION['message'] = '<span style="color:#fb6f6b">Username does not exist OR blocked by admin!!</span>';
        header('Location: forgot_password.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot password </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="node_modules/animsition/dist/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>


    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">

                <form class="login100-form validate-form" action="" method="post">



                    <div align="center" style="color:#093;margin-bottom:20px;"><?PHP echo $_SESSION['message'];
                                                                                $_SESSION['message'] = ''; ?></div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Username is required">
                        <span class="label-input100">Username / Email</span>
                        <input class="input100" type="text" name="username" placeholder="Type your username">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="text-right p-t-8 p-b-31">
                        <a href="index.php">
                            Go For Login
                        </a>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn">
                                Forgot Password
                            </button>
                        </div>
                    </div>




                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>