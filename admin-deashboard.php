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
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-data">
    </div>
    <div class="users">
        <table>
            <?php User::show_all_users($conn); ?>
        </table>
    </div>
</body>
</html>