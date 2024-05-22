<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un compte conducteur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; 
        }

        header {
            background-color: #ffffff; /* Blanc */
            padding: 10px 0;
            text-align: left;
            font-weight: normal;
            color: #336699; /* Bleu */
            width: 100%;
            height: 50px; 
            margin-bottom: 20px;
        }

    
        nav {
            background-color: #4b739b; /* Bleu */
            padding: 10px 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
        }

      
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }

        h2 {
            color: #336699; 
            border-bottom: 2px solid #336699; 
            padding-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff; 
            color: #fff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
       
        footer {
            text-align: center;
            margin-top: 90px;
            padding: 20px;
            background-color: #336699; 
            color: #ffffff; 
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Fleetprodrivers <span style="font-size: 14px;">Admin</span></h1>
            <a href="index.php">Déconnexion</a>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="admin.php">Home</a></li>
            <li><a href="gestVoiture.php">Gestion des voitures</a></li>
            <li><a href="gestMission.php">Gestion des missions</a></li>
            <li><a href="gestCompte.php">Gestion des comptes drivers</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Ajouter un nouveau compte conducteur</h2>
        <form method="post">
            <label for="firstName">Prénom</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="dateOfBirth">Date de naissance</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>

            <label for="placeOfBirth">Lieu de naissance</label>
            <input type="text" id="placeOfBirth" name="placeOfBirth" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <label for="permis">Types de permis</label><br>
            <?php
            // Connexion à la base de données
            $servername = "localhost"; 
            $username = "root"; 
            $password_db = ""; 
            $dbname = "carproject";

            // Création de la connexion
            $conn = new mysqli($servername, $username, $password_db, $dbname);

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Récupération des types de permis depuis la base de données
            $sql = "SELECT * FROM typepermis";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $idPermis = $row['idPermis'];
                    $typePermis = $row['typepermis'];
                    ?>
                    <label for="permis<?php echo $idPermis; ?>">
                        <input type="checkbox" id="permis<?php echo $idPermis; ?>" name="permis[]" value="<?php echo $idPermis; ?>">
                        <?php echo $typePermis; ?>
                    </label><br>
                    <?php
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>

            <button type="submit">Ajouter</button>
        </form>
    </div>

    <?php
    // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $dateOfBirth = $_POST["dateOfBirth"];
        $placeOfBirth = $_POST["placeOfBirth"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $permis = $_POST["permis"]; // tableau contenant les ID des permis sélectionnés

        // Connexion à la base de données
        $servername = "localhost"; 
        $username = "root"; 
        $password_db = ""; 
        $dbname = "carproject";

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Préparation de la requête SQL d'insertion
        $sql = "INSERT INTO user (prenomUser, nomUser, dateNaissance, lieuNaissance, adresse, motDePasse)
                VALUES ('$firstName', '$lastName', '$dateOfBirth', '$placeOfBirth', '$email', '$password')";

        // Exécution de la requête
        if ($conn->query($sql) === TRUE) {
            // Récupération de l'ID du dernier utilisateur ajouté
            $last_id = $conn->insert_id;

            // Insertion des types de permis dans la table usertypepermis
            foreach ($permis as $idPermis) {
                $sql = "INSERT INTO usertypepermis (idUser, idPermis)
                        VALUES ('$last_id', '$idPermis')";
                $conn->query($sql);
            }

            echo "Le compte conducteur a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du compte conducteur: " . $conn->error;
        }

        // Fermeture de la connexion à la base de données
        $conn->close();
    }
    ?>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
