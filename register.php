<?php
require_once 'connectionDB.php';
    $error_text = "";

    if(!$conn){
        die("Neuspesna konekcija sa bazom");  
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $error_text = "";
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];

        $select_email_sql = "select email from user where email = ?";
        $run = $conn -> prepare($select_email_sql);
        $run -> bind_param("s", $email);
        $run -> execute();

        $results = $run -> get_result();
        if($results -> num_rows > 0){
            $error_text = "email is already in use";
        }else{
            $select_username_sql = "select username from user where username = ?";
            $run = $conn -> prepare($select_username_sql);
            $run -> bind_param("s", $username);
            $run -> execute();
            $results = $run -> get_result();
            if($results -> num_rows > 0){
                $error_text = "username is already in use";
            }else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert = "insert into user (name, last_name, email, username, password, gender) values (?,?,?,?,?,?)";
                $run = $conn -> prepare($sql_insert);
                $run -> bind_param("ssssss", $name, $lastname, $email, $username, $hashed_password, $gender);
                $run -> execute();
                header("location: login.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
            <form action="" method="POST" class="form" id="login">
                <div class="from-content">
                    <h2>register</h2>
                    <p class="error-message"><?php echo $error_text; ?></p>
                    <input class="text-input" type="text" name="name" id="name" placeholder="name"><br>
                    <input class="text-input" type="text" name="lastname" id="lastname" placeholder="lastname"><br>
                    <input class="text-input" type="email" name="email" id="email" placeholder="email"><br>
                    <input class="text-input" type="text" name="username" id="username" placeholder="username"><br>
                    <input class="text-input"type="password" name="password" id="password" placeholder="password"><br><br>
                    <select name="gender" id="gender" class="select">
                        <option value="male">male</option>
                        <option value="female">female</option>
                    </select><br>
                    <input class="button" type="submit" value="register">
                    <p><a href="login.php">login</a></p>
                </div>
        </div>
    </div>
    <script src="script1.js"></script>
</body>
</html>