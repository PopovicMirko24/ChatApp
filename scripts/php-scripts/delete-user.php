<?php 
require_once 'connectionDB.php';

if(!isset($_GET['user_id']))
    header('location: admin-deashboard.php');

$sql_user = "DELETE FROM user WHERE user_id = ".$_GET['user_id'];
$sql_posts = "DELETE FROM post WHERE user_id = ".$_GET['user_id'];
$sql_comments = "DELETE FROM comment WHERE user_id = ".$_GET['user_id'];
$sql_follower = "DELETE FROM following WHERE user1_id = ".$_GET['user_id'];
$sql_following = "DELETE FROM following WHERE user2_id = ".$_GET['user_id'];

$run = $conn->prepare($sql_user);
$run->execute();
$run = $conn->prepare($sql_posts);
$run->execute();
$run = $conn->prepare($sql_comments);
$run->execute();
$run = $conn->prepare($sql_follower);
$run->execute();
$run = $conn->prepare($sql_following);
$run->execute();
header('location: admin-deashboard.php');
?>