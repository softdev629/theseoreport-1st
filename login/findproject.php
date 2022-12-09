<?PHP
include("includes/common.php");
$cid=$_GET['cid'];
?>

<select class="input-sm form-control w-sm inline v-middle" name="pid" style="width:215px;" onchange="getUploadedRecord('finduploadedrecord.php?cid=<?PHP echo $cid; ?>&pid='+this.value)" required>
<option value=''> &nbsp; &nbsp; &nbsp; - - &nbsp; Select Project Name &nbsp; - - </option>
<?PHP 
$cli=mysqli_query($link,"select * from rl_projects where stopstatus=1 and cid=$cid order by projectName asc");
while($cli_data=mysqli_fetch_array($cli))
{
?>
<option value="<?PHP echo $cli_data['id']; ?>" ><?PHP echo $cli_data['projectName']; ?> </option>
<?PHP } ?>
</select>  <input type="hidden" name="cid" value="<?PHP echo $_REQUEST['cid']; ?>"> 
