<?php
session_start();

require_once __DIR__ . '/includes/common.php';
require_once __DIR__ . '/includes/database.php';

require_once __DIR__ . '/includes/check-session.php';
require_once __DIR__ . '/includes/init-session.php';

if ($_SESSION['usertype'] != 'Client') {
    header("Location: $DASHBOARD_PAGE_PATH");
    exit;
}

?>

<?PHP
if (isset($_GET['action']) && $_GET['action'] == 'add') {
}

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
}


if (isset($_GET['action']) && $_GET['action'] == 'delete') {
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

        <div class="panel panel-default">
          <div class="panel-heading">VENDASTA CANCELLATION</div>

          <div class="table-responsive">


            <div align="center" style="margin:15px;" class="text-success">
              <?PHP echo $message; ?>
            </div>
            <table class="table table-striped b-t b-light">
              <thead>
                <tr>
                  <th>SN</th>
                  <th>Account Id</th>
                  <th>Partner Id</th>
                  <th>App Id </th>
                  <th>Vendor Order Id</th>
                  <th>Activation Time</th>
                  <th>Cancellation Time</th>
                  <th>Cancellation Comment</th>
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

                                $qq = "select * from vendasta_cancellation_requests where 1=1";

                                $qq .= " ORDER BY $orderfield $k";

                                //echo $qq;

                                $user = mysqli_query($link, $qq);
                                $i = 1;
                                while ($user_data = mysqli_fetch_array($user)) {
                                ?>
                <tr>
                  <td>
                    <?PHP echo $i; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['account_group_id']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['partner_id']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['app_id']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['vendor_order_id']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['activation_time']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['cancellation_time']; ?>
                  </td>
                  <td>
                    <?PHP echo $user_data['cancellation_comment']; ?>
                  </td>
                </tr>
                <?PHP
                                    $i = $i + 1;
                                } ?>
              </tbody>
            </table>
          </div>

        </div>



      </div>
    </section>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <!-- footer -->
    <?php include("includes/footer.php"); ?>
    <!-- footer -->