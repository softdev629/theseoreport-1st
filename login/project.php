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
    mysqli_query($link, "insert into rl_projects(cid,projectName,websiteUrl,startDate,keywords,package,notes,status,stopstatus,stopdate,dateAdded,dateModify,createdBy) values('" . $_POST['cid'] . "','" . $_POST['pname'] . "','" . $_POST['url'] . "','" . $_POST['startdate'] . "','" . $_POST['keywords'] . "','" . $_POST['package'] . "','" . $_POST['comments'] . "','1','" . $_POST['stopstatus'] . "','" . $_POST['stopdate'] . "','" . $today . "','" . $today . "','" . $_SESSION['UID'] . "')");

    $pid = mysqli_insert_id();
    echo $pid;
    $login_total = $_POST['login_total'];
    echo $login_total;

    for ($m = 1; $m <= $login_total; $m++) {
        $link = $_POST['link' . $m];
        $projectname = $_POST['username' . $m];
        $password = $_POST['password' . $m];
        $comments = $_POST['comments' . $m];
        $credentialsname = $_POST['credentialsname' . $m];

        mysqli_query($link, "insert into rl_projects_credentials(pid,credentialsName,credentialsType,credentialsLink,credentialsUserName,credentialsPassword,comments,dateAdded,dateModify) values('$pid','$credentialsname','$credentialsname','$link','$projectname','$password','$comments','" . $today . "','" . $today . "')");
    }

    header("location: project.php?mode=show&msg=added");
}

