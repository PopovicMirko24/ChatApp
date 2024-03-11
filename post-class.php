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
                $posts[] = $row; // Append each fetched row to the $posts array
            }


            for($i = count($posts) - 1; $i >= 0; $i--){
                $post = $posts[$i];
                $post_id = $post['post_id'];
                echo "
            <div class=\"post\">
                <div class=\"user-img\">
                    <div class=\"post-img-wrapper\">
                        <img src=\"$img\" class=\"profile-img-post\">
                    </div>
                    <div class=\"post-name-date\">
                        <span class=\"username-post\">".$user->get_username()."</span><br>
                        <span class=\"date\">".$post['created_at']."</span>
                    </div>
                </div>
                <div class=\"post-content\">
                    <p class=\"post-text\">".$post['content']."</p>
                    <form action=\"\" method=\"GET\">
                        <input type=\"hidden\" name=\"post_id\" value=\"$post_id\">
                        <input class=\"comment-button\" name=\"comment\" type=\"submit\" value=\"comment\">
                    </form>
                </div>
            </div>
            ";
            }
        } else {
            echo '<p class="no-posts">no posts</p>';
        }
    }
}

?>