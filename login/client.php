<?php

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['usertype'] != 'Administrator') {
    header('Location: dashboard.php');
    exit;
}

?>

<?PHP
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $chk_user = $_POST['email'];
    $chkuser = mysqli_query($link, "sELECT * FROM rl_login where email='$chk_user' ");
    $chk_num = @mysqli_num_rows($chkuser);

    if ($chk_num == '0') {
        mysqli_query($link, "insert into rl_login(userType,email,password,name,phone,address,city,state,country,zip,comments,status,dateAdded,dateModify,createdBy) values('Client','" . $_POST['email'] . "','" . $_POST['password'] . "','" . $_POST['name'] . "','" . $_POST['phone'] . "','" . $_POST['address'] . "','" . $_POST['city'] . "','" . $_POST['state'] . "','" . $_POST['country'] . "','" . $_POST['zip'] . "','" . $_POST['comments'] . "','" . $_POST['status'] . "','" . $today . "','" . $today . "','" . $_SESSION['UID'] . "')");

        header("location: client.php?mode=show&msg=added");
    } else {
        header("location: client.php?mode=add&msg=exist");
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'edit') {

    mysqli_query($link, "update rl_login SET password='" . $_POST['password'] . "',name='" . $_POST['name'] . "',phone='" . $_POST['phone'] . "',address='" . $_POST['address'] . "',city='" . $_POST['city'] . "',state='" . $_POST['state'] . "',country='" . $_POST['country'] . "',zip='" . $_POST['zip'] . "',comments='" . $_POST['comments'] . "',status='" . $_POST['status'] . "',dateModify='" . $today . "' where id='" . $_POST['uid'] . "'");

    header("location: client.php?mode=show&msg=edited");
}


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    mysqli_query($link, "delete from rl_login where id!=1 and id='" . $_REQUEST['uid'] . "'");
    header("location: client.php?mode=show&msg=deleted");
}



if (isset($_GET['msg']) && $_GET['msg'] == 'added') {
    $message = 'Record Added Successfully.';
}
if (isset($_GET['msg']) && $_GET['msg'] == 'edited') {
    $message = 'Record Edited Successfully.';
}
if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
    $message = 'Record Delete Successfully.';
}
if (isset($_GET['msg']) && $_GET['msg'] == 'exist') {
    $message = 'Username already exist.';
}
?>

<!DOCTYPE html>

