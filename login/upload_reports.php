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

<?PHP
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $cid = $_POST['cid'];
    $pid = $_POST['pid'];

    mysqli_query("delete from rl_report where cid='$cid' and pid='$pid' and 	reportmonth='" . $_POST['reportmonth'] . "'");

    for ($i = 1; $i <= 3; $i++) {

        $target_path = '';
        $docpath = '';
        $reportname = $_POST['reportname' . $i];
        $reportmonth = $_POST['reportmonth'];
        $docpath = $_FILES['img' . $i]['name'];
        $check = substr($docpath, -4);
        if ($check == '.pdf') {
            if ($docpath != '') {
                $target_path = "reports/" . rand();
                $target_path = $target_path . str_replace(' ', '_', basename($_FILES['img' . $i]['name']));
                move_uploaded_file($_FILES['img' . $i]['tmp_name'], $target_path);
                $target_path = str_replace('reports/', '', $target_path);
            } else {
                $target_path = $_POST['img' . $i];
            }

            mysqli_query($link, "insert into rl_report(cid,pid,reportname,reportmonth,imgPath,dateAdded) values('$cid','$pid','$reportname','$reportmonth','$target_path','" . $today . "')");
        }
    }

    header("location: upload_report.php?cid=$cid&pid=$pid&&reportmonth=$reportmonth&msg=added");
}

?>

<!DOCTYPE html>

<head>
    <title>User </title>
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


                <?PHP
                $client = mysqli_query($link, "select * from rl_login where id='" . $_REQUEST['cid'] . "'");
                $client_data = mysqli_fetch_array($client);

                $project = mysqli_query($link, "select * from rl_projects where id='" . $_REQUEST['pid'] . "'");
                $project_data = mysqli_fetch_array($project);
                ?>
                <section class="panel">
                    <header class="panel-heading" style="font-size:17px;">
                        Upload Report <span class="text-inverse">[<?PHP echo $_REQUEST['reportmonth']; ?>]</span>
                    </header>
                    <div class="panel-body">
                        <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                        <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="upload_reports.php?action=add" enctype="multipart/form-data">


                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">Client Name</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <?PHP echo $client_data['name']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">Project Name</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <?PHP echo $project_data['projectName']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">Website URL</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <?PHP echo $project_data['websiteUrl']; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">&nbsp;</label>
                                <div class="col-lg-6">
                                    <span class="text-inverse">Please upload only pdf file. Other files are not allowed.</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3"> Links Report</label>
                                <div class="col-lg-6">
                                    <?PHP
                                    $sql1 = mysqli_query($link, "select * from rl_report where cid='" . $_REQUEST['cid'] . "' and pid='" . $_REQUEST['pid'] . "' and reportmonth='" . $_REQUEST['reportmonth'] . "'  and reportname='Links Report'");
                                    $sql_data1 = mysqli_fetch_array($sql1);
                                    ?>

                                    <input name="img1" type="hidden" value="<?PHP echo $sql_data1['imgPath']; ?>" id="img1" />
                                    <input name="reportname1" type="hidden" value="Links Report" id="reportname1" />
                                    <?PHP if ($sql_data1['imgPath'] != '') { ?>
                                        <a href="<?PHP echo "reports/" . $sql_data1['imgPath']; ?>" target="_blank"><i class="fa fa-book text-success" style="font-size:30px;" title="View Uploaded Report"></i></a>
                                    <?PHP } else {  ?>
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23">
                                                <input name="img1" type="file" id="img1" class="form-control" />
                                            </div>
                                        </div>
                                    <?PHP } ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">Onsite Report</label>
                                <div class="col-lg-6">
                                    <?PHP
                                    $sql1 = mysqli_query($link, "select * from rl_report where cid='" . $_REQUEST['cid'] . "' and pid='" . $_REQUEST['pid'] . "' and reportmonth='" . $_REQUEST['reportmonth'] . "'  and reportname='Onsite Report'");
                                    $sql_data1 = mysqli_fetch_array($sql1);
                                    ?>
                                    <input name="img2" type="hidden" value="<?PHP echo $sql_data1['imgPath']; ?>" id="img2" />
                                    <input name="reportname2" type="hidden" value="Onsite Report" id="reportname2" />
                                    <?PHP if ($sql_data1['imgPath'] != '') { ?>
                                        <a href="<?PHP echo "reports/" . $sql_data1['imgPath']; ?>" target="_blank"><i class="fa fa-book text-success" style="font-size:30px;" title="View Uploaded Report"></i></a>
                                    <?PHP } else {  ?>
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23">
                                                <input name="img2" type="file" id="img2" class="form-control" />
                                            </div>
                                        </div>
                                    <?PHP } ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label col-lg-3">Ranking Report</label>
                                <div class="col-lg-6">
                                    <?PHP
                                    $sql1 = mysqli_query($link, "select * from rl_report where cid='" . $_REQUEST['cid'] . "' and pid='" . $_REQUEST['pid'] . "' and reportmonth='" . $_REQUEST['reportmonth'] . "'  and reportname='Ranking Report'");
                                    $sql_data1 = mysqli_fetch_array($sql1);
                                    ?>
                                    <input name="img3" type="hidden" value="<?PHP echo $sql_data1['imgPath']; ?>" id="img3" />
                                    <input name="reportname3" type="hidden" value="Ranking Report" id="reportname3" />
                                    <?PHP if ($sql_data1['imgPath'] != '') { ?>
                                        <a href="<?PHP echo "reports/" . $sql_data1['imgPath']; ?>" target="_blank"><i class="fa fa-book text-success" style="font-size:30px;" title="View Uploaded Report"></i></a>
                                    <?PHP } else {  ?>
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23">
                                                <input name="img3" type="file" id="img3" class="form-control" />
                                            </div>
                                        </div>
                                    <?PHP } ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-6">
                                    <input type="hidden" name="pid" value="<?PHP echo $_REQUEST['pid']; ?>">
                                    <input type="hidden" name="cid" value="<?PHP echo $_REQUEST['cid']; ?>">
                                    <input type="hidden" name="reportmonth" value="<?PHP echo $_REQUEST['reportmonth']; ?>">

                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>


            </div>
        </section>
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <script src="js/main.js"></script>
        <!-- footer -->
        <?php include("includes/footer.php"); ?>
        <!-- footer -->