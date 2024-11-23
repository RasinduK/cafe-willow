<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];  // Plain-text password

   // Prepare query to fetch admin details by username and password
   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);  // Query compares the plain-text password

   // Check if username and password match
   if ($select_admin->rowCount() > 0) {
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location: dashboard.php');
      exit; // Make sure to stop further execution
   } else {
      $message[] = 'Incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin login</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../css/custom_login.css">

</head>

<body>

   <?php
   // Display error messages
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>

   <!-- Admin login form section starts -->
   <section class="box">

      <form action="" method="POST">
         <h1>Admin logIn</h1>
         <ul>
            <li><label for="name">Username</label></li>
            <li><input type="text" name="name" maxlength="20" required placeholder="" oninput="this.value = this.value.replace(/\s/g, '')"></li>
            <li><label for="pass">Password</label></li>
            <li><input type="password" name="pass" maxlength="20" required placeholder="" oninput="this.value = this.value.replace(/\s/g, '')"></li>
         </ul>
         <input type="submit" value="login now" name="submit" class="button">
      </form>

   </section>
   <!-- Admin login form section ends -->

</body>

</html>
