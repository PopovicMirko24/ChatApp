<?php 

require_once 'connectionDB.php';

class Search{

    private $username;

    public function __construct($username){
        $this->username = $username;
    }

    public function get_username(){
        return $this->username;
    }

    public static function search_users($conn, $username){
        $users = array();
        $query = 'select * from user where username = ?';
        $run = $conn->prepare($query);
        $run->bind_param('s', $username);
        $run->execute();
        $results= $run->get_result();
        if($results->num_rows > 0){
            $search = $results->fetch_assoc();
            $img = "images/comon.webp";
            if($search['photo_path'] != null){
                $img = $search['photo_path'];
            }
            $username = $search['username'];
            echo "
            <a href=\"user.php?username='$username'\">
                <div class=\"profile\">
                    <div class=\"img-wrapper\" style=\" background-image: url('$img'); background-size: cover; background-repeat: no-repeat; background-position: center;\"></div>
                    <div class=\"info\">
                        <h3 class=\"username\">" . $search['username'] . "</h3>
                        <span class=\"name\">" . $search['name'] . " " . $search['last_name'] . "</span>
                    </div>
                </div>
            </a>
            ";
        }else{
            echo "
            
            <div class=\"profile\">
                <p>no users</p>
            </div>

            ";
        }
    }
}

?>