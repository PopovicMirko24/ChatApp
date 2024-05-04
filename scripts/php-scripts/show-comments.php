<?php

include '../../connectionDB.php';
include '../../classes/comment-class.php';

Comment::show_comments($conn, $_GET['post_id'], $_SESSION['admin']);

?>