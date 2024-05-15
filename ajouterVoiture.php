
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une voiture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; 
        }

        header {
            background-color: #ffffff; 
            padding: 10px 0;
            text-align: left;
            font-weight: normal;
            color: #336699; 
            width: 100%;
            height: 50px; 
            margin-bottom: 20px;
        }

        nav {
            background-color: #4b739b; 
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

        input[type="text"], input[type="date"] {
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
            <li><a href="gestMission.php">Gestion des mission</a></li>
            <li><a href="gestCompte.php">Gestion des conducteurs</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Ajouter une nouvelle voiture</h2>
        <form method="post">
            <label for="serviceNumber">Service Number</label>
            <input type="text" id="serviceNumber" name="serviceNumber" required>

            <label for="carteGrise">Carte Grise</label>
            <input type="text" id="carteGrise" name="carteGrise" required>

            <label for="controleTechnique">Contrôle Technique</label>
            <input type="date" id="controleTechnique" name="controleTechnique" required>

            <label for="typeVoiture">Type de Voiture</label>
            <input type="text" id="typeVoiture" name="typeVoiture" required>

            <label for="marque">Marque</label>
            <input type="text" id="marque" name="marque" required>

            <button type="submit">Ajouter</button>
        </form>
        
        <?php
        // Connexion à la base de données
        $servername = "localhost:3307"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "carproject"; 

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des données du formulaire
            $serviceNumber = $_POST["serviceNumber"];
            $carteGrise = $_POST["carteGrise"];
            $controleTechnique = $_POST["controleTechnique"];
            $typeVoiture = $_POST["typeVoiture"];
            $marque = $_POST["marque"];

            // Requête SQL pour insérer la nouvelle voiture
            $sql_insert_car = "INSERT INTO car (serviceNumber, carteGrise, dateControle, TypeVoiture, Marque) VALUES ('$serviceNumber', '$carteGrise', '$controleTechnique', '$typeVoiture', '$marque')";

            if ($conn->query($sql_insert_car) === TRUE) {
                echo "<script>alert('Voiture ajoutée avec succès');</script>";
            } else {
                echo "<script>alert('Erreur lors de l\'ajout de la voiture');</script>";
            }
        }
        $conn->close();
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
