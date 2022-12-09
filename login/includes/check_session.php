<?php

if (!is_array($_SESSION) || $_SESSION['username'] == '')
{
	header('Location: index.php');
    exit;
}

$chkstatus = mysqli_query($link,"select * from rl_login where id='" .$_SESSION['UID']. "'");
$chkstatus_data = mysqli_fetch_array($chkstatus);

?>