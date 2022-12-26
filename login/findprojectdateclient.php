<?PHP
include("includes/common.php");
include("includes/database.php");
$pid=$_GET['pid'];
if($pid=='')
	{
		exit;	
	}
	?>
<?PHP 
$project=mysqli_query($link,"select * from rl_projects where id=$pid and cid='".$_SESSION['UID']."'");
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
<div class="col-lg-5"
  style="background:#eef9f0; border:1px solid #ccc; padding-top:10px; padding-bottom:10px; line-height:30px; margin-bottom:20px; margin-right:5px;">
  <h2 style="text-align:center">
    <?PHP echo $monthname; ?>
  </h2><br /><br />

  <div style="margin-left:10px;">
    <span class="text-inverse">BackLink Report</span>
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='BackLink Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a
        href="download_file1.php?action=download&pid=<?PHP echo $pid; ?>&cid=<?PHP echo $cid; ?>&reportmonth=<?PHP echo $monthname; ?>&reportname=BackLink Report"><i
          class="fa  fa-download text-inverse" title="Download Report"
          style="font-size:20px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    <span class="text-inverse">Web Inscriptions Report</span>
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Web Inscriptions Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    <span class="text-inverse">Social Media Report</span> <br />
    - Article Report
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Article Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    - Press Release Report
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Press Release Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    - Blog Posting Report
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Blog Posting Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    <span class="text-inverse">Web 2.0 Report</span> <br />
    - Social Media Report
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Social Media Links Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    - Social Bookmarking
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='Social Bookmarking Link Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

    - RSS Feed Report
    <div style="float:right; margin-right:10px; font-size:20px;">
      <?PHP 
$rec=mysqli_query($link,"select * from rl_report where cid=$cid and pid=$pid and reportmonth='$monthname' and reportname='RSS Feed Report'");
$rec_data=mysqli_fetch_array($rec);
if($rec_data['imgPath']!='') {
?>
      <a href="reports/<?PHP echo $rec_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
          title="View Report" style="font-size:20px;"></i></a>
      <?PHP } ?>
    </div><br />

  </div>

</div>

<?PHP
    }
?>