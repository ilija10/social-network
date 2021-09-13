<?php 
  session_start();
  require_once "connection.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
  <script>
    function myFunction()
    {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav")
      {
      x.className += " responsive";
      }
      else 
      {
      x.className = "topnav";
      }
    }
  </script>
  <div class="topnav" id="myTopnav">
    <a href="index.php" class="active">Home</a>
    <a href="followers.php">Friends</a>
    <a href="changeProfile.php">Change profile</a>
    <a href="changePass.php">Change password</a>
    <a href="logout.php">Logout</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i></a>
  </div>