<?php

require_once 'connectionDB.php';
require_once 'user-class.php';
require_once 'search-class.php';

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
    <link rel="stylesheet" href="css/nav.css">
</head>
<body>
    <div class="nav">
        <span class="logo"><a href="home.php">social media</a></span>
        <ul class="nav-links">
            <li class="center"><a href="profile.php"><?php echo $user->get_username() ?></a></li>
            <li class="center"><a href="login.php">logout</a></li>
            <li>
                <form action="" method="GET">
                    <input class="text-input" type="text" name="search-input" id="search" placeholder="search">
                    <input type="submit" class="button" value="search" name="search">
                </form>
            </li>
        </ul>
    </div>
    <section class="profiles">
        <?php Search::search_users($conn, $_SESSION['search_username']); ?>
    </section>
</body>
</html>