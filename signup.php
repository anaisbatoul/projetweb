<?php
 // Connexion à la base de données
 $servername = "localhost"; 
 $username = "root"; 
 $password = ""; 
 $dbname = "carproject"; 

 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "INSERT INTO User (nomUser, prenomUser, dateNaissance, lieuNaissance, adresse, motDePasse) VALUES ('$lastName', '$firstName', '$dateOfBirth', '$placeOfBirth', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {

        $last_id = $conn->insert_id;

        header("Location: profil.php?id=$last_id");
        exit(); 
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription - Fleetprodrivers</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
</head>
<body>
    <menu>
        <nav>
            <table width="100%">
                <tr>
                    <td>
                        <font color="#336699" size="20">Fleetprodrivers</font>
                        <font size="5">Inscription</font>
                    </td>
                    <td width="5%">
                        <a>
                            <img src="home.png" height="25" width="30"></img>
                        </a>
                    </td>
                </tr>
            </table>
        </nav>
    </menu>
    <div class="signup-box">
        <center><img src="car.png" height="25" width="30"></img></center>
        <h2>Create an Account</h2>
        <p>Sign up for Fleetprodrivers</p>
        <form action="" method="POST">
            <label for="firstName">Prénom</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="dateOfBirth">Date de naissance</label>
            <br>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>
            <br><br>
            <label for="placeOfBirth">Lieu de naissance</label>
            <input type="text" id="placeOfBirth" name="placeOfBirth" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="index.php">Log In</a></p>
    </div>
</body>
</html>
