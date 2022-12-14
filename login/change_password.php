<?php

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['loginType'] != $BASIC_LOGIN_TYPE) {
    header('Location: dashboard.php');
    exit;
}

?>

<!DOCTYPE html>

<head>
    <title>Change Password </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">


    <?php include("includes/header.php"); ?>
    <!--header end-->
    <!--sidebar start-->

    <?php include("includes/left.php");



    if (isset($_REQUEST['empty']) && $_REQUEST['empty'] == "empty") {
        $message = "Please fill all field";
    }
    if (isset($_REQUEST['change']) &&  $_REQUEST['change'] == "change") {
        $message = "Password changed Successfully.";
    }
    if (isset($_REQUEST['notold']) && $_REQUEST['notold'] == "notold") {
        $message = "Sorry!! Old Password is wrong.";
    }
    if (isset($_REQUEST['notmatch']) && $_REQUEST['notmatch'] == "notmatch") {
        $message = "Sorry!! New/Confirm Password must be same.";
    }

    ?>

    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="agile-grid" style="height:620px;">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Change Password
                            </header>
                            <div class="panel-body">

                                <p class="hd-title" align="center"><?PHP echo $message; ?></p>

                                <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="change_pass_db.php">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Username / Email</label>
                                        <div class="col-lg-6">
                                            <p class="form-control-static"><?PHP echo $_SESSION['username']; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group has-success">
                                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Old Password</label>
                                        <div class="col-lg-6">
                                            <div class="wrap-input100 validate-input" data-validate="Please provide old password">
                                                <input type="password" class="form-control input100" id="inputSuccess" name="old_pass" style="height:55px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-success">
                                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">New Password</label>
                                        <div class="col-lg-6">
                                            <div class="wrap-input100 validate-input" data-validate="Please provide new password">
                                                <input type="password" class="form-control input100" id="inputSuccess" name="new_pass" style="height:55px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-success">
                                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Confirm New Password</label>
                                        <div class="col-lg-6">
                                            <div class="wrap-input100 validate-input" data-validate="Please confirm new password">
                                                <input type="password" class="form-control input100" id="inputSuccess" name="confirm_pass" style="height:55px;">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group has-success">
                                        <label class="col-sm-3 control-label col-lg-3" for="inputSuccess"> </label>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success">Change Password</button>
                                        </div>
                                    </div>



                                </form>


                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </section>

        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="node_modules/jquery/dist/jquery.min.js"></script>
        <!-- footer -->
        <?php include("includes/footer.php"); ?>
        <!-- footer -->