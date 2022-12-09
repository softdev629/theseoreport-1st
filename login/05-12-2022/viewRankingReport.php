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
<title>Ranking Report </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/main.css">

<script>
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
					if (req.status == 200) {						
						document.getElementById('projectdiv').innerHTML=req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
function getProjectDate(strURL) {		
		var req = getXMLHTTP();
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					if (req.status == 200) {						
						document.getElementById('projectdatediv').innerHTML=req.responseText;
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
          
  <div class="panel panel-default">
    <div class="panel-heading">Ranking Reports</div>
<?PHP 
if($_SESSION['usertype']=='Client')
{
?>
     <form name="search1" method="get" >
     
     
    <div class="row w3-res-tb" style="margin-left:5px; min-height:400px;" > 
        
    	<div id="projectdiv" style="float:left;margin-bottom:20px;">
<select class="input-sm form-control w-sm inline v-middle" name="pid" style="width:215px;" onchange="getProjectDate('findreport3.php?pid='+this.value)">
<option value=''> &nbsp; &nbsp; &nbsp; - - &nbsp; Select Project Name &nbsp; - - </option>
<?PHP 
$cli=mysqli_query($link,"select * from rl_projects where cid='".$_SESSION['UID']."'  order by projectName ASC");
while($cli_data=mysqli_fetch_array($cli))
{
?>
<option value="<?PHP echo $cli_data['id']; ?>"><?PHP echo $cli_data['projectName']; ?> </option>
<?PHP } ?>

<?PHP 
$sql=mysqli_query($link,"select * from rl_projects_assign where cid='".$_SESSION['UID']."'");
while($sql_data=mysqli_fetch_array($sql))
{
$cli=mysqli_query($link,"select * from rl_projects where id='".$sql_data['pid']."'");
$cli_data=mysqli_fetch_array($cli);
?>
<option value="<?PHP echo $cli_data['id']; ?>"><?PHP echo $cli_data['projectName']; ?> </option>
<?PHP } ?>
</select>  

        </div> 
        
        <div class="clearfix"></div>
        
        <div id="projectdatediv"  style="margin-bottom:20px;"></div>
    	
        </div>
    
     </form> 
<?PHP } ?>
     
    
    <div class="table-responsive">


<div align="center" style="margin:15px;" class="text-success"><?PHP echo $message; ?></div>
      
    </div>
    <!--<footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>-->
  </div>  
  
</div>
</section>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
 <!-- footer -->
<?php include("includes/footer.php"); ?>
 <!-- footer -->