<?php

      require_once "connection.php";

      $q = "ALTER TABLE profiles ADD bio TEXT";

      if($conn->query($q))
      {
            echo "Table updated";
      }
      else
      {
            echo "Error " . $conn->error;
      }

?>