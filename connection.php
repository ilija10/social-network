<?php

        $servername = "localhost";
        $username = "admin";
        $password = "admin123";
        $database = "mreza";

        $conn = new mysqli($servername, $username, $password, $database);

        if($conn->connect_error)
        {
                die("Error connecting to database" . $conn->connect_error);
        }

?>