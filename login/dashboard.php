<?php
session_start();

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

?>

<!DOCTYPE html>

<head>
  <title> Dashboard </title>

  <meta name="viewport" content="width=device-width, initial-scale=1">


  <?php include("includes/header.php"); ?>
  <!--header end-->
  <!--sidebar start-->

  <?php include("includes/left.php"); ?>

  <?PHP
    $total_client = mysqli_query($link, "select * from rl_login where userType='Client' and id!=1");
    $total_client_numee = mysqli_num_rows($total_client);

    $total_user = mysqli_query($link, "select * from rl_login where userType!='Client' and id!=1");
    $total_user_numee = mysqli_num_rows($total_user);

    $total_project = mysqli_query($link, "select * from rl_projects where stopstatus=1");
    $total_project_numee = mysqli_num_rows($total_project);

    $total_project_stop = mysqli_query($link, "select * from rl_projects where stopstatus=0");
    $total_project_stop_numee = mysqli_num_rows($total_project_stop);

    $total_client_project = mysqli_query($link, "select * from rl_projects where cid='" . $_SESSION['UID'] . "'");
    $total_client_project_numee = mysqli_num_rows($total_client_project);

    $total_linking_report = mysqli_query($link, "select * from rl_report where cid='" . $_SESSION['UID'] . "' and reportname='Linking Report'");
    $total_linking_report_numee = mysqli_num_rows($total_linking_report);

    $total_onsite_report = mysqli_query($link, "select * from rl_report where cid='" . $_SESSION['UID'] . "' and reportname='Onsite Report'");
    $total_onsite_report_numee = mysqli_num_rows($total_onsite_report);

    $total_ranking_report = mysqli_query($link, "select * from rl_report where cid='" . $_SESSION['UID'] . "' and reportname='Ranking Report'");
    $total_ranking_report_numee = mysqli_num_rows($total_ranking_report);



    $txt = '';
    $total_client_project_assign = mysqli_query($link, "select * from rl_projects_assign where cid='" . $_SESSION['UID'] . "'");
    $total_client_project_assign_numee = mysqli_num_rows($total_client_project_assign);
    while ($total_client_project_assign_value = mysqli_fetch_array($total_client_project_assign)) {
        $txt .= "pid='";
        $txt .= $total_client_project_assign_value['pid'];
        $txt .= "' OR ";
    }
    $txt .= "pid=0";


    $total_linking_report_assign = mysqli_query($link, "select * from rl_report where ($txt)  and reportname='Linking Report'");
    $total_linking_report_assign_numee = mysqli_num_rows($total_linking_report_assign);

    $total_onsite_report_assign = mysqli_query($link, "select * from rl_report where($txt) and reportname='Onsite Report'");
    $total_onsite_report_assign_numee = mysqli_num_rows($total_onsite_report_assign);

    $total_ranking_report_assign = mysqli_query($link, "select * from rl_report where ($txt) and reportname='Ranking Report'");
    $total_ranking_report_assign_numee = mysqli_num_rows($total_ranking_report_assign);
    ?>
  <!--sidebar end-->
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">

      <?PHP
            if ($_SESSION['usertype'] == 'Client') {
            ?>
      <div class="market-updates">
        <a href="client_project.php">
          <div class="col-md-6 market-update-gd" style="margin-bottom:20px;">
            <div class="market-update-block clr-block-1">
              <div class="col-md-8 market-update-left text-center">
                <h2>Projects</h2>
              </div>
              <div class="col-md-4 market-update-left text-center">
                <h2>
                  <?PHP echo $total_client_project_numee + $total_client_project_assign_numee; ?>
                </h2>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        </a>


        <a href="viewLinksReport.php">
          <div class="col-md-6 market-update-gd" style="margin-bottom:20px;">
            <div class="market-update-block clr-block-2">
              <div class="col-md-8 market-update-left text-center">
                <h2>Linking Reports</h2>
              </div>
              <div class="col-md-4 market-update-left text-center">
                <h2>
                  <?PHP echo $total_linking_report_numee + $total_linking_report_assign_numee; ?>
                </h2>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        </a>
        <div class="clearfix"> </div>

        <a href="viewOnsiteReport.php">
          <div class="col-md-6 market-update-gd">
            <div class="market-update-block clr-block-3">
              <div class="col-md-8 market-update-left text-center">
                <h2>Onsite Reports</h2>
              </div>
              <div class="col-md-4 market-update-left text-center">
                <h2>
                  <?PHP echo $total_onsite_report_numee + $total_onsite_report_assign_numee; ?>
                </h2>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        </a>

        <a href="viewRankingReport.php">
          <div class="col-md-6 market-update-gd">
            <div class="market-update-block clr-block-4">
              <div class="col-md-8 market-update-left text-center">
                <h2>Ranking Reports</h2>
              </div>
              <div class="col-md-4 market-update-left text-center">
                <h2>
                  <?PHP echo $total_ranking_report_numee + $total_ranking_report_assign_numee; ?>
                </h2>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        </a>
        <!-- //market-->

        <div class="clearfix"> </div>
        <?PHP  } ?>

        <?PHP
                if ($_SESSION['usertype'] != 'Client') {
                ?>

        <!-- //market-->
        <div class="market-updates">
          <a href="user.php?mode=show">
            <div class="col-md-6 market-update-gd">
              <div class="market-update-block clr-block-1">
                <div class="col-md-4 market-update-right">
                  <span style="font-size:50px; color:#FFF"><i class="fa fa-user"></i></span>
                </div>
                <div class="col-md-8 market-update-left">
                  <h4>Users</h4>
                  <h3>
                    <?PHP echo $total_user_numee; ?>
                  </h3>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </a>

          <a href="client.php?mode=show">
            <div class="col-md-6 market-update-gd">
              <div class="market-update-block clr-block-2">
                <div class="col-md-4 market-update-right">
                  <i class="fa fa-users"> </i>
                </div>
                <div class="col-md-8 market-update-left">
                  <h4>Clients</h4>
                  <h3>
                    <?PHP echo $total_client_numee; ?>
                  </h3>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </a>
        </div>

        <div style="clear:both;"></div>
        <div class="market-updates">

          <a href="project.php?mode=show">
            <div class="col-md-6 market-update-gd">
              <div class="market-update-block clr-block-3">
                <div class="col-md-4 market-update-right">
                  <span style="font-size:50px; color:#FFF"><i class="fa fa-bullseye"></i></span>
                </div>
                <div class="col-md-8 market-update-left">
                  <h4>Projects</h4>
                  <h3>
                    <?PHP echo $total_project_numee; ?>
                  </h3>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </a>

          <a href="projectstopped.php?mode=show">
            <div class="col-md-6 market-update-gd">
              <div class="market-update-block clr-block-3">
                <div class="col-md-4 market-update-right">
                  <span style="font-size:50px; color:#FFF"><i class="fa fa-bullseye"></i></span>
                </div>
                <div class="col-md-8 market-update-left">
                  <h4>Projects Stopped</h4>
                  <h3>
                    <?PHP echo $total_project_stop_numee; ?>
                  </h3>
                </div>
                <div class="clearfix"> </div>
              </div>
            </div>
          </a>
        </div>
        <!-- //market-->

        <!-- //graph-->
        <div class="row">
          <div class="panel-body">
            <div class="col-md-12 w3ls-graph">
              <!--agileinfo-grap-->
              <div class="agileinfo-grap">
                <div class="agileits-box">
                  <header class="agileits-box-header clearfix">
                    <h3>Client's Report Statistics</h3>
                  </header>

                  <div class="agileits-box-body clearfix">
                    <div id="hero-area"></div>
                  </div>
                </div>
              </div>
              <!--//agileinfo-grap-->

            </div>
          </div>
        </div>
        <!-- //graph-->

        <!-- tasks 
			<div class="agile-last-grids">
            	<div class="col-md-4 agile-last-left agile-last-middle">
					<div class="agile-last-grid">
						<div class="area-grids-heading">
							<h3>Daily</h3>
						</div>
						<div id="graph8"></div>
						<script>
						/* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
						var day_data = [
						  {"period": "2019-10-18", "licensed": 12},
						  {"period": "2019-09-19", "licensed": 3},
						  {"period": "2019-09-20", "licensed": 4},
						  {"period": "2019-09-21", "licensed": 7},
						  {"period": "2019-09-22", "licensed": 9},
						  {"period": "2019-09-23", "licensed": 4},
						  {"period": "2019-09-24", "licensed": 1},
						  {"period": "2019-09-25", "licensed": 3},
						  {"period": "2019-09-26", "licensed": 9},
						  {"period": "2019-09-27", "licensed": 4}
						];
						Morris.Bar({
						  element: 'graph8',
						  data: day_data,
						  xkey: 'period',
						  ykeys: ['licensed'],
						  labels: ['No. of Projects'],
						  xLabelAngle: 60
						});
						</script>
					</div>
				</div>
            
				<div class="col-md-4 agile-last-left">
					<div class="agile-last-grid">
						<div class="area-grids-heading">
							<h3>Monthly</h3>
						</div>
						<div id="graph7"></div>
						<script>
						// This crosses a DST boundary in the UK.
						Morris.Area({
						  element: 'graph7',
						  data: [
							{x: '2019-04', y: 25},
							{x: '2019-05', y: 3},
							{x: '2019-06', y: 15},
							{x: '2019-07', y: 35},
							{x: '2019-08', y: 7},
							{x: '2019-09', y: 38}
						  ],
						  xkey: 'x',
						  ykeys: ['y'],
						  labels: ['No. of Projects']
						});
						</script>

					</div>
				</div>
				
				<div class="col-md-4 agile-last-left agile-last-right">
					<div class="agile-last-grid">
						<div class="area-grids-heading">
							<h3>Yearly</h3>
						</div>
						<div id="graph9"></div>
						<script>
						var day_data = [
						  {"elapsed": "2011", "value": 250},
						  {"elapsed": "2012", "value": 25},
						  {"elapsed": "2013", "value": 150},
						  {"elapsed": "2014", "value": 300},
						  {"elapsed": "2015", "value": 28},
						  {"elapsed": "2016", "value": 50},
						  {"elapsed": "2017", "value": 320},
						  {"elapsed": "2018", "value": 250}
						];
						Morris.Line({
						  element: 'graph9',
						  data: day_data,
						  xkey: 'elapsed',
						  ykeys: ['value'],
						  labels: ['No. of Projects'],
						  parseTime: false
						});
						</script>

					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		<!-- //tasks -->

        <?PHP  } ?>



    </section>

    <!-- footer -->
    <?php include("includes/footer.php"); ?>
    <!-- footer -->