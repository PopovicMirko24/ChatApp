<?php
require_once 'connectionDB.php';

class User{
    private $id;
    private $name;
    private $lastname;
    private $username;
    private $email;
    private $photo_path;
    private $description;

    function __construct($id,$name,$lastname,$username, $email,$photo_path,$description){
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->email = $email;
        $this->photo_path = $photo_path;
        $this->description = $description;
    }

    public function get_id(){
        return $this->id;
    }

    public function get_name(){
        return $this->name;
    }
    public function get_lastname(){
        return $this->lastname;
    }

    public function get_username(){
        return $this->username;
    }
    public function get_photo_path(){
        return $this->photo_path;
    }

    public function get_description(){
        return $this->description;
    }

    public function set_id($id){
        $this->id = $id;
    }

    public function set_name($name){
        $this->name = $name;
    }

    public function set_lastname($lastname){
        $this->lastname = $lastname;
    }
    public function set_username($username){
        $this->username = $username;
    }
    public function set_email($email){
        $this->email = $email;
    }
    public function set_photo_path($photo_path){
        $this->photo_path = $photo_path;
    }

    public function set_description($description){
        $this->description = $description;
    }

    public static function load_user_data($user_id, $conn){
        $sql_user = 'select * from user where user_id = ?';
        $run = $conn ->prepare($sql_user);
        $run -> bind_param("i", $user_id);
        $run -> execute();
        $results = $run -> get_result();
        $user = $results -> fetch_assoc();
    
        $img = "images/comon.webp";
        $description = "no description";
        if($user['photo_path'] != null){
            $img = $user['photo_path'];
        }
    
        if($user['description']!=null){
            $description = $user['description'];
        }

        return new User($user_id, $user['name'], $user['last_name'], $user['username'],$user['email'], $img, $description);
    }

    public static function load_user_data_by_username($username, $conn){
        $sql_user = "SELECT * FROM User WHERE username = ?";
        $run = $conn->prepare($sql_user);
       $run->bind_param("s", $username); // Use "s" for string parameter
        $run->execute();
        if ($run->error) {
            die('Error executing query: ' . $run->error);
        }
        $results = $run->get_result();
        $user = $results->fetch_assoc();
    
        $img = "images/comon.webp";
        $description = "no description";
        if($user !== null) {
            if($user['photo_path']){
                $img = $user['photo_path'];
            }
    
            if($user['description'] != null){
                $description = $user['description'];
            }
        
            return new User($user['user_id'], $user['name'], $user['last_name'], $user['username'], $username, $img, $description);
        } else {
            return null; // Return null if no user found
        }
    }
    
    
    public static function search_user($username, $conn){
        $sql_user = 'select * from user where username = ?';
        $run = $conn ->prepare($sql_user);
        $run -> bind_param("i", $username);
        $run -> execute();
        $results = $run -> get_result();
        
        if($results->num_rows > 0){
            $user = $results -> fetch_assoc();
    
            $img = "images/comon.webp";
            $description = "no description";
        
            if($user['photo_path'] != null){
                $img = $user['photo_path'];
            }
    
            if($user['description']!=null){
                $description = $user['description'];
            }

            return new User($user['user_id'], $user['name'], $user['last_name'], $user['username'],$user['email'], $img, $description);
        }else{
            return null;
        }
    }

    public static function save_changes($conn, $name, $lastname, $description, $img, $user_id){
        $sql = 'update user set name=?, last_name=?, description=?, photo_path=? where user_id=?';
        $run = $conn -> prepare($sql);
        $run -> bind_param('ssssi', $name, $lastname, $description, $img, $user_id);
        $run -> execute();
    }

}

?>