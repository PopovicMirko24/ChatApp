<?php

require_once 'connectionDB.php';
require_once 'classes/user-class.php';
require_once 'classes/post-class.php';
require_once 'classes/search-class.php';
require_once 'classes/following-class.php';

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/posts.css">
</head>
<body>
    <?php require_once 'nav.php'; ?>
    <div class="following-s section">
        <div class="following">
            <h3>following</h3>
            <div class="f">
                <?php Following::show_following($conn, $_SESSION['user_id']); ?>
            </div>
        </div>
    </div>
    <div class="section posts" style="padding-top: 100px;">
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
                
                if(count($all_posts)==0 || $posts==null){
                    echo '<div class="no-post"><p class="no-posts">no posts</p></div>';
                }else{
                    usort($all_posts, function($a, $b) {
                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                    });
                
                    // Display the sorted posts
                    foreach($all_posts as $post){
                        $user = User::load_user_data($post['user_id'], $conn);
                        $user_img = $user->get_photo_path();
                        $username = $user->get_username();
                        // Output HTML for displaying a single post
                        $post_id = $post['post_id'];
                        echo "
                <div class=\"post\">
                    <a href=\"user.php?username=$username\" class=\"link\">
                    <div class=\"user-img\">
                        <div class=\"post-img-wrapper\" style=\" background-image: url('".$user_img."'); background-size: cover; background-repeat: no-repeat; background-position: center;\">
                        </div>
                        <div class=\"post-name-date\">
                            <span class=\"username-post link-username\">".$user->get_username()."</span><br>
                            <span class=\"date\">".$post['created_at']."</span>
                        </div>
                    </div>
                    </a>
                    <div class=\"post-content\">
                        <p class=\"post-text\">".$post['content']."</p>
                        <form action=\"\" method=\"GET\">
                            <a class=\"comment-link\" href=\"post.php?post_id=$post_id\"> comment </a>
                        </form>
                    </div>
                </div>
                ";
                    }
                }
                }
        ?>
    </div>
</body>
</html>