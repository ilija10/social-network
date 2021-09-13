<?php
      require_once "connection.php";
      require_once "header.php";
      require_once "validation.php";

      if(!isset($_SESSION['id']))
      {
            header('Location: index.php');
      }

      $id = $_SESSION['id'];
      //$oldPassword = $_SESSION['password'];

      $validated = true;
      $password = $retypePassword = "";
      $oldPasswordErr = $passwordErr = $retypePasswordErr = "";

      $q = "SELECT * FROM users WHERE id = $id";
      $result = $conn->query($q);
      $row = $result->fetch_assoc();

      $oldPass = $row['pass'];

      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
            $oldPassword = md5($_POST['oldPassword']);
            $password = $_POST['password'];
            $retypePassword = $_POST['retypePassword'];

            if($oldPass != $oldPassword)
            {
                  $validated = false;
                  $oldPasswordErr = "Error";
            }
            else
            {
                  // Password validation
                  if(passwordValidation($password))
                  {
                        $validated = false;
                        $passwordErr = passwordValidation($password);
                  }
                  // Retype password
                  if(passwordValidation($retypePassword))
                  {
                        $validated = false;
                        $retypePasswordErr = passwordValidation($retypePassword);
                  }
                  // Password == Retype password
                  if($password != $retypePassword)
                  {
                        $validated = false;
                        $retypePasswordErr = "Password and Retype password must be the same";
                  }
                  else 
                  {
                        $password = md5($password);
                  }
            }
            if($validated)
            {
                  $q = "UPDATE users SET pass = '$password' WHERE id ='$id'";

                  if($conn->query($q)) 
                  {
                        //echo "Record updated successfully";
                  }
                  else 
                  {
                        echo "<p class='error'>Error updating record: " . $conn->error . "</p>";
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
      <title>Document</title>
      <style>
            h2 {text-align: center;}
      </style>
</head>
<body>
      <?php
            $q = "SELECT users.id, users.username, profiles.name, profiles.surname
            FROM users
            INNER JOIN profiles
            ON users.id = profiles.user_id
            WHERE users.id = '$id';";

            $result = $conn->query($q);

            if(!$result->num_rows)
            {
                  echo "<h2>Welcome!</h2>";
            }
            else
            {
                  foreach($result as $row)
                  {
                        echo "<h2>Hello " . $row['name'] . " " . $row['surname'] . "!</h2>";
                  }
            }
      ?>
      <div class="form">
        <form action="#" method="post">
            <p>
                Old password:
                <input type="text" name="oldPassword">
                <span class="error">* <?php echo $oldPasswordErr; ?></span>
            </p>
            <p>
                Password:
                <input type="password" name="password">
                <span class="error">* <?php echo $passwordErr; ?></span>
            </p>
            <p>
                Retype password:
                <input type="password" name="retypePassword">
                <span class="error">* <?php echo $retypePasswordErr; ?></span>
            </p>
            <p>
                <input type="submit" value="Submit">
                <input type="reset" name="reset" value="Reset">
            </p>
        </form>
    </div> 
</body>
</html>