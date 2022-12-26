
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="<?PHP echo $website_url; ?>/js/bootstrap.js"></script>
<script src="<?PHP echo $website_url; ?>/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?PHP echo $website_url; ?>/js/scripts.js"></script>
<script src="<?PHP echo $website_url; ?>/js/jquery.slimscroll.js"></script>
<script src="<?PHP echo $website_url; ?>/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?PHP echo $website_url; ?>/js/jquery.scrollTo.js"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				
<?PHP 
$i = 12;
while ($i >= 0) {
$ym = date('Y-m', strtotime("-$i month"));
$yms [$ym] = $ym;
$graph_client=mysqli_query($link,"SELECT * FROM rl_login WHERE userType = 'Client' AND dateAdded LIKE '%".$ym."%'");
$graph_client_numee=mysqli_num_rows($graph_client);

$graph_report=mysqli_query($link,"SELECT * FROM rl_report WHERE dateAdded LIKE '%".$ym."%'");
$graph_report_numee=mysqli_num_rows($graph_report);

$graph_report_unique=mysqli_query($link,"SELECT DISTINCT pid FROM rl_report WHERE dateAdded LIKE '%".$ym."%'");
$graph_report_unique_numee=mysqli_num_rows($graph_report_unique);
?>
			{period: '<?PHP echo $ym; ?>', iphone: <?PHP echo $graph_client_numee; ?>, ipad: <?PHP echo $graph_report_numee; ?>, itouch: <?PHP echo $graph_report_unique_numee; ?>},
<?PHP 
$i--;
}
?>
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['Total Clients', 'Reports Generated', 'Unique Reports'],
			pointSize: 3,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="<?PHP echo $website_url; ?>/js/monthly.js"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
<?php if ($VENDASTA_DATA_URL != ''): ?>

<script src="https://www.cdnstyles.com/static/product_navbar/v1/product_navbar.js"
    data-url="<?= $VENDASTA_DATA_URL ?>"
    data-account-id="<?= $ACCOUNT_ID ?>"
    data-app-id="<?= $PRODUCT_ID ?>"
    target-element-class="top-nav-element">
</script>

<?php endif; ?>
</html>