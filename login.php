<?php
      // Otvaranje sesije na pocetku skripte
      session_start();

      require_once "connection.php";

      $usernameErr = $passErr = "*";

      if($_SERVER['REQUEST_METHOD'] == "POST")
      {
            $username = $conn->real_escape_string($_POST['username']);
            $pass = $conn->real_escape_string($_POST['pass']);
            $val = true;
            
            if(empty($username))
            {
                  $val = false;
                  $usernameErr = "Enter username";
            }

            if(empty($pass))
            {
                  $val = false;
                  $passErr = "Enter password";
            }

            if($val) // Pokusavamo da ulogujemo korisnika samo ako su sva polja popunjena
            {
                  $sql = "SELECT * FROM users WHERE username = '$username'";
                  $result = $conn->query($sql);
                  if($result->num_rows == 0)
                  {
                        $usernameErr = "This username doesn't exist";
                  }
                  else // Postoji korisnicko ime, treba proveriti sifre
                  {
                        $row = $result->fetch_assoc();
                        $dbPass = $row['pass'];
                        
                        if($dbPass != md5($pass))
                        {
                              $passErr = "Incorrect password";
                        }
                        else // Vrsimo logovanje
                        {
                              $_SESSION['id'] = $row['id'];
                              // $_SESSION['full_name'] = ...

                              header('Location: followers.php');
                        }
                  }
            }
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login to the site!</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>

      <div class="form">
      <form action="" method="POST">

            <p>
                  <label for="username">Username: </label>  
                  <input type="text" name="username" id="username">
                  <span class="error"><?php echo $usernameErr ?></span>
            </p>

            <p>
                  <label for="pass">Password: </label>
                  <input type="password" name="pass" id="pass">
                  <span class="error"><?php echo $passErr ?></span>
            </p>

            <p>
                  <input type="submit" value="Log In">
            </p>

            <p>
            <a href="index.php">Go Back to Home Page</a>
            </p>

      </form>
      </div>

      
</body>
</html>