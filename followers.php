<?php
      require_once "header.php"; 

      if(empty($_SESSION['id'])) 
      {
            header('Location: login.php');
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Followers</title>
      <link rel="stylesheet" href="style.css">
      <!-- <style>
            h2 {text-align: center;}

            #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            #table td, #table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #4CAF50;
            color: white;
            }
      </style> -->
</head>
<body>

      <?php
      
            $id = $_SESSION['id'];

            // Follow
            if(!empty($_GET['follow']))
            {
                  $friendID = $conn->real_escape_string($_GET['follow']);

                  $q = "SELECT * FROM followers
                        WHERE sender_id = $id
                        AND receiever_id = $friendID";
            
                  $result = $conn->query($q);
            
                  if($result->num_rows == 0)
                  {
                        $q = "INSERT INTO followers(sender_id, receiever_id)
                              VALUES ($id, $friendID)";
                        
                        $result1 = $conn->query($q);
            
                        if(!$result1)
                        {
                              echo "<div>Error: " . $conn->error . "</div>";
                        }
                  }
            }

            // Unfollow
            if(!empty($_GET['unfollow']))
            {
                  $friendID = $conn->real_escape_string($_GET['unfollow']);

                  $q = "DELETE FROM followers
                        WHERE sender_id = $id
                        AND receiever_id = $friendID";

                  $result = $conn->query($q);

                  if(!$result)
                  {
                        echo "<div>Error: " . $conn->error . "</div>";
                  }
            }

            // Hello

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

            // Users table
            $q = "SELECT users.id, users.username, profiles.name, profiles.surname
                  FROM users
                  INNER JOIN profiles
                  ON users.id = profiles.user_id
                  WHERE users.id != '$id';";

            $result = $conn->query($q);

            if(!$result->num_rows)
            {
                  echo "<p>Trenutno u bazi nema korisnika</p>";
            }
            else
            {
                  echo "<table id='table'>";
                  echo "<tr>
                        <th>Ime i prezime</th>
                        <th>Korisnicko ime</th>
                        <th>Akcije</th>
                        </tr>";
                  foreach($result as $row)
                  {
                        echo "<tr>";
                        echo "<td><a href='profile.php?user_id=$id'>" .$row['name'] . " " . $row['surname'] . "</a></td>";
                        echo "<td>" . $row['username'] . "</td>";
                        $friendID = $row['id'];

                        // Ispitujemo da li ulogovan korisnik prati korisnika
                        $q1 = "SELECT * FROM followers
                               WHERE sender_id = $id
                               AND receiever_id = $friendID";
                        $result1 = $conn->query($q1);
                        $f1 = $result1->num_rows; // $f1 moze da ima vrednost 0 ili 1

                        // Ispitujemo dali korsnik prati ulogovanog korisnika
                        $q2 = "SELECT * FROM followers
                               WHERE sender_id = $friendID
                               AND receiever_id = $id";
                        $result2 = $conn->query($q2);
                        $f2 = $result2->num_rows; // $f2 moze da ima vrednost 0 ili 1

                        if($f1 == 0)
                        {
                              if($f2 == 0)
                              {
                                    $text = "Follow";
                              }
                              else
                              {
                                    $text = "Follow back";
                              }
                              echo "<td><a href='followers.php?follow=$friendID'>$text</a></td>";
                        }
                        else
                        {
                              echo "<td><a href='followers.php?unfollow=$friendID'>Unfollow</a></td>";
                        }
                        echo "</tr>";
                  }
                  echo "</table>";
            }

      ?>

</body>
</html>