<?PHP
ob_start();
@session_start();
error_reporting(0);
$website_url= "https://".$_SERVER["SERVER_NAME"]."/login";
//$website_url= "http://127.0.0.1/ReportsLocker";

$link = mysqli_connect("localhost","theseore_myusr32","QEV3}ybRWN~b") or die("server not connected");
mysqli_select_db($link,"theseore_reportsl_projects") or die("database not connected");



$date=date("Y-m-d");
$offset=5*60*60+1800;
$dateFormat="Y-m-d H:i:s";
$today=gmdate($dateFormat, time()+$offset);
$message='';



?>