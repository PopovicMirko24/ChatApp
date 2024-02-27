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

$sql_load_posts = "select * from post where user_id = ? ORDER BY created_at ASC";
$run = $conn -> prepare($sql_load_posts);
$run -> bind_param("i", $user_id);
$run -> execute();
$results = $run -> get_result();
$posts = array();


if(array_key_exists('button-post', $_POST)) { 
    if($_POST['content'] == null || $_POST['content'] == ""){
        echo "<script> alert('Post is empty'); </script>";
    }else{
        $sql_new_post = "insert into post (user_id, content, likes) values (?,?,0)";
        $run = $conn -> prepare($sql_new_post);
        $run -> bind_param("is", $user_id, $_POST['content']);
        $run -> execute();

        $sql_load_posts = "select * from post where user_id = ? ORDER BY created_at ASC";
        $run = $conn -> prepare($sql_load_posts);
        $run -> bind_param("i", $user_id);
        $run -> execute();
        $results = $run -> get_result();
        $posts = array();
    }
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
                <form action="profile.php" method="POST" class="post-form">
                    <textarea class="textarea" name="content" id="content" cols="30" rows="10" placeholder="text..."></textarea>
                    <input name="button-post" type="submit" value="post" class="button button-post">
                </form>
            </div>
            <div class="all-posts">
                <?php
                
                if($results->num_rows > 0){
                    while($row = $results->fetch_assoc()) {
                        $posts[] = $row; // Append each fetched row to the $posts array
                    }


                    for($i = count($posts) - 1; $i >= 0; $i--){
                        $post = $posts[$i];
                        echo "
                    <div class=\"post\">
                        <div class=\"user-img\">
                            <div class=\"post-img-wrapper\">
                                <img src=\"$img\" class=\"profile-img-post\">
                            </div>
                            <div class=\"post-name-date\">
                                <span class=\"username-post\">".$user['username']."</span><br>
                                <span class=\"date\">".$post['created_at']."</span>
                            </div>
                        </div>
                        <div class=\"post-content\">
                            <p class=\"post-text\">".$post['content']."</p>
                            <button class=\"like-putton button\">like</button>
                            <span class=\"like-count\">".$post['likes']."</span>
                        </div>
                    </div>
                    ";
                    }
                } else {
                    echo '<p class="no-posts">no posts</p>';
                }
                

                ?>
            </div>
        </div>
    </section>
</body>
</html>