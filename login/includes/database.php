<?php

$host = 'localhost';
$user = 'theseore_myusr32';
$password = 'QEV3}ybRWN~b';
$database = 'theseore_reportsl_projects';

// $host = '127.0.0.1';
// $user = 'root';
// $password = '123';
// $database = 'app';

$link = mysqli_connect(
    $host,
    $user,
    $password,
    $database,
);

if (is_null($link) || $link === false || $link->connect_error) {
    die("Connection failed: '{$link->connect_error}'");
}