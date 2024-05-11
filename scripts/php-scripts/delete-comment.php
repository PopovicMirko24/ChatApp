<?php

require_once 'connectionDB.php';
require_once '../../classes/comment-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

$result = Comment::delete_comment($conn, $_GET["comment_id"]);
?>