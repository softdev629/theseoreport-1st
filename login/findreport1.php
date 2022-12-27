<?PHP
session_start();
include("includes/common.php");
include("includes/database.php");
include("includes/init-session.php");
$pid=$_GET['pid'];
$cid=$_SESSION['UID'];
$sql=mysqli_query($link,"select * from rl_projects where id='".$pid."'");
$sql_data=mysqli_fetch_array($sql);

if($pid=='')
	{
		exit;	
	}
	?>



<table class="table table-striped b-t b-light">
  <thead>
    <tr>
      <th colspan="4" align="center">Linking Report - <span style="color:#0066CC;"><a
            href="<?PHP echo $sql_data['websiteUrl']; ?>" target="_blank">
            <?PHP echo $sql_data['websiteUrl']; ?>
          </a> </span>
        <div align="right">
          <?PHP if($sql_data['stopstatus']==0) { echo "<span class='text-danger'>Stopped</span>"; } else { echo "<span class='text-success'>Active</span>"; } ?>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    <?PHP 
$qq="select * from rl_report where pid='".$pid."' and cid='".$_SESSION['UID']."' and reportname='Linking Report' order by reportmonth1 desc";
$user=mysqli_query($link,$qq);
$user_numee=mysqli_num_rows($user);
$i=1;
while($user_data=mysqli_fetch_array($user))
{
$orgDate = $user_data['reportmonth1'];
$newDate = date("d F Y", strtotime($orgDate));
?>
    <tr>
      <td>
        <?PHP echo $i; ?>.
      </td>
      <td>
        <?PHP echo $user_data['reporttype']; ?>
      </td>
      <td>
        <?PHP echo $newDate; ?>
      </td>
      <td><a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank" download><i
            class="fa  fa-download text-inverse" title="Download Report"
            style="font-size:25px;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="reports/<?PHP echo $user_data['imgPath']; ?>" target="_blank"><i class="fa  fa-eye text-success"
            title="View Report" style="font-size:25px;"></i></a>
      </td>
    </tr>
    <?PHP 
$i=$i+1;
}
if($user_numee==0)
{
 ?>
    <tr>
      <td colspan="4" align="center" style="color:#FF0000;">No Report Found.</td>
    </tr>
    <?PHP } ?>
  </tbody>
</table>