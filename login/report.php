<?php include("includes/common.php"); 
$rid=$_POST['rid'];
if($rid=='')
	{
		header("location: ranking_report.php");
		exit;	
	}

$report=mysqli_query($link,"select * from rl_rankings_report where id=$rid");
$report_data=mysqli_fetch_array($report);
?>

<!DOCTYPE html><head>
<title>Report </title>
<meta name="viewport" content="width=device-width, initial-scale=1">


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
  <div style="padding:20px; text-align:center"><h1 class="text-inverse">Ranking Report &nbsp;<i class="fa fa-signal"></i></h1></div>
    <div class="row w3-res-tb" style="padding: 0 1em;">
    
    
    <div class="panel-heading main_box_n">
      <div class="col-sm-9 m-b-xs" align="left">
      <span style="text-transform:none"><i class="fa fa-user text-inverse"></i> &nbsp;<?PHP echo $report_data['cname']; ?></span><br>
      <span style="text-transform:none"><i class="fa fa-link text-inverse"></i> &nbsp;<?PHP echo $report_data['project_url']; ?></span>
      </div>
      <div class="col-sm-3 main_box_date">
		<span style="text-transform:none"><i class="fa fa-calendar text-inverse"></i> &nbsp;
		<?PHP
		$dd= $report_data['dateadded'];
        $dddd=date_create($dd);
		$tt=substr($report_data['date_Added'],11,11);
        echo date_format($dddd,"d F Y");
        ?>
        </span>
      </div>
    </div>
    </div><br>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light report_table" style="border:2px solid #8b5c7e; width:100%;">
        <thead>
          <tr style="background:#8b5c7e; color:#FFF;">
            <th style="color:#FFF" class="width_30">Keyword</th>
            <th style="color:#FFF" class="width_1">&nbsp;</th>
            <th style="color:#FFF" class="width_58">Landing Page in Google</th>
            <th style="color:#FFF" class="width_1">&nbsp;</th>
            <th style="color:#FFF" class="width_10"><img src="images/google_icon.png" alt=" " style="width:30px; margin-right: 5px;"><img src="images/spacer.png" alt=" " style="width:30px; margin-right: 5px;"></th>
            </tr>
        </thead>
        <tbody>
<?PHP 
$report_detail=mysqli_query($link,"select * from rl_rankings where rid=$rid order by id asc");
while($report_detail_data=mysqli_fetch_array($report_detail))
{
	$icon ='';
	
	$google_rank=$report_detail_data['google_rank'];
	if($google_rank=='0')
		{
			$google_rank='-';	
		}
	
	$previousrank=mysqli_query($link,"select * from rl_rankings where rid='".$_POST['previous_rid']."' and keywords='".$report_detail_data['keywords']."'");
	$previousrank_detail_data=mysqli_fetch_array($previousrank);	
	$previousgoogle=$previousrank_detail_data['google_rank'];
	
	
	if(($google_rank < $previousgoogle) && ($previousgoogle!=0) && ($google_rank!=0))
		{
			$icon="<i class='fa fa-arrow-up text-success'></i>";	
		}
	
	if(($previousgoogle==0) || ($previousgoogle=''))
		{
			if($google_rank>0)
				{	
					$icon="<i class='fa fa-globe text-inverse'></i>";	
				}
		}		
?> 
<tr>
<td><?PHP echo ucwords($report_detail_data['keywords']); ?></td>
<td>&nbsp;</td>
<td><?PHP echo $report_detail_data['google_target_url']; ?></td>
<td>&nbsp;</td>
<td><span style="font-size:19px;"><?PHP echo $google_rank; ?> &nbsp;&nbsp;<?PHP echo $icon; ?></span></td>
</tr>
<?PHP 
//<i class="fa fa-globe text-inverse" title="New Ranking"></i><i class="fa fa-arrow-circle-up text-success" title="Increase"></i>
} ?>
         
          </tbody>
      </table>
      <br>
      <br>
      
      <table class="table table-striped b-t b-light report_table" style="border:2px solid #6586ee; width:100%;">
        <thead>
       
          <tr style="background:#6586ee; color:#FFF;">
            <th style="color:#FFF" class="width_30">Keyword</th>
            <th style="color:#FFF" class="width_1">&nbsp;</th>
            <th style="color:#FFF" class="width_58">Landing Page in Yahoo/Bing</th>
            <th style="color:#FFF" class="width_1">&nbsp;</th>
            <th style="color:#FFF" class="width_10"><img src="images/yahoo_icon.png" alt=" " style="width:30px; margin-right: 5px;"><img src="images/bing_icon.png" alt=" " style="width:30px; margin-right: 5px;"></th>
            </tr>
        </thead>
        <tbody>
<?PHP 
$report_detail=mysqli_query($link,"select * from rl_rankings where rid=$rid order by id asc ");
while($report_detail_data=mysqli_fetch_array($report_detail))
{
	$icon ='';
	
	$bing_rank=$report_detail_data['bing_rank'];
	if($bing_rank=='0')
		{
			$bing_rank='-';	
		}
	
	$previousrank=mysqli_query($link,"select * from rl_rankings where rid='".$_POST['previous_rid']."' and keywords='".$report_detail_data['keywords']."'");
	$previousrank_detail_data=mysqli_fetch_array($previousrank);	
	$previousbing=$previousrank_detail_data['bing_rank'];
	
	
	if(($bing_rank < $previousbing) && ($previousbing!=0) && ($bing_rank!=0))
		{
			$icon="<i class='fa fa-arrow-up text-success'></i>";	
		}
	
	if(($previousbing==0) || ($previousbing=''))
		{
			if($bing_rank>0)
				{	
					$icon="<i class='fa fa-globe text-inverse'></i>";	
				}
		}			
?> 
<tr>
<td><?PHP echo ucwords($report_detail_data['keywords']); ?></td>
<td>&nbsp;</td>
<td><?PHP echo $report_detail_data['bing_target_url']; ?></td>
<td>&nbsp;</td>
<td><span style="font-size:19px;"><?PHP echo $bing_rank; ?> &nbsp;&nbsp;<?PHP echo $icon; ?></span></td>
</tr>
<?PHP } ?>  
          </tbody>
  </table>
    </div>
 <footer class="panel-footer">
      <div class="row">
        <div class="text-left">
<small class="text-muted inline m-t-sm m-b-sm" style="line-height:25px; padding:20px;">
<h3>Legend:</h3><br>
<i class="fa fa-globe text-inverse" title="New Ranking"></i> This icon indicates a first time appearance in the respective search engine results<br>
<i class="fa fa-arrow-circle-up text-success" title="Increase"></i> This icon indicates an increase in the ranking of this keyword since the last report<br>
<br>
<strong>Number:</strong> The numbers in each column refer to that keywords position in each search engine results. A number 5 indicates position 5, a number 14 indicates position 14<br>
<strong>Landing Page Report:</strong> Shows the page on your website that each search engine returns for your keyword.
</small>
        </div>

      </div>
    </footer>   
    
 
  </div>
</div>
</section>

 <!-- footer -->
<?php include("includes/footer.php"); ?>
 <!-- footer -->
		 
