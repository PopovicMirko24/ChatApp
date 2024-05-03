<?php

include '../../connectionDB.php';
include '../../classes/post-class.php';

if(isset($_POST)) { 
    if($_POST['content'] == null || $_POST['content'] == ""){
        echo "<script> alert('Post is empty'); </script>";
    }else{
        $post = new Post($_SESSION['user_id'], $_POST['content']);
        Post::create_post($conn,$post);
    }
}
?>