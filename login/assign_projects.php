<?php include("includes/common.php"); ?>

<?php include("includes/check_session.php"); ?>

<?PHP 
if($_SESSION['usertype']=='Client')
{
	header('Location: dashboard.php');
	exit;
}
?>

<?PHP 
if(isset($_GET['action']) && $_GET['action']=='add') 
	{ 
	mysqli_query($link,"delete from rl_projects_assign where cid='".$_POST['cid']."'");
             
	   $tnumber=$_POST['tnumber'];
	   for($m=1;$m<=$tnumber;$m++)
	   		{	
				if($_POST['project'.$m]!='')
					{
mysqli_query($link,"insert into rl_projects_assign(cid,pid) values('".$_POST['cid']."','".$_POST['project'.$m]."')");
					}	
			}
			header("location: assign_projects.php?mode=show&msg=added");	
	}
		


if(isset($_GET['msg']) && $_GET['msg']=='added')
	{
		$message='Record Updated Successfully.';
	}
if(isset($_GET['msg']) && $_GET['msg']=='edited')
	{
		$message='Record Edited Successfully.';
	}	
if(isset($_GET['msg']) && $_GET['msg']=='deleted')
	{
		$message='Record Delete Successfully.';
	}
if(isset($_GET['msg']) && $_GET['msg']=='exist')
	{
		$message='Username already exist.';
	}	
?>

<!DOCTYPE html><head>
<title>Client </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/main.css">

 <script language="javascript" type="application/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}

function getProject(strURL) {               
        var req = getXMLHTTP();       
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {                        
                        document.getElementById('projectdiv').innerHTML = this.responseText;
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }                
            }            
            req.open("GET", strURL, true);
            req.send(null);
        }
                
    }
	</script>

<?php include("includes/header.php"); ?>
<!--header end-->
<!--sidebar start-->

<?php include("includes/left.php"); ?>

<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<div class="table-agile-info">
        
  <?PHP if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='show') { ?>      
  <div class="panel panel-default">
    <div class="panel-heading">Assign Projects</div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">  
	   <form action="assign_projects.php">
    <input type="hidden" name="mode" value="add">
    <button type="submit" class="btn btn-info">Assign  Project</button>
    </form>      
      </div>
      <div class="col-sm-4">
    <div class="form-group">
   <div align="center"  class="text-success"><?PHP echo $message; ?></div>
    </div>
      </div>
      

    </div>
    <div class="table-responsive">
<?PHP 
$searchkeyword=@$_REQUEST['searchkeyword'];
?>


      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>S.No.</th>
            <th>Name 
<a href="client.php?orderby=DESC&page=<?php echo $page;?>&searchkeyword=<?php echo $searchkeyword;?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp &nbsp <i class="fa fa-sort-alpha-desc text-inverse" title="Descending Order"></i></span></a>
<a href="client.php?orderby=ASC&page=<?php echo $page;?>&searchkeyword=<?php echo $searchkeyword;?>&orderfield=name&mode=show"><span style="font-size:19px;">&nbsp <i class="fa fa-sort-alpha-asc text-success" title="Ascending Order"></i></span></a>              </th>
            <th> Assigned/Owned Projects </th>
            <th>Assign Projects</th>
            </tr>
        </thead>
        <tbody>
<?PHP 
$k=@$_REQUEST['orderby'];
if($k=='') { $k="DESC"; }

$orderfield=@$_REQUEST['orderfield'];
if($orderfield=='') { $orderfield="id"; }

$qq="select * from rl_login where 1=1  and userType='Client'";

if(@$_REQUEST['searchkeyword'])
	{
		$qq.=" and (email LIKE '%".$_REQUEST['searchkeyword']."%' OR name LIKE '%".$_REQUEST['searchkeyword']."%' OR phone LIKE '%".$_REQUEST['searchkeyword']."%' )";
	}	

$qq.=" ORDER BY $orderfield $k";

//echo $qq;

$user=mysqli_query($link,$qq);
$i=1;
while($user_data=mysqli_fetch_array($user))
{
	
	$created=mysqli_query($link,"select * from rl_login where id='".$user_data['createdBy']."'");
	$created_data=mysqli_fetch_array($created);
?>    
<tr>
<td><?PHP echo $i; ?></td>
<td><?PHP echo $user_data['name']; ?></td>
<td><?PHP 
$client=mysqli_query($link,"select * from rl_projects where cid='".$user_data['id']."'");
while($client_data=mysqli_fetch_array($client))
{
echo '<li style="list-style-type: disc;">' . $client_data['projectName'].'</li>' ;
}
?></td>
<td>
<?PHP 
$sql=mysqli_query($link,"select * from rl_projects_assign where cid='".$user_data['id']."'");
while($sql_data=mysqli_fetch_array($sql))
{
	$client=mysqli_query($link,"select * from rl_projects where id='".$sql_data['pid']."'");
	$client_data=mysqli_fetch_array($client);
echo '<li style="list-style-type: disc;">' . $client_data['projectName'].'</li>' ;
}
?></td>
</tr>
<?PHP 
$i=$i+1;
} ?>
        </tbody>
      </table>
    </div>
  </div>
  <?PHP } ?>
  
  <?PHP if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='add') { ?>      
  <section class="panel">
                    	<header class="panel-heading">
                            Assign Projects
                        </header>
                        <div class="panel-body">
                        <div align="center" style="margin-bottom:30px;" class="text-danger"><?PHP echo $message; ?></div>
                <form class="form-horizontal bucket-form login100-form validate-form" method="post" action="assign_projects.php?action=add">
                    	
                        <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">Name</label>
                        <div class="col-lg-6">                        
<select name="cid" id="cid" onChange="getProject('findprojects.php?ab='+this.value)" class="form-control input100" required>
<option value="">--Select--</option>
<?PHP 
$client=mysqli_query($link,"select * from rl_login where userType='Client'");
while($client_data=mysqli_fetch_array($client))
{
?>
<option value="<?PHP echo $client_data['id']; ?>"><?PHP echo $client_data['name']; ?> [<?PHP echo $client_data['email']; ?>]</option>
<?PHP } ?>
</select>
                        </div>
                        </div>
						
						<div id="projectdiv"></div>
                        
                        
                        
                        <div class="form-group">
                        <div class="col-lg-3">&nbsp;</div> 
                        <div class="col-lg-6">                        
                         <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                        </div>

                </form>
            </div>
                    </section>
  <?PHP } ?>
  
  
</div>
</section>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
 <!-- footer -->
<?php include("includes/footer.php"); ?>
 <!-- footer -->
		 
