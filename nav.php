<?php

require_once 'scripts/php-scripts/connectionDB.php';

$user = User::load_user_data($_SESSION['user_id'], $conn);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <title> Profile </title>
   <link rel="stylesheet" href="css/nav2.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
   <?php

   if ($user->get_admin()) {
      echo '
      
      <nav>
         <div class="menu-icon">
            <span class="fas fa-bars"></span>
         </div>
         <div class="logo">
            Social Media
         </div>
         <div class="nav-items">
            <li><a href="admin-deashboard.php">Deashboard</a></li>
            <li><a href="scripts/php-scripts/logout.php">Logout</a></li>
         </div>
         <div class="search-icon">
            <span class="fas fa-search"></span>
         </div>
         <div class="cancel-icon">
            <span class="fas fa-times"></span>
         </div>
         <form >
            <input name="search-input" type="search" class="search-data" placeholder="Search" required>
            <button type="submit" class="fas fa-search"></button>
         </form>
      </nav>
      
      ';
   } else {
      echo '
      
      <nav>
         <div class="menu-icon">
            <span class="fas fa-bars"></span>
         </div>
         <div class="logo">
            Social Media
         </div>
         <div class="nav-items">
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="scripts/php-scripts/logout.php">Logout</a></li>
         </div>
         <div class="search-icon">
            <span class="fas fa-search"></span>
         </div>
         <div class="cancel-icon">
            <span class="fas fa-times"></span>
         </div>
         <form >
            <input name="search-input" type="search" class="search-data" placeholder="Search" required>
            <button type="submit" class="fas fa-search"></button>
         </form>
      </nav>
      
      ';
   }

   ?>
   <script>
      const menuBtn = document.querySelector(".menu-icon span");
      const searchBtn = document.querySelector(".search-icon");
      const cancelBtn = document.querySelector(".cancel-icon");
      const items = document.querySelector(".nav-items");
      const form = document.querySelector("form");
      menuBtn.onclick = () => {
         items.classList.add("active");
         menuBtn.classList.add("hide");
         searchBtn.classList.add("hide");
         cancelBtn.classList.add("show");
      }
      cancelBtn.onclick = () => {
         items.classList.remove("active");
         menuBtn.classList.remove("hide");
         searchBtn.classList.remove("hide");
         cancelBtn.classList.remove("show");
         form.classList.remove("active");
         cancelBtn.style.color = "#ff3d00";
      }
      searchBtn.onclick = () => {
         form.classList.add("active");
         searchBtn.classList.add("hide");
         cancelBtn.classList.add("show");
      }
   </script>
</body>

</html>