if (isset($_GET['action']) && $_GET['action'] == 'edit') {


    mysqli_query($link, "update rl_projects set projectName='" . $_POST['pname'] . "',websiteUrl='" . $_POST['url'] . "',startDate='" . $_POST['startdate'] . "',keywords='" . $_POST['keywords'] . "',package='" . $_POST['package'] . "',notes='" . $_POST['comments'] . "',stopstatus='" . $_POST['stopstatus'] . "',stopdate='" . $_POST['stopdate'] . "',dateModify='$today' where id='" . $_POST['pid'] . "'");

    mysqli_query($link, "delete from rl_projects_credentials where pid=" . $_POST['pid']);

    $pid = $_POST['pid'];
    $login_total = $_POST['login_total'];

    for ($m = 1; $m <= $login_total; $m++) {
        $link = $_POST['link' . $m];
        $projectname = $_POST['username' . $m];
        $password = $_POST['password' . $m];
        $comments = $_POST['comments' . $m];
        $credentialsname = $_POST['credentialsname' . $m];

        mysqli_query($link, "insert into rl_projects_credentials(pid,credentialsName,credentialsType,credentialsLink,credentialsUserName,credentialsPassword,comments,dateAdded,dateModify) values('$pid','$credentialsname','$credentialsname','$link','$projectname','$password','$comments','" . $today . "','" . $today . "')");
    }

    header("location: project.php?mode=show&msg=edited");
}


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    mysqli_query($link, "delete from rl_projects where id='" . $_REQUEST['pid'] . "'");
    header("location: project.php?mode=show&msg=deleted");
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
    <title>Project </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">


    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="css/dcalendar.picker.css" rel="stylesheet" type="text/css">
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <style>
        .container {
            margin: 150px auto 30px auto;
            max-width: 300px;
        }
    </style>
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
                        <div class="panel-heading">Projects</div>
                        <?php /*?><div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs" style="margin-bottom:20px;">
        <form action="project.php">
    <input type="hidden" name="mode" value="add">
    <button type="submit" class="btn btn-info">Add New Project</button>
    </form>
        
      </div>
    
    <div class="col-sm-4" style="margin-bottom:20px;">
    <div class="form-group">
    <form name="search1" method="get" action="project.php">
        
        <input type="hidden" name="mode" value="show">
        <input type="hidden" name="searchkeyword" value="<?PHP echo @$_REQUEST['searchkeyword'] ?>">
        
        <select class="input-sm form-control w-sm inline v-middle" name="clientid" style="width:225px;">
          <option value=''> &nbsp; &nbsp; &nbsp; - - Select Client Name - - </option>
          <option value=''> All </option>
          <?PHP 
		  $cli=mysqli_query($link,"select * from rl_login where userType='Client'");
		  while($cli_data=mysqli_fetch_array($cli))
		  {
		  ?>
          <option value="<?PHP echo $cli_data['id']; ?>" <?PHP if(@$_REQUEST['clientid']==$cli_data['id']) { ?> selected <?PHP } ?>><?PHP echo $cli_data['name']; ?> [<?PHP echo $cli_data['email']; ?>]</option>
          <?PHP } ?>
        </select>
        <button class="btn btn-sm btn-default">Go</button>                
        </form>
    </div>
    
      </div>
      
        <form name="search2" method="get" action="project.php">
        
        <input type="hidden" name="mode" value="show">
        <input type="hidden" name="clientid" value="<?PHP echo @$_REQUEST['clientid'] ?>">
        <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" name="searchkeyword" value="<?PHP echo @$_REQUEST['searchkeyword']; ?>">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" >Go!</button>
          </span>
        </div>
      </div>
          </form>
    </div><?php */ ?>
                        <div class="table-responsive">
                            <?PHP
                            $projecttype = @$_REQUEST['usertype'];
                            $searchkeyword = @$_REQUEST['searchkeyword'];
                            ?>


                            <div align="center" style="margin:15px;" class="text-success"><?PHP echo $message; ?></div>
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Project
                                            <a href="project.php?orderby=DESC&page=<?php echo $page; ?>&usertype=<?php echo $projecttype; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=projectName&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-desc text-inverse" title="Descending Order"></i></span></a>
                                            <a href="project.php?orderby=ASC&page=<?php echo $page; ?>&usertype=<?php echo $projecttype; ?>&searchkeyword=<?php echo $searchkeyword; ?>&orderfield=projectName&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-asc text-success" title="Ascending Order"></i></span></a>
                                        </th>
                                        <th>Package</th>
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

                                    $qq = "select * from rl_projects where stopstatus=1 ";

                                    if (@$_REQUEST['clientid'] != '') {
                                        $qq .= " and cid='" . $_REQUEST['clientid'] . "'";
                                    }

                                    if (@$_REQUEST['searchkeyword']) {
                                        $qq .= " and (projectName LIKE '%" . $_REQUEST['searchkeyword'] . "%' OR websiteUrl LIKE '%" . $_REQUEST['searchkeyword'] . "%' OR startDate LIKE '%" . $_REQUEST['searchkeyword'] . "%' )";
                                    }

                                    $qq .= " ORDER BY $orderfield $k";

                                    //echo $qq;

                                    $project = mysqli_query($link, $qq);
                                    $i = 1;
                                    while ($project_data = @mysqli_fetch_array($project)) {
                                        $client = mysqli_query($link, "select * from rl_login where id='" . $project_data['cid'] . "'");
                                        $client_data = mysqli_fetch_array($client);

                                        $pack = mysqli_query($link, "select * from rl_package where id='" . $project_data['package'] . "'");
                                        $pack_data = mysqli_fetch_array($pack);

                                        $created = mysqli_query($link, "select * from rl_login where id='" . $project_data['createdBy'] . "'");
                                        $created_data = mysqli_fetch_array($created);

                                        $newdate = explode('-', $project_data['startDate']);
                                        $newstartdate = $newdate[1] . '-' . $newdate[2] . '-' . $newdate[0];
                                    ?>
                                        <tr>
                                            <td><?PHP echo $i; ?>.</td>
                                            <td><?PHP echo $project_data['projectName']; ?><br />
                                                <strong>Link:</strong>&nbsp;&nbsp;&nbsp; <a href="<?PHP echo $project_data['websiteUrl']; ?>" target="_blank"><?PHP echo $project_data['websiteUrl']; ?></a><br />
                                                <strong>Start:</strong>&nbsp;&nbsp; <?PHP echo $newstartdate; ?>
                                            </td>
                                            <td><?PHP echo ucwords($pack_data['name']); ?></td>
                                            <td>
                                                <form id="forma<?PHP echo $i; ?>" name="forma<?PHP echo $i; ?>" action="project.php?mode=edit" method="post">
                                                    <input type="hidden" name="pid" value="<?PHP echo $project_data['id']; ?>">
                                                    <input type="hidden" name="cid" value="<?PHP echo $project_data['cid']; ?>">
                                                    <i class="fa fa-edit text-success text-active" style="font-size:25px; cursor:pointer;" onclick="document.getElementById('forma<?PHP echo $i; ?>').submit();"></i>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="project.php?action=delete&pid=<?PHP echo $project_data['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:25px; cursor:pointer;"></i></a>
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
                            Add Project
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="project.php?action=add">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Client Name</label>
                                    <div class="col-lg-6">

                                        <select class="form-control m-bot15" name="cid">
                                            <?PHP
                                            $cli = mysqli_query($link, "select * from rl_login where userType='Client'");
                                            while ($cli_data = mysqli_fetch_array($cli)) {
                                            ?>
                                                <option value="<?PHP echo $cli_data['id']; ?>" <?PHP if (@$_REQUEST['clientid'] == $cli_data['id']) { ?> selected <?PHP } ?>><?PHP echo $cli_data['name']; ?> [<?PHP echo $cli_data['email']; ?>]</option>
                                            <?PHP } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Project Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-file-text text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Project Name is required">
                                                <input type="text" class="form-control input100" name="pname">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Website URL</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-link text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Website URL is required">
                                                <input type="text" class="form-control input100" name="url">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Project Start Date</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-calendar text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Project start date is required">
                                                <input type="text" class="form-control input100" name="startdate" id="demo" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Keywords</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-file-text-o text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Keywords is required">
                                                <textarea name="keywords" class="form-control" style="height:140px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Package</label>
                                    <div class="col-lg-6">
                                        <select class="form-control m-bot15" name="package">
                                            <option value=""> - - Select Package - - </option>
                                            <?PHP
                                            $pack = mysqli_query($link, "select * from rl_package order by name ASC");
                                            while ($pack_data = mysqli_fetch_array($pack)) {
                                            ?>
                                                <option value="<?PHP echo $pack_data['id']; ?>"><?PHP echo ucwords($pack_data['name']); ?></option>
                                            <?PHP } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Notes</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-comments text-inverse"></i></span>
                                            <textarea name="comments" class="form-control" style="height:140px;"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3"></div>


                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="input-group m-bot15">
                                                <strong>Project Credentials</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <?PHP
                                    $credential = mysqli_query($link, "select * from rl_projects_credentials_types order by priority ASC");
                                    $k = 1;
                                    while ($credential_data = mysqli_fetch_array($credential)) {
                                    ?>
                                        <div style="background:#eef9f0; padding:10px; margin-bottom:40px; border:#093 1px solid">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> Link</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="link<?PHP echo $k; ?>">
                                                        <input type="hidden" class="form-control" name="credentialsname<?PHP echo $k; ?>" value="<?PHP echo $credential_data['name']; ?>">
                                                    </div>


                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> User</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="username<?PHP echo $k; ?>">
                                                    </div>


                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> Password</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="password<?PHP echo $k; ?>">
                                                    </div>


                                                    <div class="input-group" style="margin-bottom:-10px;">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;height:140px;" type="button"><?PHP echo $credential_data['name']; ?> Comments</button>
                                                        </span>
                                                        <textarea class="form-control" style="height:140px;" name="comments<?PHP echo $k; ?>"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?PHP
                                        $k = $k + 1;
                                    }
                                    ?>
                                    <input type="hidden" class="form-control" name="login_total" value="<?PHP echo $k - 1; ?>">

                                </div>
                                <div class="clearfix"></div><br><br>




                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Stop Status</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon" style="width:200px; border:1px solid #ccc; border-radius:4px;">
                                                <input type="radio" name="stopstatus" value="1" checked> Active
                                                <input type="radio" name="stopstatus" value="0"> Stopped
                                            </span>
                                            <input type="text" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Stop Date</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-calendar text-inverse"></i></span>
                                            <div class="wrap-input100 m-b-23">
                                                <input type="text" class="form-control input100" name="stopdate" id="demo1" readonly>
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
                    $project = mysqli_query($link, "select * from rl_projects where id='" . $_POST['pid'] . "'");
                    $project_data = mysqli_fetch_array($project);
                    ?>
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Project
                        </header>
                        <div class="panel-body">
                            <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                            <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="project.php?action=edit">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3" for="inputSuccess">Client Name</label>
                                    <div class="col-lg-6">
                                        <?PHP
                                        $cli = mysqli_query($link, "select * from rl_login where userType='Client' and id='" . $_POST['cid'] . "'");
                                        $cli_data = mysqli_fetch_array($cli);
                                        ?>
                                        <input type="text" class="form-control input100" value="<?PHP echo $cli_data['name']; ?> [<?PHP echo $cli_data['email']; ?>]" readonly>
                                        <input type="hidden" class="form-control input100" value="<?PHP echo $_POST['pid']; ?>" name="pid">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Project Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-file-text text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Project Name is required">
                                                <input type="text" class="form-control input100" name="pname" value="<?PHP echo $project_data['projectName']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Website URL</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-link text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Website URL is required">
                                                <input type="text" class="form-control input100" name="url" value="<?PHP echo $project_data['websiteUrl']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Project Start Date</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-calendar text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Project start date is required">
                                                <input type="text" class="form-control input100" name="startdate" value="<?PHP echo $project_data['startDate']; ?>" id="demo" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Keywords</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-file-text-o text-inverse"></i></span>
                                            <div class="wrap-input100 validate-input m-b-23" data-validate="Keywords is required">
                                                <textarea name="keywords" class="form-control" style="height:140px;"><?PHP echo $project_data['keywords']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Package</label>
                                    <div class="col-lg-6">
                                        <select class="form-control m-bot15" name="package">
                                            <option value=""> - - Select Package - - </option>
                                            <?PHP
                                            $pack = mysqli_query($link, "select * from rl_package order by name ASC");
                                            while ($pack_data = mysqli_fetch_array($pack)) {
                                            ?>
                                                <option value="<?PHP echo $pack_data['id']; ?>" <?PHP if ($project_data['package'] == $pack_data['id']) { ?> selected <?PHP } ?>><?PHP echo ucwords($pack_data['name']); ?></option>
                                            <?PHP } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Notes</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-comments text-inverse"></i></span>
                                            <textarea name="comments" class="form-control" style="height:140px;"><?PHP echo $project_data['notes']; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3"></div>


                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="col-lg-6">
                                            <div class="input-group m-bot15">
                                                <strong>Project Credentials</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <?PHP
                                    $credential = mysqli_query($link, "select * from rl_projects_credentials_types order by priority ASC");
                                    $k = 1;
                                    while ($credential_data = mysqli_fetch_array($credential)) {
                                        $limt = $k - 1;
                                        $sql = mysqli_query($link, "select * from rl_projects_credentials where pid='" . $_POST['pid'] . "' limit $limt,1");
                                        $sql_data = mysqli_fetch_array($sql);
                                    ?>
                                        <div style="background:#eef9f0; padding:10px; margin-bottom:40px; border:#093 1px solid">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> Link</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="link<?PHP echo $k; ?>" value="<?PHP echo $sql_data['credentialsLink']; ?>">
                                                        <input type="hidden" class="form-control" name="credentialsname<?PHP echo $k; ?>" value="<?PHP echo $credential_data['name']; ?>">
                                                    </div>


                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> User</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="username<?PHP echo $k; ?>" value="<?PHP echo $sql_data['credentialsUserName']; ?>">
                                                    </div>


                                                    <div class="input-group m-bot15">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;" type="button"><?PHP echo $credential_data['name']; ?> Password</button>
                                                        </span>
                                                        <input type="text" class="form-control" name="password<?PHP echo $k; ?>" value="<?PHP echo $sql_data['credentialsPassword']; ?>">
                                                    </div>


                                                    <div class="input-group" style="margin-bottom:-10px;">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" style="cursor:default;height:140px;" type="button"><?PHP echo $credential_data['name']; ?> Comments</button>
                                                        </span>
                                                        <textarea class="form-control" style="height:140px;" name="comments<?PHP echo $k; ?>"><?PHP echo $sql_data['comments']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?PHP
                                        $k = $k + 1;
                                    }
                                    ?>
                                    <input type="hidden" class="form-control" name="login_total" value="<?PHP echo $k - 1; ?>">

                                </div>
                                <div class="clearfix"></div><br><br>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Stop Status</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon" style="width:200px; border:1px solid #ccc; border-radius:4px;">
                                                <input type="radio" name="stopstatus" value="1" <?PHP if ($project_data['stopstatus'] == 1) { ?> checked <?PHP } ?>> Active
                                                <input type="radio" name="stopstatus" value="0" <?PHP if ($project_data['stopstatus'] == 0) { ?> checked <?PHP } ?>> Stopped
                                            </span>
                                            <input type="text" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                <?PHP
                                if ($project_data['stopdate'] == "0000-00-00") {
                                    $project_data['stopdate'] = '';
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label col-lg-3">Stop Date</label>
                                    <div class="col-lg-6">
                                        <div class="input-group m-bot15">
                                            <span class="input-group-addon btn-white"><i class="fa fa-calendar text-inverse"></i></span>
                                            <div class="wrap-input100 m-b-23">
                                                <input type="text" class="form-control input100" name="stopdate" value="<?PHP echo $project_data['stopdate']; ?>" id="demo1" readonly>
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

            </div>
        </section>
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="js/main.js"></script>



        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="js/dcalendar.picker.js"></script>
        <script>
            $('#demo').dcalendarpicker();
            $('#calendar-demo').dcalendar(); //creates the calendar

            $('#demo1').dcalendarpicker();
            $('#calendar-demo1').dcalendar(); //creates the calendar
        </script>
        <!-- footer -->
        <?php include("includes/footer.php"); ?>
        <!-- footer -->