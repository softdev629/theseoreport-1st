<?PHP 
include("includes/common.php");

if($_POST['old_pass']!='')
{

$oldpass=$_POST['old_pass'];
$newpass=$_POST['new_pass'];
$confpass=$_POST['confirm_pass'];
			
		 if(empty($oldpass)||empty($newpass)||empty($confpass))
		 		{
				$_REQUEST['empty']="empty";
				include("change_password.php");
				exit;
				}
			
				if($oldpass!="" && $newpass!="" && $confpass!="")
				{				
				  if($newpass==$confpass)
				  {
				 
				    $query = mysqli_query($link,"select * from rl_login where email='".$_SESSION['username']."' and password='$oldpass'");
				  
				  	if(mysqli_affected_rows($link)>0)
					{
					
					$update=mysqli_query($link,"update rl_login set password='$newpass' where email='".$_SESSION['username']."' and password='$oldpass'");
					 if(mysqli_affected_rows($link)>0)
					 {
					 $_REQUEST['change']="change";
					 include("change_password.php");
					 exit;
					 }
					}
					 else
					 {
					   $_REQUEST['notold']="notold";
					 include("change_password.php");
					 exit;
					 }
				  }
				  else
				  {
				$_REQUEST['notmatch']="notmatch";
				include("change_password.php");
				exit;
				  }
				}
}
?>