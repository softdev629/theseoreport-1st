<?php

$host = 'localhost';
$user = 'theseore_myusr32';
$password = 'QEV3}ybRWN~b';
$database = 'theseore_reportsl_projects';

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: {$connection->connect_error}");
}

$link = mysqli_connect($host, $user, $password, $database) or die('server not connected');