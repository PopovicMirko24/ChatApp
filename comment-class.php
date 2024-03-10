<?php

require_once 'connectionDB.php';

class Comment{
    private $post_id;
    private $user_id;
    private $conntent;
    private $photo_path;
    private $created_at;
    private $comment_id;

    public function __construct($post_id, $user_id, $conntent) {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->conntent = $conntent;
    }

    public function get_post_id(){
        return $this->post_id;
    }

    public function get_user_id(){
        return $this->user_id;  
    }

    public function get_conntent(){
        return $this->conntent;
    }

    public static function create_comment($conn, $comment){
        $post_id = $comment->post_id;
        $content = $comment->get_conntent();
        $user_id = $comment->get_user_id();

        $sql = 'insert into comment (post_id, user_id, conntent) values (?,?,?)';
        $run = $conn->prepare($sql);
        $run->bind_param('iis', $post_id, $user_id, $content);
        $run->execute();
        Comment::load_comment_data($conn, $post_id);
    }

    private static function load_comment_data($conn, $post_id){
        $sql = 'SELECT * FROM comment INNER JOIN user ON comment.user_id = user.user_id WHERE post_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param('i', $post_id);
        $run->execute();
        $results = $run->get_result();
        return $results;
    }
    
    

    public static function show_comments($conn, $post_id){
        $comments = array();
        $data = Comment::load_comment_data($conn, $post_id);
        if($data->num_rows > 0){
            while($row = $data->fetch_assoc()) {
                $comments[] = $row; // Append each fetched row to the $posts array
            }


            for($i = count($comments) - 1; $i >= 0; $i--){
                $comment = $comments[$i];
                $post_id = $comment['post_id'];
                $username = $comment['username'];
                $date = $comment['created_at'];
                $conntent = $comment['conntent'];
                $img = 'images\common_immage.webp';
                if($comment['photo_path']){
                    $img = $comment['photo_path'];
                }

                echo "
            <div class=\"comment\">
                <div class=\"info-comment\">
                    <div class=\"img-wrapper\">
                        <img src=\"$img\" class=\"profile-img-conntent\">
                    </div>
                    <div class=\"info-text\">
                        <span class=\"username-comment\">".$username."</span><br>
                        <span class=\"date-comment\">".$date."</span>
                    </div>
                </div>
                <div class=\"comment-content\">
                    <p class=\"comment-text\">".$conntent."</p>
                </div>
            </div>
            ";
            }
        } else {
            echo '<p class="no-comments">no comments</p>';
        }
    }
}

?>