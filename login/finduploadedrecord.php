<?PHP
include("includes/common.php");
$cid=$_GET['cid'];
$pid=$_GET['pid'];
if($pid=='')
	{
		exit;	
	}
?>

<div class="form-group"> 
<div class="col-lg-4">
<table class="table table-striped b-t b-light" >
<thead>
<tr>
<th colspan="3" align="center">Linking Report</th>
</tr>
</thead>
<tbody>
<?PHP 
$qq="select * from rl_report where pid='".$_REQUEST['pid']."' and reportname='Linking Report' order by reportname desc";
$user=mysqli_query($link,$qq);
$i=1;
while($user_data=mysqli_fetch_array($user))
{
$orgDate = $user_data['reportmonth1'];
$newDate = date("d F Y", strtotime($orgDate));
?>    
<tr>
<td><?PHP echo $i; ?>.</td>
<td><?PHP echo $user_data['reporttype']; ?><br /><?PHP echo $newDate; ?></td>
<td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i class="fa  fa-download text-inverse" title="Download Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a></td>
</tr>
<?PHP 
$i=$i+1;
} ?>
</tbody>
</table>
</div>
<div class="col-lg-4" >
<table class="table table-striped b-t b-light" >
<thead>
<tr>
<th colspan="3" align="center">Ranking Report</th>
</tr>
</thead>
<tbody>
<?PHP 
$qq="select * from rl_report where pid='".$_REQUEST['pid']."' and reportname='Ranking Report' order by reportname desc";
$user=mysqli_query($link,$qq);
$i=1;
while($user_data=mysqli_fetch_array($user))
{
$orgDate = $user_data['reportmonth1'];
$newDate = date("d F Y", strtotime($orgDate));
?>    
<tr>
<td><?PHP echo $i; ?>.</td>
<td><?PHP echo $newDate; ?></td>
<td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i class="fa  fa-download text-inverse" title="Download Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a></td>
</tr>
<?PHP 
$i=$i+1;
} ?>
</tbody>
</table>
</div>
<div class="col-lg-4"  >
<table class="table table-striped b-t b-light" >
<thead>
<tr>
<th colspan="3" align="center">Onsite Report</th>
</tr>
</thead>
<tbody>
<?PHP 
$qq="select * from rl_report where pid='".$_REQUEST['pid']."' and reportname='Onsite Report' order by reportname desc";
$user=mysqli_query($link,$qq);
$i=1;
while($user_data=mysqli_fetch_array($user))
{
$orgDate = $user_data['reportmonth1'];
$newDate = date("d F Y", strtotime($orgDate));
?>    
<tr>
<td><?PHP echo $i; ?>.</td>
<td><?PHP echo $newDate; ?></td>
<td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i class="fa  fa-download text-inverse" title="Download Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:15px;"></i></a>&nbsp;&nbsp;&nbsp;
<a href="upload_report.php?action=delete&rid=<?PHP echo $user_data['id']; ?>&cid=<?PHP echo $cid; ?>&pid=<?PHP echo $pid; ?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-times-circle text-danger text" style="font-size:15px; cursor:pointer;"></i></a></td>
</tr>
<?PHP 
$i=$i+1;
} ?>
</tbody>
</table>
</div>
</div>
