<?php
require_once 'scripts/php-scripts/connectionDB.php';
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
                $sql_insert = "insert into user (name, last_name, email, username, password) values (?,?,?,?,?)";
                $run = $conn -> prepare($sql_insert);
                $run -> bind_param("sssss", $name, $lastname, $email, $username, $hashed_password);
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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST" class="form" id="register">
                    <div class="form-content">
                        <h2>Register</h2>
                        <p class="error-message"><?php echo $error_text; ?></p>
                        <div class="form-group">
                            <input class="form-control" type="text" name="name" id="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Lastname" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                        <p><a href="login.php">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script1.js"></script>
</body>
</html>