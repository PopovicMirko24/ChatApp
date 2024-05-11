<?php

class Following{
    public static function Is_following($conn,$user1_id, $user2_id){
        $sql = 'select user2_id from following where user1_id=' .$user1_id;
        $run = $conn->prepare($sql);
        $run->execute();
        $results = $run->get_result();
        if($results->num_rows > 0){
            while ($row = $results->fetch_assoc()) {
                if ($row['user2_id'] == $user2_id) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function follow($conn,$user1_id, $user2_id){
        $sql = 'insert into following (user1_id, user2_id) values (?,?)';
        $run = $conn->prepare($sql);
        $run->bind_param('ii', $user1_id, $user2_id);
        $run->execute();
    }

    public static function unfollow($conn,$user1_id, $user2_id){
        $sql = 'delete from following where user1_id = ? and user2_id = ?';
        $run = $conn->prepare($sql);
        $run -> bind_param('ii', $user1_id, $user2_id);
        $run->execute();
    }

    public static function get_all_followings($conn,$user1_id){
        $sql = 'select user2_id from following where user1_id=' .$user1_id;
        $run = $conn->prepare($sql);
        $run->execute();
        $results = $run->get_result();
        $followings = array();
        while ($row = $results->fetch_assoc()) {
            $followings[] = $row['user2_id'];
        }
        return $followings;
    }

    public static function get_all_followers($conn,$user2_id){
        $sql = 'select user1_id from following where user2_id=' .$user2_id;
        $run = $conn->prepare($sql);
        $run->execute();
        $results = $run->get_result();
        $followings = array();
        while ($row = $results->fetch_assoc()) {
            $followings[] = $row['user1_id'];
        }   
        return $followings;
    }

    public static function show_following($conn, $user_id){
        $followings = array();
        $followings = Following::get_all_followings($conn, $user_id);

        if($followings == null){
            echo '<center>no followers</center>';
        }else{
            foreach($followings as $following){
                $user = User::load_user_data($following,$conn);
                $username = $user->get_username();
                $img = $user->get_photo_path();
                echo '
                <a href="user.php?username=' . $username . '" class="link">
                <div class="users">
                <div class="img-wrapper-following" style=" background-image: url(\''.$img.'\'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                    <div class="following-username"><p class="following-username link-username">'.$username.'</p></div>       
                </div></a>
                ';
            }
        }
    }

    public static function show_followers($conn, $user_id){
        $followings = array();
        $followings = Following::get_all_followers($conn, $user_id);
        if($followings == null){
            echo '<center>no followers</center>';
        }else{
            foreach($followings as $following){
                $user = User::load_user_data($following,$conn);
                $username = $user->get_username();
                $img = $user->get_photo_path();
                echo '
                <a href="user.php?username=' . $username . '" class="link">
                <div class="users">
                    <div class="img-wrapper-following" style=" background-image: url(\''.$img.'\'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div>
                    <div class="following-username"><p class="following-username link-username">' . $username . '</p></div>       
                </div></a>
                ';
            }
        }
    }
}



?>