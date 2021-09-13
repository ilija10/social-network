<?php

        require_once "connection.php";

        $q = "USE mreza;";

        $q .= "CREATE TABLE IF NOT EXISTS users
                (
                        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        username VARCHAR(50) NOT NULL,
                        pass VARCHAR(255) NOT NULL
                )ENGINE = InnoDB;";
        
        $q .= "CREATE TABLE IF NOT EXISTS profiles
                (
                        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        `name` VARCHAR(50) NOT NULL,
                        surname VARCHAR(50) NOT NULL,
                        gender CHAR(1),
                        dob DATE,
                        `user_id` INT UNSIGNED NOT NULL,
                        FOREIGN KEY (`user_id`) REFERENCES users(id)
                )ENGINE = InnoDB;";

        $q .= "CREATE TABLE IF NOT EXISTS followers
                (
                        id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                        sender_id INT UNSIGNED NOT NULL,
                        receiever_id INT UNSIGNED NOT NULL,
                        FOREIGN KEY (sender_id) REFERENCES users(id),
                        FOREIGN KEY (receiever_id) REFERENCES users(id)
                )ENGINE = InnoDB;";

        if($conn->multi_query($q))
        {
                echo "<p>Uspesno kreirane tabele</p>";
        }
        else
        {
                echo "Error " . $q . "<br>" . $conn->error;
        }

?>