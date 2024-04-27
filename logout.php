<?php

$_SESSION['user_id'] = null;
session_destroy();
header('location: login.php');

?>