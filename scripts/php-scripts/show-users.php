<?php
include '../../connectionDB.php';
include '../../classes/user-class.php';
User::show_all_users($conn);
?>