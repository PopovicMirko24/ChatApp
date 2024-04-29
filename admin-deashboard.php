<?php

require_once 'connectionDB.php';
require_once 'classes/user-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
} 

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $user = $search_class->searchUsers($search);
}

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
    <div class="users">
        <table>
            <?php User::show_all_users($conn); ?>
        </table>
    </div>
    <form method="GET">
        <input type="text" name="username" id="" placeholder="search...">
        <input type="submit" value="search">
    </form>
</body>
</html>