<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une voiture</title>
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
            <a href="index.html">Déconnexion</a>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="admin.html">Home</a></li>
            <li><a href="gestCompte.html">Gestion des comptes drivers</a></li>
            <li><a href="gestMission.html">Gestion des missions</a></li>
            <li><a href="gestVoiture.html">Gestion des voitures</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Modifier une voiture</h2>
        <form method="post">
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

            // Récupération de l'ID de la voiture à modifier depuis l'URL
            if(isset($_GET['id'])) {
                $id = $_GET['id'];

                // Requête SQL pour récupérer les données de la voiture
                $sql = "SELECT * FROM car WHERE idCar='$id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<label for="serviceNumber">Service Number</label>';
                        echo '<input type="text" id="serviceNumber" name="serviceNumber" value="' . $row["serviceNumber"] . '" required>';

                        echo '<label for="carteGrise">Carte Grise</label>';
                        echo '<input type="text" id="carteGrise" name="carteGrise" value="' . $row["carteGrise"] . '" required>';

                        echo '<label for="controleTechnique">Contrôle Technique</label>';
                        echo '<input type="date" id="controleTechnique" name="controleTechnique" value="' . $row["dateControle"] . '" required>';

                        echo '<label for="typeVoiture">Type de Voiture</label>';
                        echo '<input type="text" id="typeVoiture" name="typeVoiture" value="' . $row["TypeVoiture"] . '" required>';

                        echo '<label for="marque">Marque</label>';
                        echo '<input type="text" id="marque" name="marque" value="' . $row["Marque"] . '" required>';

                        echo '<button type="submit">Modifier</button>';
                    }
                }
            }

            // Traitement de la modification
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupération des données du formulaire
                $serviceNumber = $_POST["serviceNumber"];
                $carteGrise = $_POST["carteGrise"];
                $controleTechnique = $_POST["controleTechnique"];
                $typeVoiture = $_POST["typeVoiture"];
                $marque = $_POST["marque"];

                // Requête SQL pour mettre à jour la voiture
                $sql_update_car = "UPDATE car SET serviceNumber='$serviceNumber', carteGrise='$carteGrise', dateControle='$controleTechnique', TypeVoiture='$typeVoiture', Marque='$marque' WHERE idCar='$id'";

                if ($conn->query($sql_update_car) === TRUE) {
                    header("Location: gestVoiture.php");
                } else {
                    echo "<script>alert('Erreur lors de la modification de la voiture');</script>";
                }
            }
            $conn->close();
            ?>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
