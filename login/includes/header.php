<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon.png"/>
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="<?PHP echo $website_url; ?>/css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="<?PHP echo $website_url; ?>/css/style.css" rel='stylesheet' type='text/css' />
<link href="<?PHP echo $website_url; ?>/css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="<?PHP echo $website_url; ?>/css/font.css" type="text/css"/>
<link href="<?PHP echo $website_url; ?>/css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="<?PHP echo $website_url; ?>/css/morris.css" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="<?PHP echo $website_url; ?>/css/monthly.css">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="<?PHP echo $website_url; ?>/js/jquery2.0.3.min.js"></script>
<script src="<?PHP echo $website_url; ?>/js/raphael-min.js"></script>
<script src="<?PHP echo $website_url; ?>/js/morris.js"></script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="top-nav-element header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <img src="<?PHP echo $website_url; ?>/images/logo.png" style="width:65%;" />
    <!--<div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>-->
</div>
<!--logo end-->

<?PHP 
$profile=mysqli_query($link,"select * from rl_login where id='" .$_SESSION['UID']. "' and status=1 ");
$profile_data=mysqli_fetch_array($profile);

if($profile_data['imgPath']=="")
	{
		$pimg = '1.png';
	}
else
	{
		$pimg = $profile_data['imgPath'];
	}
?>
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        
        <!-- user login dropdown start-->
        <?php if($_SESSION['loginType'] != $VENDASTA_SSO_LOGIN_TYPE) : ?>
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="<?PHP echo $website_url; ?>/images/userpic/<?PHP echo $pimg; ?>" width="500" >
                    <span class="username"><?PHP echo $_SESSION['name']; ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="profile.php"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="change_password.php"><i class="fa fa-cog"></i> Change Password</a></li>
                    <li><a href="<?PHP echo $website_url; ?>/logout.php"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
        <?php endif; ?>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>