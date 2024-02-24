<?php

require_once 'connectionDB.php';
$error_text = "";
//$_SESSION['user_id'] = null;
if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $error_text = "";
    $username = $_POST['username'];

    $sql_username = 'select user_id, password from user where username = ?';
    $run = $conn -> prepare($sql_username);
    $run -> bind_param('s', $username);
    $run -> execute();
    $results = $run -> get_result();
    var_dump($results);
    if($results -> num_rows == 1){
        $user = $results -> fetch_assoc();
        if(password_verify($_POST['password'], $user['password'])){
            $_SESSION['user_id'] = $user['user_id'];
            header('location: profile.php');
        }else{
            $error_text = 'wrong password';
        }
    }else{
        $error_text = "username does not exist";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
            <form action="" method="POST" class="form" id="login">
                <div class="from-content">
                    <h2>login</h2>
                    <p><?php $error_text ?></p>
                    <input class="text-input" type="text" name="username" id="username" placeholder="username"><br>
                    <input class="text-input"type="password" name="password" id="password" placeholder="password"><br>
                    <input class="button" type="submit" value="login">
                    <p><a href="register.php">register</a></p>
                </div>
        </div>
    </div>
</body>
</html>