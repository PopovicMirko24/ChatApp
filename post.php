<?php

require_once 'scripts/php-scripts/connectionDB.php';
require_once 'classes/user-class.php';
require_once 'classes/post-class.php';
require_once 'classes/search-class.php';
require_once 'classes/comment-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

if(!isset($_GET['post_id'])){
    echo 'greska';
}

$post_id = $_GET['post_id'];
$_SESSION['post_id'] = $post_id;

$user =  User::load_user_data($_SESSION['user_id'], $conn);
$comments_user_img = $user->get_photo_path();

$post = Post::get_post_by_id($conn, $post_id);
$posts_user = User::load_user_data($post->get_user_id(), $conn);
$posts_user_img = $posts_user->get_photo_path();
$posts_user_id = $post->get_post_id();

/*if(array_key_exists('new-comment', $_POST)) {
    $comment = new Comment($post_id, $_SESSION['user_id'], $_POST['comment-conntent']);
    Comment::create_comment($conn, $comment);
}*/

if(array_key_exists('search-input', $_GET) && $_GET['search-input'] !== '') {
    $_SESSION['search_username'] = $_GET['search-input'];
    header('location: search-users.php');
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/comments.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <?php require_once 'nav.php'; ?>
    <section>
        <div class="post">
            <div class="info">
                <?php echo "<div class=\"img-wrapper\" style=\" background-image: url('$posts_user_img'); background-size: cover; background-repeat: no-repeat; background-position: center;\"></div>"?>
                <div class="text-wrapper">
                    <span class="username"><?php echo $posts_user->get_username(); ?></span><br>
                    <span class="date"><?php echo $post->get_date(); ?></span>
                </div>
            </div>
            <div class="conntent">
                <p><?php echo $post->get_conntent() ?></p>
            </div>
        </div>
        <div class="comments post">
            <?php
            
            if(!$user->get_admin()){
                echo '
            <div class="new-comment">
                <form id="form" method="POST">
                    <textarea name="comment-conntent" id="content" cols="30" rows="10" placeholder="text..."></textarea>
                    <input id="comment-btn" name="new-comment" class="button-post" type="submit" value="post" >
                    <input id="post_id_hidden" type="hidden" name="post_id", value="'.$_GET["post_id"].'">
                </form>
            </div>
            ';
            }
            
            ?>
            <?php //Comment::show_comments($conn, $_GET['post_id'], $user); ?>
            <div id="comm"></div>
        </div>
    </section>
    <script src="scripts/js-scripts/ajaxComments.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            comments(<?php echo $_GET['post_id'] ?>);    
        });
    </script>
</body>
</html>