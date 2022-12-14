<?php

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['usertype'] != 'Administrator') {
    header("Location: $DASHBOARD_PAGE_PATH");
    exit;
}

?>

<?php

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    mysqli_query($link, "insert into rl_package(name) values('" . $_POST['name'] . "')");
    header("location: package.php?mode=show&msg=added");
}

if (isset($_GET['action']) && $_GET['action'] == 'edit') {

    mysqli_query($link, "update rl_package SET name='" . $_POST['name'] . "' where id='" . $_POST['uid'] . "'");
    header("location: package.php?mode=show&msg=edited");
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    mysqli_query($link, "delete from rl_package where id='" . $_REQUEST['uid'] . "'");
    header("location: package.php?mode=show&msg=deleted");
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
                        <div class="panel-heading">Package List</div>
                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <div class="form-group">
                                    <form action="package.php">
                                        <input type="hidden" name="mode" value="add">
                                        <button type="submit" class="btn btn-info">Add New Package</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div align="center" style="margin:15px;" class="text-success"><?PHP echo $message; ?></div>

                            </div>

                            <form name="search2" method="get" action="package.php">

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
                                            <a href="package.php?orderby=DESC&page=<?php echo $page; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp &nbsp <i class="fa fa-sort-alpha-desc text-inverse" title="Descending Order"></i></span></a>
                                            <a href="package.php?orderby=ASC&page=<?php echo $page; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-asc text-success" title="Ascending Order"></i></span></a>
                                        </th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    $k = @$_REQUEST['orderby'];
                                    if ($k == '') {
                                        $k = "asc";
                                    }

                                    $orderfield = @$_REQUEST['orderfield'];
                                    if ($orderfield == '') {
                                        $orderfield = "name";
                                    }

                                    $qq = "select * from rl_package where 1=1 ";

                                    if (@$_REQUEST['searchkeyword']) {
                                        $qq .= " and ( name LIKE '%" . $_REQUEST['searchkeyword'] . "%' )";
                                    }

                                    $qq .= " ORDER BY $orderfield $k";

                                    //echo $qq;

                                    $user = mysqli_query($link, $qq);
                                    $i = 1;
                                    while ($user_data = mysqli_fetch_array($user)) {
                                    ?>
                                        <tr>
                                            <td><?PHP echo $i; ?>.</td>
                                            <td><?PHP echo $user_data['name']; ?></td>
                                            <td>
                                                <form id="forma<?PHP echo $i; ?>" name="forma<?PHP echo $i; ?>" action="package.php?mode=edit" method="post">
                                                    <input type="hidden" name="uid" value="<?PHP echo $user_data['id']; ?>">
                                                    <i class="fa fa-edit text-success text-active" style="font-size:25px; cursor:pointer;" onclick="document.getElementById('forma<?PHP echo $i; ?>').submit();"></i>
                                                </form>
                                            </td>

                                            <td>
                                                <a href="package.php?action=delete&uid=<?PHP echo $user_data['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:25px; cursor:pointer;"></i></a>
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
                            Add Package
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="package.php?action=add">

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
                    $user = mysqli_query($link, "select * from rl_package where id='" . $_POST['uid'] . "'");
                    $user_data = mysqli_fetch_array($user);
                    ?>
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Package
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="package.php?action=edit">

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