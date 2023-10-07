<?php

$servername = 'localhost';
$usernname = 'root';
$password = '';
$db = 'db_lab';

$conn = mysqli_connect($servername, $usernname, $password, $db);

if (!$conn) {
    die('Connection Failed' . mysqli_connect_error());
}
