<?php

include '../../connectionDB.php';
include '../../classes/comment-class.php';

if(isset($_POST)) {
    $comment = new Comment($_POST['post_id'], $_SESSION['user_id'], $_POST['comment-conntent']); // Correct the typo in 'commentData'
    $res = Comment::create_comment($conn, $comment);
    var_dump($res);
}

?>