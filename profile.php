<?php

require_once 'connectionDB.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql_user = 'select * from user where user_id = ?';
$run = $conn ->prepare($sql_user);
$run -> bind_param("i", $user_id);
$run -> execute();
$results = $run -> get_result();
$user = $results -> fetch_assoc();

$img = "images\common_immage.webp";
$description = "no description";
if($user['photo_path'] != null){
    $img = $user['photo_path'];
}

if($user['description']!=null){
    $description = $user['description'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="nav">
        <span class="logo">social media</span>
        <ul class="nav-links">
            <li class="center"><a href="#"><?php echo $user['username'] ?></a></li>
            <li class="center"><a href="login.php">logout</a></li>
            <li>
                <form action="GET">
                    <input class="text-input" type="text" name="search" id="search" placeholder="search">
                    <input type="submit" class="button" value="search">
                </form>
            </li>
        </ul>
    </div>
    <section class="user-info">
        <div class="container">
            <ul class="info-list">
                <li>
                    <div class="img-wrapper">
                        <img class="profile-img" src="<?php echo $img; ?>" alt="">
                    </div>
                </li>
                <li class="info">
                    <div class="name">
                        <h3 class="username"><?php echo $user['username']; ?></h3>
                        <span><?php echo $user['name']; ?></span>
                        <span><?php echo $user['last_name']; ?></span>
                    </div>
                    <div class="description">
                        <span><?php echo $description ?></span>
                    </div>
                </li>
                <li>
                    <div class="edit">
                        <a href="#" class="edit-button">edit profile</a>
                    </div>
                </li>
        </div>
        </ul>
    </section>
    <section class="posts">
        <div class="container-posts">
            <div class="new-post">
                <form action="profile.php" method="get">
                    <textarea class="textarea" name="content" id="content" cols="30" rows="10" placeholder="text..."></textarea>
                    <input type="submit" value="post" class="button-post">
                </form>
            </div>
            <div class="show-posts"></div>
        </div>
    </section>
</body>
</html>