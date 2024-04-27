<?php

require_once 'connectionDB.php';
require_once 'classes/user-class.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="admin-data">
    </div>
    <div class="users">
        <table border="1">
            <?php User::show_all_users($conn); ?>
        </table>
    </div>
</body>
</html>