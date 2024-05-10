<?php


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
        $post_id = $comment->get_post_id();
        $content = $comment->get_conntent();
        $user_id = $comment->get_user_id();

        $sql = 'insert into comment (post_id, user_id, conntent) values (?,?,?)';
        $run = $conn->prepare($sql);
        $run->bind_param('iis', $post_id, $user_id, $content);
        $run->execute();
        return $post_id." ".$content." ".$user_id;
    }

    private static function load_comment_data($conn, $post_id){
        $sql = 'SELECT * FROM comment INNER JOIN user ON comment.user_id = user.user_id WHERE post_id = ?';
        $run = $conn->prepare($sql);
        $run->bind_param('i', $post_id);
        $run->execute();
        $results = $run->get_result();
        return $results;
    }
    
    

    public static function show_comments($conn, $post_id, $admin){
        $comments = array();
        $data = Comment::load_comment_data($conn, $post_id);
        if($data->num_rows > 0){
            while($row = $data->fetch_assoc()) {
                $comments[] = $row; // Append each fetched row to the $posts array
            }

            for($i = count($comments) - 1; $i >= 0; $i--){
                $comment = $comments[$i];
                $comment_id = $comment['comment_id'];
                $post_id = $comment['post_id'];
                $username = $comment['username'];
                $date = $comment['created_at'];
                $conntent = $comment['conntent'];
                $img = 'images/comon.webp';
                if($comment['photo_path']){
                    $img = $comment['photo_path'];
                }

                
                echo "<div class=\"comment\">";
                echo "<a href=\"user.php?username=$username\" class=\"link\">";
                echo "<div class=\"info-comment\">";
                echo "<div class=\"img-wrapper-com\" style=\" background-image: url('$img'); background-size: cover; background-repeat: no-repeat; background-position: center;\">";
                echo "<div class=\"info-text\">";
                echo "<span class=\"username-comment link-username\">".$username."</span><br>";
                echo "<span class=\"date-comment\">".$date."</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</a>";
                echo "<div class=\"comment-content\">";
                echo "<p class=\"comment-text\">".$conntent."</p>";
                if($_SESSION['user_id'] === $comment['user_id'] || $admin == true)
                    echo "<a class=\"delete-link\" onclick=\"deleteComment(".$comment_id.",".$post_id.")\"> delte </a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo '<p class="no-comments">no comments</p>';
        }
    }

    public static function delete_comment($conn, $comment_id){
        $sql = "DELETE FROM comment WHERE comment_id = $comment_id";
        $run = $conn->prepare($sql);
        $run->execute();
        return $run->get_result();
    }
}

?>