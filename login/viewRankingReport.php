<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/database.php';

$base_url = 'https://' . $_SERVER['HTTP_HOST'];
$website_url = "$base_url/login";

$script_url = $base_url . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$oauth_client_id = 'bd0b1564-2378-447c-875c-c14e7f6fad09';
$oauth_client_secret = 'OPgyUulOMAhE53jWKG8f5UcB2fULKl3yl8LzkOqb18';
$authorization_url = 'https://sso-api-prod.apigateway.co/oauth2/auth';
$oauth_access_token_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/token';
$oauth_resource_owner_details_endpoint_url = 'https://sso-api-prod.apigateway.co/oauth2/user-info';

if (array_key_exists('access-token', $_COOKIE) && $_COOKIE['access-token'] != '') {
    
    $access_token_cookie = json_decode($_COOKIE['access-token']);

    if (!is_object($access_token_cookie)
        || !property_exists($access_token_cookie, 'value')
        || !property_exists($access_token_cookie, 'expiry')
        || !property_exists($access_token_cookie, 'account_id')) {
        echo 'something-went-wrong:malformed-cookie';
        exit;
    }

    if (time() > $access_token_cookie->expiry) {

        setcookie('access-token', '');

        $refresh_url = "$script_url?account_id={$access_token_cookie->account_id}";

        header('Location: ' . $refresh_url);

        exit;

    }

    $client = new \GuzzleHttp\Client();

    $response = $client->get($oauth_resource_owner_details_endpoint_url, ['headers' => [
        'Authorization' => "Bearer {$access_token_cookie->value}",
    ]]);
    
    $data = json_decode($response->getBody());

    $data_from_token_id = json_decode(base64_decode(explode('.', $access_token_cookie->value)[1]));

    if ($data_from_token_id->sub != $data->sub) {
        echo 'something-went-wrong:sub-do-not-match';
        exit;
    }

    if (is_null($data)
        || !is_object($data)
        || !property_exists($data, 'name')
        || !property_exists($data, 'created_at')) {
        echo 'something-went-wrong';
        exit;
    }

    $identifier_hash = md5($data->name . $data->created_at);

    $client_select_result = $connection->query("select * from rl_login where email = '$identifier_hash'");

    if (!($client_select_result instanceof mysqli_result)) {
        echo 'something-went-wrong';
        exit;
    }

    $client_rows = $client_select_result->fetch_all(MYSQLI_ASSOC);

    if (count($client_rows) == 0) {
        echo 'something-went-wrong:client-not-registered';
        exit;
    }

    $client_row = $client_rows[0];

    $_SESSION['username'] = $client_row['email'];
    $_SESSION['UID'] = $client_row['id'];
    $_SESSION['name'] = $client_row['name'];
    $_SESSION['usertype'] = $client_row['userType'];
    $_SESSION['loginType'] = 'sso';

}

else if (array_key_exists('code', $_GET)) {
    
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'urlResourceOwnerDetails' => $oauth_resource_owner_details_endpoint_url,
        'urlAccessToken' => $oauth_access_token_endpoint_url,
        'urlAuthorize' => $authorization_url,
        'clientSecret' => $oauth_client_secret,
        'clientId' => $oauth_client_id,
        'redirectUri' => $script_url,
    ]);

    try {

        $access_token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code'],
        ]);

        setcookie('access-token', json_encode([
            'value' => $access_token->__toString(),
            'expiry' => $access_token->getExpires(),
            'account_id' => $_GET['state'],
        ]), $access_token->getExpires(), '', $_SERVER['HTTP_HOST'], true, true);

        $client = new \GuzzleHttp\Client();

        $response = $client->get($oauth_resource_owner_details_endpoint_url, ['headers' => [
            'Authorization' => "Bearer $access_token",
        ]]);
        
        $data = json_decode($response->getBody());

        $data_from_token_id = json_decode(base64_decode(explode('.', $access_token)[1]));
    
        if ($data_from_token_id->sub != $data->sub) {
            echo 'something-went-wrong:sub-do-not-match';
            exit;
        }

        if (is_null($data)
            || !is_object($data)
            || !property_exists($data, 'name')
            || !property_exists($data, 'created_at')) {
            echo 'something-went-wrong';
            exit;
        }

        $identifier_hash = md5($data->name . $data->created_at);

        $client_select_result = $connection->query("select * from rl_login where email = '$identifier_hash'");

        if (!($client_select_result instanceof mysqli_result)) {
            echo 'something-went-wrong';
            exit;
        }
        
        $client_rows = $client_select_result->fetch_all(MYSQLI_ASSOC);

        if (count($client_rows) == 0) {
        
            $admin_select_result = $connection->query("select * from rl_login where userType = 'Administrator'");

            if (!($admin_select_result instanceof mysqli_result)) {
                echo 'something-went-wrong';
                exit;
            }

            $admin_rows = $admin_select_result->fetch_all(MYSQLI_ASSOC);

            if (count($admin_rows) == 0) {
                echo 'no-admins-found';
                exit;
            }

            $admin_id = $admin_rows[0]['id'];
            
            $dateAdded = date('Y-m-d H:i:s');

            $insert_result = $connection->query("
                insert into rl_login (userType, email, name, dateAdded, createdBy, sso, zip, status, imgPath)
                values ('Client', '$identifier_hash', '{$data->name}', '$dateAdded', $admin_id, 1, '', 1, '')
            ");

            if ($insert_result !== true) {
                echo 'something-went-wrong';
                exit;
            }
            
        }

        $client_select_result = $connection->query("select * from rl_login where email = '$identifier_hash'");

        if (!($client_select_result instanceof mysqli_result)) {
            echo 'something-went-wrong';
            exit;
        }

        $client_row = $client_select_result->fetch_all(MYSQLI_ASSOC)[0];

        $_SESSION['username'] = $client_row['email'];
        $_SESSION['UID'] = $client_row['id'];
        $_SESSION['name'] = $client_row['name'];
        $_SESSION['usertype'] = $client_row['userType'];
        $_SESSION['loginType'] = 'sso';

    }
    
    catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        echo 'something-went-wrong';
        exit;
    }

}

else if (array_key_exists('account_id', $_GET)) {
    
    $account_id = $_GET['account_id'];
    
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'urlResourceOwnerDetails' => $oauth_resource_owner_details_endpoint_url,
        'urlAuthorize' => "$authorization_url?account_id=$account_id",
        'urlAccessToken' => $oauth_access_token_endpoint_url,
        'clientSecret' => $oauth_client_secret,
        'clientId' => $oauth_client_id,
        'redirectUri' => $script_url,
    ]);

    if (!array_key_exists('code', $_GET)) {
        
        $authorizationUrl = $provider->getAuthorizationUrl([
            'state' => $account_id,
            'scope' => ['profile'],
        ]);
        
        header('Location: ' . $authorizationUrl);
    
        exit;
    
    }

}

else {
    include 'includes/common.php';
    include 'includes/check_session.php';
}
    
if ($_SESSION['usertype'] != 'Client') {
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