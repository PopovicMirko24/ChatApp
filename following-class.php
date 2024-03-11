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
        $run -> bind_param('ii', $user1_id, $user2_id);
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
}

?>