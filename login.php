<?php

require_once 'scripts/php-scripts/connectionDB.php';
$error_text = "";
if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

$_SESSION['admin'] = false;

if($_SESSION['user_id']!=null)
    $_SESSION['user_id'] = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];

    $sql_username = 'select user_id, password, admin from user where username = ?';
    $run = $conn -> prepare($sql_username);
    $run -> bind_param('s', $username);
    $run -> execute();
    $results = $run -> get_result();
    if($results -> num_rows == 1){
        $user = $results -> fetch_assoc();
        if(password_verify($_POST['password'], $user['password'])){
            $_SESSION['user_id'] = $user['user_id'];
            if(!$user['admin'])
                header('location: profile.php');
            else{
                $_SESSION['admin'] = true;
                header('location: admin-deashboard.php');
            }
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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST" class="form" id="login">
                    <div class="form-content">
                        <h2>Login</h2>
                        <p class="error-message"><?php echo $error_text ?></p>
                        <div class="form-group">
                            <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Login</button>
                        <p><a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
