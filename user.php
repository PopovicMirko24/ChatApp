<?php

require_once 'connectionDB.php';
require_once 'classes/user-class.php';
require_once 'classes/post-class.php';
require_once 'classes/search-class.php';
require_once 'classes/following-class.php';

if(array_key_exists('search-input', $_GET) && $_GET['search-input'] !== '') {
    $_SESSION['search_username'] = $_GET['search-input'];
    header('location: search-users.php');
}

$user_nav = User::load_user_data($_SESSION['user_id'], $conn);

if(isset($_GET['username'])) {
    if($_GET['username'] != $user_nav->get_username()){
        $username = $_GET['username'];
        $username = str_replace("'", "", $username);
        $user = User::load_user_data_by_username($username, $conn);
        $img = $user->get_photo_path();
    }else{
        header('location: profile.php');
    }
}



if(array_key_exists('comment', $_GET)) {
    $_SESSION['post_id'] = $_GET['post_id'];
    header('location: post.php');
}

$following = Following::Is_following($conn, $_SESSION['user_id'], $user->get_id());

if(array_key_exists('follow', $_POST)){
    if($following)
        Following::unfollow($conn, $_SESSION['user_id'], $user->get_id());
    else
        Following::follow($conn, $_SESSION['user_id'], $user->get_id());

    header('location: user.php?username='. $user->get_username());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/post.css">
    <script>
        function updateFollowButton() {
            const btn = document.getElementById("btn-follow");
            <?php
                if($following) {
                    echo 'btn.value = "following";';
                } else {
                    echo 'btn.value = "follow";';
                }
            ?>
        }
        window.onload = updateFollowButton;
    </script>
</head>
<body>
    <div class="nav">
        <span class="logo"><a href="home.php">social media</a></span>
        <ul class="nav-links">
            <li class="center"><a href="profile.php"><?php echo $user_nav->get_username() ?></a></li>
            <li class="center"><a href="login.php">logout</a></li>
            <li>
                <form action="" method="GET">
                    <input class="text-input" type="text" name="search-input" id="search" placeholder="search">
                    <input type="submit" class="button" value="search" name="search">
                </form>
            </li>
        </ul>
    </div>
    <section class="user-info">
        <div class="container">
            <ul class="info-list">
                <li>
                    <div class="img-wrapper">
                        <img class="profile-img" src="<?php echo $user->get_photo_path(); ?>" alt="">
                    </div>
                </li>
                <li class="info">
                    <div class="name">
                        <h3 class="username"><?php echo $user->get_username(); ?></h3>
                        <span><?php echo $user->get_name(); ?></span>
                        <span><?php echo $user->get_lastname(); ?></span>
                    </div>
                    <div class="description">
                        <span><?php echo $user->get_description() ?></span>
                    </div>
                </li>
                <?php
                    if($_SESSION['user_id'] != $user->get_id())
                        echo '

                        <div class="follow">
                            <form action="" method="POST">
                                <input name="follow" id="btn-follow" class="btn-follow" type="submit" value="">
                            </form>
                        </div>

                        ';
                ?>
        </div>
        </ul>
    </section>
    <section class="posts">
        <div class="container-posts">
            <div class="all-posts">
                <?php
                    Post::show_posts($conn, $user, $img);
                ?>
            </div>
        </div>
    </section>
</body>
</html>