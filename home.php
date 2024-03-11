<?php

require_once 'connectionDB.php';
require_once 'user-class.php';
require_once 'post-class.php';
require_once 'search-class.php';
require_once 'following-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

$user =  User::load_user_data($_SESSION['user_id'], $conn);
$users_img = $user->get_photo_path();


if(array_key_exists('search-input', $_GET) && $_GET['search-input'] !== '') {
    $_SESSION['search_username'] = $_GET['search-input'];
    header('location: search-users.php');
}

if(array_key_exists('comment', $_GET)) {
    $_SESSION['post_id'] = $_GET['post_id'];
    header('location: post.php');
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/profile.css">
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
    <div class="section" style="padding-top: 100px;">
        <?php
            if(Following::get_all_followings($conn, $user->get_id())){
                $followings = Following::get_all_followings($conn, $user->get_id());
                $all_posts = array(); // Initialize an array to store all posts
            
                // Fetch posts from each followed user and store them in the $all_posts array
                foreach($followings as $following_user_id){
                    $follower = User::load_user_data($following_user_id, $conn);
                    $posts = Post::get_posts($conn, $following_user_id); // Assuming you have a method to fetch posts by user ID
                    foreach($posts as $post){
                        $all_posts[] = $post; // Append each post to the $all_posts array
                    }
                }
            
                // Sort the posts by their timestamp in descending order
                usort($all_posts, function($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
            
                // Display the sorted posts
                foreach($all_posts as $post){
                    $user = User::load_user_data($post['user_id'], $conn);
                    $user_img = $user->get_photo_path();
                    // Output HTML for displaying a single post
                    $post_id = $post['post_id'];
                    echo "
            <div class=\"post\">
                <div class=\"user-img\">
                    <div class=\"post-img-wrapper\">
                        <img src=\"$user_img\" class=\"profile-img-post\">
                    </div>
                    <div class=\"post-name-date\">
                        <span class=\"username-post\">".$user->get_username()."</span><br>
                        <span class=\"date\">".$post['created_at']."</span>
                    </div>
                </div>
                <div class=\"post-content\">
                    <p class=\"post-text\">".$post['content']."</p>
                    <form action=\"\" method=\"GET\">
                        <input type=\"hidden\" name=\"post_id\" value=\"$post_id\">
                        <input class=\"comment-button\" name=\"comment\" type=\"submit\" value=\"comment\">
                    </form>
                </div>
            </div>
            ";
                }
            }
        ?>
    </div>
</body>
</html>