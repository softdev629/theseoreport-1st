<?php

require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/common.php';

require_once __DIR__ . '/includes/check-session-for-login-page.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!array_key_exists('login-type', $_POST)) {
        throw new Exception('something-went-wrong:invalid-markup');
    }

    if ($_POST['login-type'] == $BASIC_LOGIN_TYPE) {

        if (!array_key_exists('username', $_POST)
            || !array_key_exists('password', $_POST)) {
            throw new Exception('something-went-wrong:invalid-markup');
        }

        $result = $link->query("select * from rl_login where email='" . $_POST['username'] . "' and password='" . $_POST['password'] . "' and status=1");

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if (count($rows) != 0) {

            $expiry = (new DateTimeImmutable())
            ->modify("+$HOURS_UNTIL_COOKIE_EXPIRES hours")
            ->getTimestamp();

            setcookie($COOKIE_NAME, base64_encode(json_encode([
                'id' => $rows[0]['id'],
                'expiry' => $expiry,
                'sign' => md5($COOKIE_SECRET),
                'login_type' => $BASIC_LOGIN_TYPE,
            ])), $expiry, '', $_SERVER['HTTP_HOST'], true, true);

            header("Location: $DASHBOARD_PAGE_PATH"."?account_id=".$_COOKIE['account_id']);

            exit;

        }
        
        else {
            $message = 'Username and password does not match!!';
        }

    }

    // if ($_POST['login-type'] == $VENDASTA_SSO_LOGIN_TYPE) {

        // require_once __DIR__ . '/vendor/autoload.php';

        // $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        //     'urlResourceOwnerDetails' => $oauth_resource_owner_details_endpoint_url,
        //     'urlAuthorize' => "$authorization_url?account_id=".$_COOKIE['account_id'],
        //     'urlAccessToken' => $oauth_access_token_endpoint_url,
        //     'clientSecret' => $oauth_client_secret,
        //     'clientId' => $oauth_client_id,
        //     'redirectUri' => $oauth_redirect_url,
        // ]);

        // $authorizationUrl = $provider->getAuthorizationUrl([
        //     'state' => $ACCOUNT_ID,
        //     'scope' => ['profile'],
        // ]);

        // header("Location: $authorizationUrl");

        // exit;

//     }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/favicon.png" />
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

          <span class="logo_login"></span>

          <div style="margin:20px; color:#fb6f6b;"><?= $message ?></span>

            <!--

                            class="validate-input"
                            data-validate="Username is required"
                            data-validate="Password is required"

                        -->

            <div class="wrap-input100 m-b-23">
              <span class="label-input100">Username</span>
              <input class="input100" type="text" name="username" placeholder="Type your username">
              <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>

            <div class="wrap-input100">
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
                <button name="login-type" value="basic" class="login100-form-btn">
                  Login
                </button>
              </div>
            </div>

            <!-- <div class="vendesta-login">
              <button name="login-type" value="vendasta-sso" class="vendesta-login-form-btn">
                Continue with Vendasta
              </button>
            </div> -->

        </form>
      </div>
    </div>
  </div>

  <div id="dropDownSelect1"></div>

  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="js/main.js"></script>

</body>

</html>