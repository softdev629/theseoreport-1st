<?php
session_start();

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['loginType'] != $BASIC_LOGIN_TYPE) {
    header("Location: $DASHBOARD_PAGE_PATH"."?account_id=".$_SESSION['account_id']);
    exit;
}

$docpath = '';
//echo $filename1 = rand().$_FILES['img1']['name'];


$target_path2 = '';
$docpath == '';
$docpath = @$_FILES['img1']['name'];
$check = substr($docpath, -4);
if ($check == '.jpg' || $check == '.png' || $check == 'jpeg') {

    if ($docpath != '') {
        $target_path2 = "images/userpic/" . rand();
        $target_path2 = $target_path2 . str_replace(' ', '_', basename($_FILES['img1']['name']));

        move_uploaded_file($_FILES['img1']['tmp_name'], $target_path2);

        $target_path2 = str_replace('images/userpic/', '', $target_path2);
        $query = mysqli_query($link, "update rl_login set imgPath='" . $target_path2 . "' where email='" . $_SESSION['username'] . "'");
    }
}

if ($_POST['name'] != '') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $zip = $_POST['zip'];

    $query = mysqli_query($link, "update rl_login set name='" . $name . "',phone='" . $phone . "',address='" . $address . "',city='" . $city . "',state='" . $state . "',country='" . $country . "',zip='" . $zip . "' where email='" . $_SESSION['username'] . "'");
}
?>

<!DOCTYPE html>

<head>
  <title>My Profile </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script type="text/javascript">
  function validateFileSize39(id, div) {

    var aspFileUpload = document.getElementById("img1");
    var errorLabel = document.getElementById("ErrorLabel_39");
    var sucessLabel = document.getElementById("SucessLabel_39");
    var fileName = aspFileUpload.value;
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (!(ext == "jpeg" || ext == "jpg" || ext == "png"))

    {
      errorLabel.style.display = "block";
      sucessLabel.style.display = "none";
      aspFileUpload.value = "";
    } else {
      errorLabel.style.display = "none";
    }

    var uploadControl = document.getElementById(id);
    if (uploadControl.files[0].size > 2097152) //  size of image 2MB ---- 2020 ud
    {
      document.getElementById(div).style.display = "block";
      sucessLabel.style.display = "none";
      aspFileUpload.value = "";
      return false;
    } else {
      document.getElementById(div).style.display = "none";
      sucessLabel.style.display = "block";
      return true;
    }
  }
  </script>

  <?php include("includes/header.php"); ?>
  <!--header end-->
  <!--sidebar start-->

  <?php include("includes/left.php"); ?>

  <?PHP
    $sql = mysqli_query($link, "select * from rl_login where email='" . $_SESSION['username'] . "'");
    $sql_data = mysqli_fetch_array($sql);

    ?>

  <!--sidebar end-->
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <div class="agile-grid" style="min-height:620px;">
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                My Profile
              </header>
              <div class="panel-body">


                <p class="hd-title" align="center">
                  <?PHP echo $message; ?>
                </p>

                <div class="col-lg-9">
                  <form class="form-horizontal bucket-form login100-form validate-form" method="POST" action=""
                    enctype="multipart/form-data">

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Username / Email</label>
                      <div class="col-lg-6">
                        <p class="form-control-static">
                          <?PHP echo $_SESSION['username']; ?>
                        </p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Name</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="name"
                            value="<?PHP echo $sql_data['name']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Phone</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="phone"
                            value="<?PHP echo $sql_data['phone']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Address</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="address"
                            value="<?PHP echo $sql_data['address']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">City</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="city"
                            value="<?PHP echo $sql_data['city']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">State</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="state"
                            value="<?PHP echo $sql_data['state']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Country</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="country"
                            value="<?PHP echo $sql_data['country']; ?>" required></p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label">Pincode</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input type="text" class="form-control input100" name="zip"
                            value="<?PHP echo $sql_data['zip']; ?>" required></p>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-3 control-label">Profile Image</label>
                      <div class="col-lg-6">
                        <p class="form-control-static"><input name="img1" type="file" id="img1"
                            onChange="validateFileSize39(this.id,'dvMsg_39');" /> </p>
                        <p class="help-block">Please select jpg/jpeg/png image</p>
                        <div id="dvMsg_39"
                          style="background-color:#c91822; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -5px; margin-bottom: 10px; text-align:center; display:none;">
                          <span class="jpg_pdf" style="color:#000; text-align:center;">Max. size is 2 MB</span>
                        </div>
                        <div id="ErrorLabel_39"
                          style="background-color:#c91822; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -5px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">Invalid file format</span>
                        </div>
                        <div id="SucessLabel_39"
                          style="background-color:#53741d; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -5px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">File Selected</span>
                        </div>
                      </div>
                    </div>


                    <div class="form-group has-success">
                      <label class="col-sm-3 control-label col-lg-3" for="inputSuccess"> </label>
                      <div class="col-lg-6">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                      </div>
                    </div>



                  </form>
                </div>
                <?PHP
                                if ($sql_data['imgPath'] == '') {
                                    $myimage = "no-image.jpg";
                                } else {
                                    $myimage = $sql_data['imgPath'];
                                }

                                ?>
                <div class="col-lg-3"><img alt=""
                    src="<?PHP echo $website_url; ?>/images/userpic/<?PHP echo $myimage; ?>" class="profile_img"></div>





              </div>
            </section>
          </div>
        </div>

      </div>
    </section>
    <!-- footer -->
    <?php include("includes/footer.php"); ?>
    <!-- footer -->