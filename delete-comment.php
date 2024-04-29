<?php

require_once 'connectionDB.php';
require_once 'classes/comment-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!$_GET['comment_id']){
    header('location: profile.php');
    exit();
}

$result = Comment::delete_comment($conn, $_GET["comment_id"]);
if(!$result){
    echo "<script>alert('Error');</script>";
    header('Location: post.php?post_id'.$_SESSION['post_id']);
}

?>