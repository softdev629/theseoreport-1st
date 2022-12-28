<section class="top-nav">
  <div>
    Logo Here
  </div>
  <input id="menu-toggle" type="checkbox" />
  <label class='menu-button-container' for="menu-toggle">
    <div class='menu-button'></div>
  </label>
  <ul class="menu">
    <li>
      <a class="active" href=<?php echo "dashboard.php?account_id=".$_COOKIE['account_id']; ?>>
        <i class="fa fa-home"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <?PHP 
if($_SESSION['usertype']!='Client')
{
?>
    <li class="sub-menu">
      <a href="user.php?mode=show">
        <i class="fa fa-user"></i>
        <span>User List</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="user.php?mode=add">
        <i class="fa fa-user"></i>
        <span>Add New User</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="package.php?mode=show">
        <i class="fa fa-gift"></i>
        <span>Package List</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="package.php?mode=add">
        <i class="fa fa-gift"></i>
        <span>Add New Package</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="client.php?mode=show">
        <i class="fa fa-users"></i>
        <span>Client List</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="client.php?mode=add">
        <i class="fa fa-users"></i>
        <span>Add New Client</span>
      </a>
    </li>

    <li class="sub-menu">
      <a href="project.php?mode=show">
        <i class="fa fa-laptop"></i>
        <span>Project List</span>
      </a>
    </li>
    <li class="sub-menu">
      <a href="project.php?mode=add">
        <i class="fa fa-laptop"></i>
        <span>Add New Project</span>
      </a>
    </li>

    <li>
      <a href="upload_report.php">
        <i class="fa fa-upload"></i>
        <span>Upload Report</span>
      </a>
    </li>

    <li>
      <a href="assign_projects.php?mode=show">
        <i class="fa fa-upload"></i>
        <span>Assign Projects</span>
      </a>
    </li>


    <?PHP } ?>

    <?PHP 
if($_SESSION['usertype']=='Client')
{
?>
    <li>
      <a href="client_project.php">
        <i class="fa fa-laptop"></i>
        <span>Project</span>
      </a>
    </li>

    <li>
      <a href="viewLinksReport.php">
        <i class="fa fa-book"></i>
        <span>Linking Reports</span>
      </a>
    </li>
    <li>
      <a href="viewOnsiteReport.php">
        <i class="fa fa-book"></i>
        <span>Onsite Reports</span>
      </a>
    </li>
    <li>
      <a href="viewRankingReport.php">
        <i class="fa fa-book"></i>
        <span>Ranking Reports</span>
      </a>
    </li>

    <?PHP 
}
?>

  </ul>
</section>
<aside>
  <div id="sidebar" class="nav-collapse">
    <!-- sidebar menu start-->
    <div class="leftside-navigation">
      <ul class="sidebar-menu" id="nav-accordion">
        <li>
          <a class="active" href=<?php echo "dashboard.php?account_id=".$_COOKIE['account_id']; ?>>
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <?PHP 
if($_SESSION['usertype']!='Client')
{
?>
        <li class="sub-menu">
          <a href="javascript:;">
            <i class="fa fa-user"></i>
            <span>User</span>
          </a>
          <ul class="sub">
            <li><a href="user.php?mode=show">List</a></li>
            <li><a href="user.php?mode=add">Add New</a></li>
          </ul>
        </li>

        <li class="sub-menu">
          <a href="javascript:;">
            <i class="fa fa-gift"></i>
            <span>Package</span>
          </a>
          <ul class="sub">
            <li><a href="package.php?mode=show">List</a></li>
            <li><a href="package.php?mode=add">Add New</a></li>
          </ul>
        </li>

        <li class="sub-menu">
          <a href="javascript:;">
            <i class="fa fa-users"></i>
            <span>Client</span>
          </a>
          <ul class="sub">
            <li><a href="client.php?mode=show">List</a></li>
            <li><a href="client.php?mode=add">Add New</a></li>
          </ul>
        </li>

        <li class="sub-menu">
          <a href="javascript:;">
            <i class="fa fa-laptop"></i>
            <span>Project</span>
          </a>
          <ul class="sub">
            <li><a href="project.php?mode=show">List</a></li>
            <li><a href="project.php?mode=add">Add New</a></li>
          </ul>
        </li>

        <li class="sub-menu">
          <a href="projectstopped.php?mode=show">
            <i class="fa fa-laptop"></i>
            <span>Project Stopped</span>
          </a>
        </li>

        <li>
          <a href="upload_report.php">
            <i class="fa fa-upload"></i>
            <span>Upload Report</span>
          </a>
        </li>

        <li>
          <a href="assign_projects.php?mode=show">
            <i class="fa fa-upload"></i>
            <span>Assign Projects</span>
          </a>
        </li>

        <li>
          <a href="vendasta.php">
            <i class="fa fa-book"></i>
            <span>VENDASTA PURCHASE</span>
          </a>
        </li>


        <li>
          <a href="vendasta-cancellation.php">
            <i class="fa fa-book"></i>
            <span>VENDASTA CANCELLATION</span>
          </a>
        </li>

        <?PHP } ?>

        <?PHP 
if($_SESSION['usertype']=='Client')
{
?>
        <li>
          <a href="client_project.php">
            <i class="fa fa-laptop"></i>
            <span>Project</span>
          </a>
        </li>

        <li>
          <a href="viewLinksReport.php">
            <i class="fa fa-book"></i>
            <span>Linking Reports</span>
          </a>
        </li>
        <li>
          <a href="viewOnsiteReport.php">
            <i class="fa fa-book"></i>
            <span>Onsite Reports</span>
          </a>
        </li>
        <li>
          <a href="viewRankingReport.php">
            <i class="fa fa-book"></i>
            <span>Ranking Reports</span>
          </a>
        </li>

        <?PHP 
}
?>
      </ul>
    </div>
    <!-- sidebar menu end-->
  </div>
</aside>