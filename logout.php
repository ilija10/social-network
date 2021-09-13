<?php
      session_start();

      if(isset($_SESSION['id']))
      {
            // Brisemo sesiju
            $_SESSION = array();
            session_destroy();
      }

      header('Location: login.php');
?>