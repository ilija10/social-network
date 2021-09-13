<?php
    require_once "connection.php";
    require_once "header.php";
    require_once "validation.php";

    if(!isset($_SESSION['id']))
      {
            header('Location: index.php');
      }

    $id = $_SESSION['id'];

    //Postavljanje pocetnih vrednosti
    $validated = true;
    $name = $surname = $gender = $dob = $bio = "";
    $nameErr = $surnameErr = $dobErr = $bioErr = "";

    //Uzimamo STARE podatke iz baze
    $q = "SELECT * FROM profiles WHERE `user_id` = $id";
    $result = $conn->query($q);
    $row = $result->fetch_assoc();

    //Uzimamo NOVE podatke iz forme
    $name = $row['name'];
    $surname = $row['surname'];
    $gender = $row['gender'];
    $dob = $row['dob'];
    $bio = $row['bio'];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $bio = $_POST['bio'];

        // Name validation
        if(textValidation($name))
        {
            $validated = false;
            $nameErr = textValidation($name);
        }
        else 
        {
            $name = trim($name); //Odsecanje praznina pre i nakon stringa
            $name = preg_replace('/\s\s+/', ' ', $name); //Odsecanje duplih praznina unutar stringa
        }

        // Surname validation
        if(textValidation($surname))
        {
            $validated = false;
            $surnameErr = textValidation($surname);
        }
        else 
        {
            $surname = trim($surname); //Odsecanje praznina pre i nakon stringa
            $surname = preg_replace('/\s\s+/', ' ', $surname); //Odsecanje duplih praznina unutar stringa
        }

        // Date of birth validation
        if(dobValidation($dob))
        {
            $validated = false;
            $dobErr = dobValidation($dob);
        }

        // Biography validation
        if(biographyValidation($bio))
        {
            $validated = false;
            $bioErr = biographyValidation($bio);
        }

        if($validated)
        {

            $q = "UPDATE profiles
                  SET `name` = '$name',
                        surname = '$surname',
                        gender = '$gender',
                        dob = '$dob',
                        bio = '$bio'
                  WHERE `user_id` = $id";

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
      <title>Change profile</title>
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
                Name:
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span class="error">* <?php echo $nameErr; ?></span>
            </p>
            <p>
                Surname:
                <input type="text" name="surname" value="<?php echo $surname; ?>">
                <span class="error">* <?php echo $surnameErr; ?></span>
            </p>
            <p>
                Gender:
                <input type="radio" name="gender" value="m" <?php if($gender=="m"){echo 'checked';} ?>>Male
                <input type="radio" name="gender" value="f" <?php if($gender=="f"){echo 'checked';} ?>>Female
                <input type="radio" name="gender" value="o" <?php if($gender!="m" && $gender!="f"){echo 'checked';} ?>>Other
            </p>
            <p>
                Data of birth:
                <input type="date" name="dob" value="<?php echo $dob; ?>">
                <span class="error"><?php echo $dobErr; ?></span>
            </p>
            <p>
                Biography:
                <textarea name="bio" id="" cols="40" rows="10">Biography</textarea>
                <!-- <input type="text" name="bio" value="<?php echo $bio; ?>">
                <span class="error">* <?php echo $bioErr; ?></span> -->
            </p>
            <p>
                <input type="submit" value="Submit">
                <input type="reset" name="reset" value="Reset">
            </p>
        </form>
    </div>
</body>
</html>