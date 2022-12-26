<?php
	include("includes/common.php");
	include("includes/database.php");
?>
<?PHP 
$ab=$_REQUEST['ab'];
?>
<div class="form-group">
  <div class="col-lg-6">
    <strong>Assigned/Owned Projects</strong>
    <ul>
      <?PHP 
$client=mysqli_query($link,"select * from rl_projects where cid=$ab");
while($client_data=mysqli_fetch_array($client))
{
echo '<li style="list-style-type: disc;">' . $client_data['projectName'].'</li>' ;
}
?>
    </ul>
  </div>
  <div class="col-lg-6">
    <strong>Assign Projects</strong><br>

    <?PHP 
$k=1;
$client=mysqli_query($link,"select * from rl_projects where cid!=$ab");
while($client_data=mysqli_fetch_array($client))
{
	


echo '<input type="checkbox" name="project'.$k.'" id="project'.$k.'" ';


$chk=mysqli_query($link,"select * from rl_projects_assign where cid=$ab and pid='".$client_data['id']."'");
	$chk_data_numee=mysqli_num_rows($chk);
	if($chk_data_numee>0){
		 echo "checked";
	}
	
echo ' value="'.$client_data['id'].'" /> ' . $client_data['projectName'].'<br>' ;
$k=$k+1;
}
?>
    <input type="hidden" name="tnumber" value="<?PHP echo $k-1; ?>">
  </div>
</div>