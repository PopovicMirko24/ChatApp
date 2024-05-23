<?php

require_once 'scripts/php-scripts/connectionDB.php';
require_once 'classes/user-class.php';

if (!$conn) {
    die("Neuspesna konekcija sa bazom");
}

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $user = $search_class->searchUsers($search);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<?php require_once 'nav.php'; ?>

<body>
    <div class="section">
        <div class="users">
            <table id="table"></table>
        </div>
    </div>
    <script src="scripts/js-scripts/admin-table.js"></script>
</body>

</html>