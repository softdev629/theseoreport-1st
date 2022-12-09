<?PHP
include("includes/common.php");
$pid=$_GET['pid'];
if($pid=='')
	{
		exit;	
	}
?>
<?PHP 
$project=mysqli_query($link,"select * from rl_projects where id=$pid");
$project_data=mysqli_fetch_array($project);
$dd = $project_data['startDate'];
$cid = $project_data['cid'];

$date1 = $dd;
$date2 = date('Y-m-d');

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

$day = date('d');
$m = date('m');
$year = date('Y');
	
    for($i=0;$i<$diff+1;$i++){
    $monthname=date('F Y', mktime(0,0,0,$m-$i,$day,$year));
?>
<div class="col-lg-5" style="background:#eef9f0; border:1px solid #ccc; padding-top:10px; padding-bottom:10px; line-height:30px; margin-bottom:20px; margin-right:5px;" >
		<h2 style="text-align:center"><?PHP echo $monthname; ?> &nbsp;&nbsp;&nbsp; <a href="upload_reports.php?pid=<?PHP echo $pid; ?>&cid=<?PHP echo $cid; ?>&reportmonth=<?PHP echo $monthname; ?>"><i class="fa fa-arrow-circle-up text-inverse" title="Upload Report" style="font-size:25px;"></i></a></h2><br /><br />
    
<div style="margin-left:10px;">
<span class="text-inverse">Links Report</span>
<div style="float:right; margin-right:10px; font-size:20px;">
<?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Links Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
<a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:20px;"></i></a> &nbsp; &nbsp;  
<a href="upload_report.php?action=delete&pid=<?PHP echo $pid; ?>&cid=<?PHP echo $cid; ?>&reportmonth=<?PHP echo $monthname; ?>&reportname=BackLink Report" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash-o text-danger" title="Delete Report" style="font-size:20px;"></i></a>
<?PHP } ?>
</div><br />

<span class="text-inverse">Onsite Report</span> 
<div style="float:right; margin-right:10px; font-size:20px;">
<?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Onsite Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
<a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:20px;"></i></a> &nbsp; &nbsp;  
<a href="upload_report.php?action=delete&pid=<?PHP echo $pid; ?>&cid=<?PHP echo $cid; ?>&reportmonth=<?PHP echo $monthname; ?>&reportname=Web Inscriptions Report" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash-o text-danger" title="Delete Report" style="font-size:20px;"></i></a>
<?PHP } ?>
</div><br />

<span class="text-inverse">Ranking Report</span>
<div style="float:right; margin-right:10px; font-size:20px;">
<?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Ranking Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
<a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success" title="View Report" style="font-size:20px;"></i></a> &nbsp; &nbsp;  
<a href="upload_report.php?action=delete&pid=<?PHP echo $pid; ?>&cid=<?PHP echo $cid; ?>&reportmonth=<?PHP echo $monthname; ?>&reportname=Article Report" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fa fa-trash-o text-danger" title="Delete Report" style="font-size:20px;"></i></a>
<?PHP } ?>
</div>
</div>
    </div>
	  
<?PHP  } ?>