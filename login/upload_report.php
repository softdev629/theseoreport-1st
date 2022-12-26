<?php

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['usertype'] != 'Administrator') {
    header("Location: $DASHBOARD_PAGE_PATH");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $cid = $_POST['cid'];
    $pid = $_POST['pid'];
    $reportmonth1 = $_POST['ryear'] . '-' . $_POST['rmonth'] . '-25';
    $reportmonth1 = $_POST['reportdate'];

    for ($i = 1; $i <= 3; $i++) {

        $target_path = '';
        $docpath = '';
        $reportname = $_POST['reportname' . $i];
        $docpath = $_FILES['img' . $i]['name'];
        $check = substr($docpath, -4);
        if ($check == '.pdf' || $check == '.doc' || $check == 'docx' || $check == '.xls' || $check == 'xlsx') {
            if ($docpath != '') {
                $target_path = "reports/" . rand();
                $target_path = $target_path . str_replace(' ', '_', basename($_FILES['img' . $i]['name']));
                move_uploaded_file($_FILES['img' . $i]['tmp_name'], $target_path);
                $target_path = str_replace('reports/', '', $target_path);
            }
            if ($reportname == "Linking Report") {
                $reporttype = $_POST['reporttype'];
            } else {
                $reporttype = '';
            }
            mysqli_query($link, "insert into rl_report(cid,pid,reportname,reporttype,reportmonth1,imgPath,dateAdded) values('$cid','$pid','$reportname','$reporttype','$reportmonth1','$target_path','" . $today . "')");
        }
    }

    //header("location: upload_report.php?cid=$cid&pid=$pid&msg=added");	

}


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $pid = $_REQUEST['pid'];
    $cid = $_REQUEST['cid'];
    $rid = $_REQUEST['rid'];
    $reportmonth = $_REQUEST['reportmonth'];
    $reportname = $_REQUEST['reportname'];

    mysqli_query($link, "delete from rl_report where pid='$pid' and cid='$cid' and id='$rid'");
    header("location: upload_report.php?cid=$cid&pid=$pid&&msg=deleted");
    exit;
}
?>

<!DOCTYPE html>

