<?php

require_once 'scripts/php-scripts/connectionDB.php';
require_once 'classes/user-class.php';
require_once 'classes/post-class.php';
require_once 'classes/search-class.php';
require_once 'classes/following-class.php';
require_once 'nav.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == null){
    header('location: login.php');
    exit();
}



$user =  User::load_user_data($_SESSION['user_id'], $conn);
$img = $user->get_photo_path();

$_SESSION['user'] = $user;
$_SESSION['profile-img'] = $img;

if($user->get_admin())
    header('location: admin-deashboard.php');

if(array_key_exists('search-input', $_GET) && $_GET['search-input'] !== '') {
    $_SESSION['search_username'] = $_GET['search-input'];
    header('location: search-users.php');
}

if(array_key_exists('delete', $_GET)){
    Post::delete_Post($conn, $_GET['deleteHidden']);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="section">
        <div class="common-div">
            <div class="user">
                <ul class="user-info">
                    <li>
                        <div class="img-wrapper" style="background-image: url('<?php echo $user->get_photo_path() ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div><br>
                        <h3><?php echo $user->get_username() ?></h3>
                    </li>
                    <li>
                        <?php echo $user->get_name() ." " .$user->get_lastname() ?><br>
                    </li>
                    <li>
                        <p class="description"><?php echo $user->get_description() ?></p>
                    </li>
                    <li class="li-edit">
                        <a href="edit-profile.php" class="edit-button">edit profile</a>
                    </li>
                </ul>
            </div><br>
            <div class="following">
                <h3 id="following">following</h3>
                <div class="f" id="f-slider">
                    <?php Following::show_following($conn, $_SESSION['user_id']); ?>
                </div>
            </div>
            <div class="following">
                <h3 id="followers">followers</h3>
                <div class="f" id="f-slider2">
                    <?php Following::show_followers($conn, $_SESSION['user_id']); ?>
                </div>
            </div>
        </div>
        <div class="common-div post-section">
            <div class="new-post">
                <form id="form">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="text..."></textarea>
                    <input id="submit" name="submit" class="button-post button" type="submit" value="post">
                </form>
            </div>
            <div class="posts" id="posts"></div>
        </div>
    </div>
    <script src="scripts/js-scripts/jquery-slider.js"></script>
    <script src="scripts/js-scripts/ajaxPostsProfile.js"></script>
</body>
</html>