<head>
    <title>Client </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">


    <?php include("includes/header.php"); ?>
    <!--header end-->
    <!--sidebar start-->

    <?php include("includes/left.php"); ?>

    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="table-agile-info">

                <?PHP if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'show') { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">Client List</div>
                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <form action="client.php">
                                    <input type="hidden" name="mode" value="add">
                                    <button type="submit" class="btn btn-info">Add New Client</button>
                                </form>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div align="center" class="text-success"><?PHP echo $message; ?></div>
                                </div>
                            </div>

                            <form name="search2" method="get" action="client.php">

                                <input type="hidden" name="mode" value="show">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" class="input-sm form-control" name="searchkeyword" value="<?PHP echo @$_REQUEST['searchkeyword']; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm btn-default">Go!</button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <?PHP
                            $searchkeyword = @$_REQUEST['searchkeyword'];
                            ?>


                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name
                                            <a href="client.php?orderby=DESC&page=<?php echo $page; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp &nbsp <i class="fa fa-sort-alpha-desc text-inverse" title="Descending Order"></i></span></a>
                                            <a href="client.php?orderby=ASC&page=<?php echo $page; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-asc text-success" title="Ascending Order"></i></span></a>
                                        </th>
                                        <th>Username / Email
                                            <a href="client.php?orderby=DESC&page=<?php echo $page; ?>&usertype=<?php echo $usertype; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=email&mode=show"><span style="font-size:19px;">&nbsp &nbsp <i class="fa fa-sort-alpha-desc text-inverse" title="Descending Order"></i></span></a>
                                            <a href="client.php?orderby=ASC&page=<?php echo $page; ?>&usertype=<?php echo $usertype; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=email&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-asc text-success" title="Ascending Order"></i></span></a>
                                        </th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $k = @$_REQUEST['orderby'];
                                    if ($k == '') {
                                        $k = "DESC";
                                    }

                                    $orderfield = @$_REQUEST['orderfield'];
                                    if ($orderfield == '') {
                                        $orderfield = "id";
                                    }

                                    $qq = "select * from rl_login where 1=1  and userType='Client'";

                                    if (@$_REQUEST['searchkeyword']) {
                                        $qq .= " and (email LIKE '%" . $_REQUEST['searchkeyword'] . "%' OR name LIKE '%" . $_REQUEST['searchkeyword'] . "%' OR phone LIKE '%" . $_REQUEST['searchkeyword'] . "%' )";
                                    }

                                    $qq .= " ORDER BY $orderfield $k";

                                    //echo $qq;

                                    $user = mysqli_query($link, $qq);
                                    $i = 1;
                                    while ($user_data = mysqli_fetch_array($user)) {

                                        $created = mysqli_query($link, "select * from rl_login where id='" . $user_data['createdBy'] . "'");
                                        $created_data = mysqli_fetch_array($created);
                                    ?>
                                        <tr>
                                            <td><?PHP echo $i; ?></td>
                                            <td><?PHP echo $user_data['name']; ?></td>
                                            <td><?PHP echo $user_data['email']; ?></td>
                                            <td><?PHP echo $user_data['phone']; ?></td>
                                            <td>
                                                <?PHP if ($user_data['status'] == 1) {
                                                    echo "<span class='text-success'>Active</span>";
                                                } else {
                                                    echo "<span class='text-danger'>Blocked</span>";
                                                } ?></td>
                                            <td>
                                                <form id="forma<?PHP echo $i; ?>" name="forma<?PHP echo $i; ?>" action="client.php?mode=edit" method="post">
                                                    <input type="hidden" name="uid" value="<?PHP echo $user_data['id']; ?>">
                                                    <i class="fa fa-edit text-success text-active" style="font-size:25px; cursor:pointer;" onclick="document.getElementById('forma<?PHP echo $i; ?>').submit();"></i>
                                                </form>
                                            </td>

                                            <td>
                                                <a href="client.php?action=delete&uid=<?PHP echo $user_data['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:25px; cursor:pointer;"></i></a>
                                            </td>
                                        </tr>
                                    <?PHP
                                        $i = $i + 1;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>-->
                    </div>
                <?PHP } ?>

                <?PHP if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'add') { ?>
                    <section class="panel">
                        <header class="panel-heading">
                            Add Client
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="client.php?action=add">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-user text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Name is required">
                                                <input type="text" class="form-control input100" name="name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Username / Email</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-envelope text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Valid email is required">
                                                <input type="text" class="form-control input100" name="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Password</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-key text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
                                                <input type="text" class="form-control input100" name="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Phone</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-phone text-inverse"></i></span>
                                            <div class="wrap-input100">
                                                <input type="text" class="form-control input100" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Address</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <div class="wrap-input100">
                                                <input type="text" class="form-control input100" name="address">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">City</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <input type="text" class="form-control" name="city">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">State</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <input type="text" class="form-control" name="state">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Country</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-globe text-inverse"></i></span>
                                            <input type="text" class="form-control" name="country">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Pincode</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-compass text-inverse"></i></span>
                                            <input type="text" class="form-control" name="zip">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Comments</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-comments text-inverse"></i></span>
                                            <textarea name="comments" class="form-control" style="height:140px;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Status</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon" style="width:200px; border:1px solid #ccc; border-radius:4px;">
                                                <input type="radio" name="status" value="1" checked> Active
                                                <input type="radio" name="status" value="0"> Blocked
                                            </span>
                                            <input type="text" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">&nbsp;</div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                <?PHP } ?>

                <?PHP if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'edit') { ?>

                    <?PHP
                    $user = mysqli_query($link, "select * from rl_login where id='" . $_POST['uid'] . "'");
                    $user_data = mysqli_fetch_array($user);
                    ?>
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Client
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="client.php?action=edit">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-user text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Name is required">
                                                <input type="text" class="form-control input100" name="name" value="<?PHP echo $user_data['name']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Username / Email</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-envelope text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Valid email is required">
                                                <input type="text" class="form-control input100" name="email" value="<?PHP echo $user_data['email']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Password</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-key text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
                                                <input type="text" class="form-control input100" name="password" value="<?PHP echo $user_data['password']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Phone</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-phone text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Phone is required">
                                                <input type="text" class="form-control input100" name="phone" value="<?PHP echo $user_data['phone']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Address</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Address is required">
                                                <input type="text" class="form-control input100" name="address" value="<?PHP echo $user_data['address']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">City</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <input type="text" class="form-control" name="city" value="<?PHP echo $user_data['city']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">State</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-building text-inverse"></i></span>
                                            <input type="text" class="form-control" name="state" value="<?PHP echo $user_data['state']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Country</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-globe text-inverse"></i></span>
                                            <input type="text" class="form-control" name="country" value="<?PHP echo $user_data['country']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Pincode</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-compass text-inverse"></i></span>
                                            <input type="text" class="form-control" name="zip" value="<?PHP echo $user_data['zip']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Comments</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-comments text-inverse"></i></span>
                                            <textarea name="comments" class="form-control" style="height:140px;"> <?PHP echo $user_data['comments']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Status</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon" style="width:200px; border:1px solid #ccc; border-radius:4px;">
                                                <input type="radio" name="status" value="1" <?PHP if ($user_data['status'] == 1) { ?> checked <?PHP } ?>> Active
                                                <input type="radio" name="status" value="0" <?PHP if ($user_data['status'] == 0) { ?> checked <?PHP } ?>> Blocked
                                            </span>
                                            <input type="text" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">&nbsp;</div>
                                    <div class="col-lg-6">
                                        <input type="hidden" name="uid" value="<?PHP echo $user_data['id']; ?>">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </section>
                <?PHP } ?>

            </div>
        </section>
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <!-- footer -->
        <?php include("includes/footer.php"); ?>
        <!-- footer -->