<head>
  <title>Upload Report </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/main.css">

  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link href="css/dcalendar.picker.css" rel="stylesheet" type="text/css">
  <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

  <script>
  function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e1) {
          xmlhttp = false;
        }
      }
    }

    return xmlhttp;
  }

  function getProject(strURL) {
    var req = getXMLHTTP();
    if (req) {
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          if (req.status == 200) {
            document.getElementById('projectdiv').innerHTML = req.responseText;
          } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send();
    }
  }

  function getProjectDate(strURL) {
    var req = getXMLHTTP();
    if (req) {
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          if (req.status == 200) {
            document.getElementById('projectdatediv').innerHTML = req.responseText;
          } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send();
    }
  }

  function getUploadedRecord(strURL) {
    var req = getXMLHTTP();
    if (req) {
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          if (req.status == 200) {
            document.getElementById('uploadeddiv').innerHTML = req.responseText;
          } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
          }
        }
      }
      req.open("GET", strURL, true);
      req.send();
    }
  }

  function validateFileSize39(id, div) {

    var aspFileUpload = document.getElementById("img1");
    var errorLabel = document.getElementById("ErrorLabel_39");
    var sucessLabel = document.getElementById("SucessLabel_39");
    var fileName = aspFileUpload.value;
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (!(ext == "pdf" || ext == "doc" || ext == "docx" || ext == "xls" || ext == "xlsx")) {
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

  function validateFileSize40(id, div) {

    var aspFileUpload = document.getElementById("img2");
    var errorLabel = document.getElementById("ErrorLabel_40");
    var sucessLabel = document.getElementById("SucessLabel_40");
    var fileName = aspFileUpload.value;
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (!(ext == "pdf" || ext == "doc" || ext == "docx" || ext == "xls" || ext == "xlsx")) {
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

  function validateFileSize41(id, div) {

    var aspFileUpload = document.getElementById("img3");
    var errorLabel = document.getElementById("ErrorLabel_41");
    var sucessLabel = document.getElementById("SucessLabel_41");
    var fileName = aspFileUpload.value;
    var ext = fileName.substr(fileName.lastIndexOf('.') + 1).toLowerCase();

    if (!(ext == "pdf" || ext == "doc" || ext == "docx" || ext == "xls" || ext == "xlsx")) {
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

  <!--sidebar end-->
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
      <div class="table-agile-info">

        <div class="panel panel-default">
          <div class="panel-heading">Upload Report</div>
          <?PHP
                    if ($_SESSION['usertype'] != 'Client') {
                    ?>
          <form name="search1" method="post" action="upload_report.php?action=add" enctype="multipart/form-data">


            <div class="row w3-res-tb" style="margin-left:5px; min-height:400px;">

              <div class="col-md-3" style="margin-bottom:20px;">
                <select class="input-sm form-control w-sm inline v-middle" name="cid" style="width:215px;"
                  onchange="getProject('findproject.php?cid='+this.value)" required>
                  <option value=''> &nbsp; &nbsp; &nbsp; - - &nbsp; Select Client Name &nbsp; - - </option>
                  <?PHP
                                        $cli = mysqli_query($link, "select * from rl_login where userType='Client'");
                                        while ($cli_data = mysqli_fetch_array($cli)) {
                                        ?>
                  <option value="<?PHP echo $cli_data['id']; ?>" <?PHP if ($_REQUEST['cid']==$cli_data['id']) { ?>
                    selected
                    <?PHP } ?>>
                    <?PHP echo $cli_data['name']; ?> [
                    <?PHP echo $cli_data['email']; ?>]
                  </option>
                  <?PHP } ?>
                </select>
              </div>

              <div class="col-md-3" style="margin-bottom:20px;" id="projectdiv">

                <select class="input-sm form-control w-sm inline v-middle" name="pid" style="width:215px;"
                  onchange="getUploadedRecord('finduploadedrecord.php?pid='+this.value)" required>
                  <option value=''> &nbsp; &nbsp; &nbsp; - - &nbsp; Select Project Name &nbsp; - - </option>
                  <?PHP
                                        $cli = mysqli_query($link, "select * from rl_projects where cid='" . $_REQUEST['cid'] . "'");
                                        while ($cli_data = mysqli_fetch_array($cli)) {
                                        ?>
                  <option value="<?PHP echo $cli_data['id']; ?>" <?PHP if ($cli_data['id']==$_REQUEST['pid']) { ?>
                    selected
                    <?PHP } ?>>
                    <?PHP echo $cli_data['projectName']; ?>
                  </option>
                  <?PHP } ?>
                </select>

              </div>
              <div class="clearfix"></div>

              <?PHP if ($_REQUEST['msg'] == 'added') { ?>
              <div style="margin-bottom:15px;" class="text-inverse" align="center"> Reports uploaded successfully</div>
              <?PHP } ?>
              <?PHP if ($_REQUEST['msg'] == 'deleted') { ?>
              <div style="margin-bottom:15px;" class="text-danger" align="center"> Reports deleted successfully </div>
              <?PHP } ?>

              <div class="clearfix"></div>

              <section class="panel">
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-3 control-label col-lg-3">&nbsp;</label>
                    <div class="col-lg-6" align="center">
                      <span class="text-inverse" style=" font-size:14px;">*** Upload only
                        <strong>pdf,doc,docx,xls,xlsx</strong> file.<br /><br /></span>
                    </div>
                  </div>
                  <div style="clear:both;"></div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label col-lg-3">Linking Report Type</label>
                    <div class="col-lg-6">
                      <select class="input-sm form-control w-sm inline v-middle" name="reporttype" style="width:210px;">
                        <option value=''> &nbsp; &nbsp; &nbsp; - - &nbsp; Linking Report Type &nbsp; - - </option>
                        <option value="DA Links">DA Links </option>
                        <option value="Document Links">Document Links </option>
                      </select>
                      <div class="input-group m-bot15">

                      </div>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label col-lg-3">Linking Report</label>
                      <div class="col-lg-6">
                        <input name="reportname1" type="hidden" value="Linking Report" id="reportname1" />
                        <div class="input-group m-bot15">
                          <span class="input-group-addon btn-white"><i
                              class="fa fa-cloud-upload text-inverse"></i></span>
                          <div class="wrap-input100 validate-input m-b-23">
                            <input name="img1" type="file" id="img1" class="form-control"
                              onChange="validateFileSize39(this.id,'dvMsg_39');" />
                          </div>
                        </div>
                        <div id="dvMsg_39"
                          style="background-color:#c91822; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; text-align:center; display:none;">
                          <span class="jpg_pdf" style="color:#000; text-align:center;">Max. size is 2 MB</span>
                        </div>
                        <div id="ErrorLabel_39"
                          style="background-color:#c91822; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">Invalid file format</span>
                        </div>
                        <div id="SucessLabel_39"
                          style="background-color:#53741d; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">File Selected</span>
                        </div>
                      </div>
                    </div>


                    <div style="clear:both;"></div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label col-lg-3">Onsite Report</label>
                      <div class="col-lg-6">
                        <input name="reportname2" type="hidden" value="Onsite Report" id="reportname2" />
                        <div class="input-group m-bot15">
                          <span class="input-group-addon btn-white"><i
                              class="fa fa-cloud-upload text-inverse"></i></span>
                          <div class="wrap-input100 validate-input m-b-23">
                            <input name="img2" type="file" id="img2" class="form-control"
                              onChange="validateFileSize40(this.id,'dvMsg_40');" />
                          </div>
                        </div>
                        <div id="dvMsg_40"
                          style="background-color:#c91822; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; text-align:center; display:none;">
                          <span class="jpg_pdf" style="color:#000; text-align:center;">Max. size is 2 MB</span>
                        </div>
                        <div id="ErrorLabel_40"
                          style="background-color:#c91822; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">Invalid file format</span>
                        </div>
                        <div id="SucessLabel_40"
                          style="background-color:#53741d; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">File Selected</span>
                        </div>
                      </div>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label col-lg-3">Ranking Report</label>
                      <div class="col-lg-6">
                        <input name="reportname3" type="hidden" value="Ranking Report" id="reportname3" />
                        <div class="input-group m-bot15">
                          <span class="input-group-addon btn-white"><i
                              class="fa fa-cloud-upload text-inverse"></i></span>
                          <div class="wrap-input100 validate-input m-b-23">
                            <input name="img3" type="file" id="img3" class="form-control"
                              onChange="validateFileSize41(this.id,'dvMsg_41');" />
                          </div>
                        </div>
                        <div id="dvMsg_41"
                          style="background-color:#c91822; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; text-align:center; display:none;">
                          <span class="jpg_pdf" style="color:#000; text-align:center;">Max. size is 2 MB</span>
                        </div>
                        <div id="ErrorLabel_41"
                          style="background-color:#c91822; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">Invalid file format</span>
                        </div>
                        <div id="SucessLabel_41"
                          style="background-color:#53741d; text-align:center; color:White; font-size:12px;  width:200px; padding:3px; margin-top: -18px; margin-bottom: 10px; display:none;">
                          <span class="jpg_pdf" style="color:#fff; text-align:center;">File Selected</span>
                        </div>
                      </div>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label col-lg-3">Report for Month</label>
                      <div class="col-lg-3">
                        <div class="input-group m-bot15">
                          <div class="wrap-input50 validate-input m-b-23"
                            data-validate="Project start date is required">
                            <input type="text" class="form-control input100" name="reportdate" id="demo"
                              style="width:160px;" required>
                          </div><br />

                          <div class="col-lg-3"> <br />
                            <button type="submit" style=" margin-left:200px;" class="btn btn-info">Submit</button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
              </section>
            </div>
          </form>
          <?PHP } ?>


          <div class="table-responsive" id="uploadeddiv">
            <?PHP if (@$_REQUEST['pid'] != '') { ?>
            <div class="form-group">
              <div class="col-lg-4">
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th colspan="3" align="center">Linking Report</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?PHP
                                            $qq = "select * from rl_report where pid='" . $_REQUEST['pid'] . "' and reportname='Linking Report' order by reportname desc";
                                            $user = mysqli_query($link, $qq);
                                            $i = 1;
                                            while ($user_data = mysqli_fetch_array($user)) {
                                                $orgDate = $user_data['reportmonth1'];
                                                $newDate = date("F, Y", strtotime($orgDate));
                                            ?>
                    <tr>
                      <td>
                        <?PHP echo $i; ?>.
                      </td>
                      <td>
                        <?PHP echo $newDate; ?>
                      </td>
                      <td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i
                            class="fa  fa-download text-inverse" title="Download Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i
                            class="fa  fa-eye text-success" title="View Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>"
                          onclick="return confirm('Are you sure you want to delete this record?');"><i
                            class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a>
                      </td>
                    </tr>
                    <?PHP
                                                $i = $i + 1;
                                            } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-lg-4">
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th colspan="3" align="center">Ranking Report</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?PHP
                                            $qq = "select * from rl_report where pid='" . $_REQUEST['pid'] . "' and reportname='Ranking Report' order by reportname desc";
                                            $user = mysqli_query($link, $qq);
                                            $i = 1;
                                            while ($user_data = mysqli_fetch_array($user)) {
                                                $orgDate = $user_data['reportmonth1'];
                                                $newDate = date("F, Y", strtotime($orgDate));
                                            ?>
                    <tr>
                      <td>
                        <?PHP echo $i; ?>.
                      </td>
                      <td>
                        <?PHP echo $newDate; ?>
                      </td>
                      <td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i
                            class="fa  fa-download text-inverse" title="Download Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i
                            class="fa  fa-eye text-success" title="View Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>"
                          onclick="return confirm('Are you sure you want to delete this record?');"><i
                            class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a>
                      </td>
                    </tr>
                    <?PHP
                                                $i = $i + 1;
                                            } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-lg-4">
                <table class="table table-striped b-t b-light">
                  <thead>
                    <tr>
                      <th colspan="3" align="center">Onsite Report</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?PHP
                                            $qq = "select * from rl_report where pid='" . $_REQUEST['pid'] . "' and reportname='Onsite Report' order by reportname desc";
                                            $user = mysqli_query($link, $qq);
                                            $i = 1;
                                            while ($user_data = mysqli_fetch_array($user)) {
                                                $orgDate = $user_data['reportmonth1'];
                                                $newDate = date("d F Y", strtotime($orgDate));
                                            ?>
                    <tr>
                      <td>
                        <?PHP echo $i; ?>.
                      </td>
                      <td>
                        <?PHP echo $newDate; ?>
                      </td>
                      <td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i
                            class="fa  fa-download text-inverse" title="Download Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i
                            class="fa  fa-eye text-success" title="View Report"
                            style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
                        <a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>"
                          onclick="return confirm('Are you sure you want to delete this record?');"><i
                            class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a>
                      </td>
                    </tr>
                    <?PHP
                                                $i = $i + 1;
                                            } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?PHP } ?>
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

      </div>
    </section>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/dcalendar.picker.js"></script>
    <script>
    $('#demo').dcalendarpicker();
    $('#calendar-demo').dcalendar(); //creates the calendar
    </script>
    <!-- footer -->
    <?php include("includes/footer.php"); ?>
    <!-- footer -->