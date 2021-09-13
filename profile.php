<?php
      require_once "connection.php";
      require_once "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Profile</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>
      <?php
            $id = $_SESSION['id'];

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

            $q = "SELECT users.id, users.username, profiles.name, profiles.surname, profiles.gender, profiles.dob, profiles.bio
                  FROM users
                  INNER JOIN profiles
                  ON users.id = profiles.user_id
                  WHERE users.id = '$id';";
            
            $result = $conn->query($q);

            if(!$result->num_rows)
            {
                  echo "<p>Trenutno u bazi nema korisnika</p>";
            }
            else
            {
                  echo "<table id='table'>";
                  
                  foreach($result as $row)
                  {
                        if($row['gender'] == "m")
                        {
                              $boja = "m";
                        }
                        elseif($row['gender'] == "z")
                        {
                              $boja = "z";
                        }
                        else
                        {
                              $boja = "o";
                        }

                        echo "<tr id='$boja'>
                                    <th>First Name</th>
                                    <td>" . $row['name'] . "</td>
                              </tr>";
                        echo "<tr id='$boja'>
                                    <th>Last Name</th>
                                    <td>" . $row['surname'] . "</td>
                              </tr>";
                        echo "<tr id='$boja'>
                                    <th>Username</th>
                                    <td>" . $row['username'] . "</td>
                              </tr>";
                        echo "<tr id='$boja'>
                                    <th>Date of birth</th>
                                    <td>" . $row['dob'] . "</td>
                              </tr>";
                        echo "<tr id='$boja'>
                                    <th>Gender</th>
                                    <td>" . $row['gender'] . "</td>
                              </tr>";
                        echo "<tr id='$boja'>
                                    <th>About me</th>
                                    <td>" . $row['bio'] . "</td>
                              </tr>";            
                  }

                  echo "</table>";
            }

            echo "<a href='followers.php'>Followers</a>";
      ?>
</body>
</html>