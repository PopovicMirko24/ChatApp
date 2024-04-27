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
        $sql_user = 'select name, username, last_name, email, user_id, photo_path, description from user where user_id = ?';
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
        $sql_user = "SELECT name, username, last_name, email, user_id, photo_path, user_id, description FROM User WHERE username = ?";
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
        $sql_user = 'select name, username, last_name, email, user_id, photo_path, description, user_id from user where username = ?';
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

    private static function load_all_users($conn){
        $sql = 'select name, username, last_name, email, user_id, photo_path, description, user_id, admin from user';
        $run = $conn -> prepare($sql);
        $run->execute();
        $results = $run -> get_result();
        if($results->num_rows > 0)
            return $results;
        else
            return null;
    }
    

    public static function show_all_users($conn){
        $results = User::load_all_users($conn);
        $users = array();
        if($results == null){
            echo "<p>No users found.</p>";
        }else{
            while($row = $results->fetch_assoc()){
                $users[] = $row;
            }

            echo "
                <tr>
                <th colspan=\"8\">Users</th>
                </tr>
                <tr>
                <th>id</th>
                <th>username</th>
                <th>name</th>
                <th>lastname</th>
                <th>email</th>
                <th>description</th>
                <th>-</th>
                <th>-</th>
                </tr>
                ";

            for($i = 0; $i < count($users); $i++){
                if($users[$i]['admin'])
                    continue;
                else{
                    echo "<tr>";
                    echo "<td>". $users[$i]['user_id']. "</td>";
                    echo "<td>". $users[$i]['username']. "</td>";
                    echo "<td>". $users[$i]['name']. "</td>";
                    echo "<td>". $users[$i]['last_name']. "</td>";
                    echo "<td>". $users[$i]['email']. "</td>";
                    echo "<td>". $users[$i]['description']. "</td>";
                    echo "<td> <a href=\"user.php?username=". $users[$i]['username'] ."\"> view </td>";
                    echo "<td> <a href=\"delete_user.php\"> delete </td>";
                    echo "</tr>";
                }
            }
        }
    }

}

?>