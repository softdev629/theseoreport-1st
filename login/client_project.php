<?php include("includes/common.php"); ?>

<?php include("includes/check_session.php"); ?>

<?PHP 
if($_SESSION['usertype']!='Client')
{
	header('Location: dashboard.php');
	exit;
}
?>
<!DOCTYPE html><head>
<title>Project </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/main.css">


<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link href="css/dcalendar.picker.css" rel="stylesheet" type="text/css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<style>
.container { margin:150px auto 30px auto; max-width:300px;}
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
           
  <div class="panel panel-default">
    <div class="panel-heading">Project List</div>
    <div class="table-responsive">



<div align="center" style="margin:15px;" class="text-success"><?PHP echo $message; ?></div>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>S.No.</th>
            <th style="width:50%">Project </th>
            <th>Package</th>
            <th>Status</th>
            </tr>
        </thead>
        <tbody>
<?PHP 
$k=@$_REQUEST['orderby'];
if($k=='') { $k="DESC"; }

$orderfield=@$_REQUEST['orderfield'];
if($orderfield=='') { $orderfield="id"; }

$qq="select * from rl_projects where 1=1 and cid='".$_SESSION['UID']."' ";	

$qq.=" ORDER BY $orderfield $k";

//echo $qq;

$project=mysqli_query($link,$qq);
$i=1;
while($project_data=@mysqli_fetch_array($project))
{
	$client=mysqli_query($link,"select * from rl_login where id='".$project_data['cid']."'");
	$client_data=mysqli_fetch_array($client);
	
	$pack=mysqli_query($link,"select * from rl_package where id='".$project_data['package']."'");
	$pack_data=mysqli_fetch_array($pack);
	
	$created=mysqli_query($link,"select * from rl_login where id='".$project_data['createdBy']."'");
	$created_data=mysqli_fetch_array($created);
	
$newdate=explode('-',$project_data['startDate']);
$newstartdate=$newdate[1].'-'.$newdate[2].'-'.$newdate[0];	
?>    
<tr>
<td><?PHP echo $i; ?></td>
<td><?PHP echo $project_data['projectName']; ?><br /><a href="<?PHP echo $project_data['websiteUrl']; ?>" target="_blank"><?PHP echo $project_data['websiteUrl']; ?></a><br />
<strong>Start Date:</strong>&nbsp;&nbsp; <?PHP echo $newstartdate; ?>
</td>
<td><?PHP echo ucwords($pack_data['name']); ?></td>
<td><?PHP if($project_data['stopstatus']==1) { echo "<span class='text-success'>Active</span>"; } else { echo "<span class='text-danger'>Stopped</span>"; } ?></td>
</tr>
<?PHP 
$i=$i+1;
} ?>


<?PHP 
$chk1="select * from rl_projects_assign where cid='".$_SESSION['UID']."' ";
$chk=mysqli_query($link,$chk1);

while($chk_data=@mysqli_fetch_array($chk))
{
	$qq="select * from rl_projects where id='".$chk_data['pid']."' ";
	$project=mysqli_query($link,$qq);
	$project_data=@mysqli_fetch_array($project);
	
	$client=mysqli_query($link,"select * from rl_login where id='".$project_data['cid']."'");
	$client_data=mysqli_fetch_array($client);
	
	$pack=mysqli_query($link,"select * from rl_package where id='".$project_data['package']."'");
	$pack_data=mysqli_fetch_array($pack);
	
$newdate=explode('-',$project_data['startDate']);
$newstartdate=$newdate[1].'-'.$newdate[2].'-'.$newdate[0];	
?>    
<tr>
<td><?PHP echo $i; ?></td>
<td><?PHP echo $project_data['projectName']; ?><br /><a href="<?PHP echo $project_data['websiteUrl']; ?>" target="_blank"><?PHP echo $project_data['websiteUrl']; ?></a><br />
<strong>Start Date:</strong>&nbsp;&nbsp; <?PHP echo $newstartdate; ?>
</td>
<td><?PHP echo ucwords($pack_data['name']); ?></td>
<td><?PHP if($project_data['stopstatus']==1) { echo "<span class='text-success'>Active</span>"; } else { echo "<span class='text-danger'>Stopped</span>"; } ?></td>
</tr>
<?PHP 
$i=$i+1;
} ?>


        </tbody>
      </table>
    </div>
  </div> 
  
</div>
</section>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
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
		 
