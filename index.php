<?php
      require_once "connection.php";
      session_start();

      if(isset($_SESSION['id']))
      {
            header('Location: followers.php');
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Social network</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>
      <div class="form">
            <h1>Welcome!</h1>

            <div>
                  <a href="login.php" class="button">Login</a>
            </div>
            
            <br>

            <div>
                  <a href="register.php" class="button">Register</a>
            </div>

            <br>
      </div>

</body>
</html>