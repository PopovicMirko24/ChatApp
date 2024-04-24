<?php

require_once 'connectionDB.php';

class Post{
    private $post_id;
    private $user_id;
    private $conntent;
    private $photo_path;
    private $created_at;

    /*public function __construct($user_id, $conntent, $created_at){
        $this->user_id = $user_id;
        $this->conntent = $conntent;
        $this->created_at = $created_at;
    }*/

    public function __construct($user_id, $conntent){
        $this->user_id = $user_id;
        $this->conntent = $conntent;
    }

    public function get_user_id(){
        return $this->user_id;
    }

    public function get_conntent(){
        return $this->conntent;
    }

    public function get_date(){
        return $this->created_at;
    }

    public function get_post_id(){
        return $this->post_id;
    }

    public function set_date($date){
        $this->created_at = $date;
    }
    

    private static function get_posts_by_user($conn,$user_id){
        $sql_load_posts = "select * from post where user_id = ? ORDER BY created_at ASC";
        $run = $conn -> prepare($sql_load_posts);
        $run -> bind_param("i", $user_id);
        $run -> execute();
        $results = $run -> get_result();
        return $results;
    }

    public static function get_post_by_id($conn,$post_id){
        $sql_load_posts = "select * from post where post_id = ?";
        $run = $conn -> prepare($sql_load_posts);
        $run -> bind_param("i", $post_id);
        $run -> execute();
        $results = $run -> get_result();
        $results = $results -> fetch_assoc();
        $post = new Post($results['user_id'], $results['content']);
        $post -> set_date($results['created_at']);
        return $post;
    }


    public static function create_post($conn, $post){
        $user_id = $post->get_user_id();
        $conntent = $post->get_conntent();
        $sql_new_post = "insert into post (user_id, content) values (?,?)";
        $run = $conn -> prepare($sql_new_post);
        $run -> bind_param("is", $user_id, $conntent);
        $run -> execute();
        Post::get_posts_by_user($conn,$user_id);
    }

    public static function get_posts($conn, $user_id) {
        $sql = "SELECT * FROM post WHERE user_id = ?";
        $run = $conn->prepare($sql);
        $run->bind_param("i", $user_id);
        $run->execute();
        $result = $run->get_result();
    
        $posts = array();
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }
    
    

    public static function show_posts($conn, $user, $img){
        $posts = array();
        $user_id = $user->get_id();
        $results = Post::get_posts_by_user($conn,$user_id);
        if($results->num_rows > 0){
            while($row = $results->fetch_assoc()) {
                $posts[] = $row;
            }


            for($i = count($posts) - 1; $i >= 0; $i--){
                $post = $posts[$i];
                $post_id = $post['post_id'];
                $location = $_SERVER['PHP_SELF'];
                echo "<div class=\"post\">";
                echo "<div class=\"user-img\">";
                echo "<div class=\"post-img-wrapper\" style=\" background-image: url('$img'); background-size: cover; background-repeat: no-repeat; background-position: center;\">";
                echo "</div>";
                echo "<div class=\"post-name-date\">";
                echo "<span class=\"username-post\">".$user->get_username()."</span><br>";
                echo "<span class=\"date\">".$post['created_at']."</span>";
                echo "</div>";
                echo "</div>";
                echo "<div class=\"post-content\">";
                echo "<p class=\"post-text\">".$post['content']."</p>";
                echo "<form action=\"\" method=\"GET\">";
                echo "<a class=\"comment-link\" href=\"post.php?post_id=$post_id\"> comment </a>";
                if($location == "/socialmedia/profile.php"){
                    echo "<a onClick=\" javascript:return confirm('Are you sure you want to delete this?'); \" class=\"delete-link\" href=\"delete-post.php?post_id=$post_id\"> delte </a>";
                }
                echo "</form>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo '<p class="no-posts">no posts</p>';
        }
    }

    public static function delete_Post($conn, $post_id){
        $sql = "DELETE FROM post WHERE post_id = $post_id";
        $run = $conn->prepare($sql);
        $run->execute();
        return $run->get_result();
    }
}

?>