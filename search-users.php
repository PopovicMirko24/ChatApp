<?php

require_once 'connectionDB.php';
require_once 'classes/user-class.php';
require_once 'classes/search-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}


if(array_key_exists('search-input', $_GET) && $_GET['search-input'] !== '') {
    $_SESSION['search_username'] = $_GET['search-input'];
    header('location: search-users.php');
} 


$user = User::load_user_data($_SESSION['user_id'], $conn);
$name = $user->get_name() ." " .$user->get_lastname();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
    <link rel="stylesheet" href="css/search.css">
</head>
<body>
    <?php require_once 'nav.php'; ?>
    <section class="profiles">
        <?php Search::search_users($conn, $_SESSION['search_username']); ?>
    </section>
</body>
</html>