<?php
require_once 'connectionDB.php';
require_once 'classes/user-class.php';
User::show_all_users($conn);
?>