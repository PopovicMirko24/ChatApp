<?php

session_start();

$server_name = "localhost";
$db_usrname = "root";
$db_password = "";
$db_name = "socialmedia";
$conn = mysqli_connect($server_name, $db_usrname, $db_password, $db_name);

?>