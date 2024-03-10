<?php

require_once 'connectionDB.php';
require_once 'user-class.php';
require_once 'post-class.php';
require_once 'search-class.php';

if(!$conn){
    die("Neuspesna konekcija sa bazom");  
}

if(!isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}

$user =  User::load_user_data($_SESSION['user_id'], $conn);
$img = $user->get_photo_path();


$upload_dir = 'images/' .$user->get_username();
$new_img_path = $img;

if(array_key_exists('cancle', $_POST)){
    header('location: profile.php');
}else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = basename($_FILES['file']['name']);
        
        // Kreiranje direktorijuma ako ne postoji
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $upload_path = $upload_dir . '/' . $file_name;
        // Premestanje slike u odredišni direktorijum
        if(move_uploaded_file($file_tmp, $upload_path)) {
            // Novi put do slike
            $new_img_path = $upload_path;
            // Ažuriranje puta do slike u bazi podataka ili gde vam je potrebno
            // $user->update_photo_path($new_img_path);
            // Možete dodati funkciju za ažuriranje puta do slike u vašoj User klasi
            $img = $new_img_path; // Ažurirajte put do slike koja se prikazuje na stranici
            User::save_changes($conn, $user->get_name(), $user->get_lastname(), $img,$_SESSION['user_id']);
            header('location: profile.php');
        } else {
            echo "Greška prilikom otpremanja slike.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="img-wrapper">
                <img id="img" src="<?php echo $img; ?>" alt=""><br>
                <input type="file" name="file" id="file" onchange="ucitajFile()">
            </div>
            <div class="column">
                <input type="text" name="username" id="" value="<?php echo $user->get_username() ?>" disabled><br>
                <input type="text" name="" id="" value="<?php echo $user->get_name() ?>"><br>
                <input type="text" name="" id="" value="<?php echo $user->get_lastname() ?>">
            </div>
            <br>
            <div class="buttons">
                <input class="save" type="submit" value="save">
                <input class="cancle" name="cancle" type="submit" value="cancle">
            </div>
        </form>
    </div>
    <script>
        function ucitajFile(){
            var file1 = document.getElementById("file");
            var tal = document.getElementById("textarea");
            if(file1.files.length != 0 && file1.files[0].type.match(/image.*/)){
                var fajl = file1.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(fajl);
                reader.onload = function (e){
                    var img = document.getElementById("img");
                    img.src = e.target.result;    
                };

                reader.error = function (){
                    alert("Greska pr ciranju fajla");
                };
            }
            else{
                alert("Greska pri citanju fajla 1")
            }
        }
    </script>
</body>
</html>