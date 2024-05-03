<?php
include '../../connectionDB.php';
include '../../classes/user-class.php';
include '../../classes/post-class.php';

if(!isset($_SESSION['user'])){
    echo 'greska </br>';
}

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

$user = User::load_user_data($_SESSION['user_id'], $conn);
Post::show_posts($conn, $user, $user->get_photo_path(), $_SESSION['admin']);

?>