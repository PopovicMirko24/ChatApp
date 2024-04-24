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
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
    <?php require_once 'nav.php'; ?>
    <div class="section">
        <div class="common-div">
            <div class="user">
                <ul class="user-info">
                    <li>
                        <div class="img-wrapper" style=" background-image: url(' <?php echo $img ?> '); background-size: cover; background-repeat: no-repeat; background-position: center;"></div><br>
                        <h3><?php echo $user->get_username() ?></h3>
                    </li>
                    <li>
                        <?php echo $user->get_name() ." " .$user->get_lastname() ?><br>
                    </li>
                    <li>
                        <p class="description"><?php echo $user->get_description() ?></p>
                    </li>
                    <li class="li-edit">
                    <?php
                    if($_SESSION['user_id'] != $user->get_id())
                        echo '

                        <div class="follow">
                            <form action="" method="POST">
                                <input name="follow" id="btn-follow" class="follow-button" type="submit" value="">
                            </form>
                        </div>

                        ';
                ?>
                    </li>
                </ul>
            </div><br>
            <div class="following">
                <h3>following</h3>
                <?php Following::show_following($conn, $user->get_id()); ?>
            </div>
            <div class="following">
                <h3>followers</h3>
                <?php Following::show_followers($conn, $user->get_id()); ?>
            </div>
        </div>

    <div class="common-div post-section">
        <?php Post::show_posts($conn, $user, $img); ?>
    </div>
    </div>
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
</body>
</html>