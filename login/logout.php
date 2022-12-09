<?php

if (array_key_exists('access-token', $_COOKIE) && $_COOKIE['access-token'] != '') {
    setcookie('access-token', '');
}

else {
    session_start();
    session_destroy();
}

header('Location: index.php');

?>