<?php

require_once 'connectionDB.php';
require_once 'classes/post-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!$_GET['post_id']){
    header('location: profile.php');
    exit();
}

$result = Post::delete_Post($conn, $_GET["post_id"]);
if($_SESSION['admin']==false){
    header('location: profile.php');
}else{
    header('location: user.php?username='.$_SESSION['username']);
}

?>