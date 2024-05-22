<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Fond gris clair */
        }

        header {
            background-color: #ffffff; /* Bleu */
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
            color: #ffffff; /* Blanc */
            text-decoration: none;
        }

        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .summary {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            width: calc(33.33% - 20px);
            margin-bottom: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
            display: flex; /* Pour aligner l'icône et le texte horizontalement */
            align-items: center; /* Pour aligner l'icône et le texte verticalement */
        }

        .value {
    font-size: 20px;
    color: #336699;
    margin-left: 20px; /* Ajout de l'espace à gauche */
}


        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
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
            margin-top: 30px; /* Espace entre le contenu et le pied de page */
            padding: 20px;
            background-color: #336699; /* Bleu */
            color: #ffffff; /* Blanc */
            width: 100%;
            position: fixed;
            bottom: 0;
        }

        .card img {
            width: 70px; /* Largeur de l'icône */
            height: auto; /* Hauteur automatique pour garder les proportions */
            border-radius: 50%; /* Pour un effet arrondi */
            margin-right: 10px; /* Espace entre l'icône et le texte */
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
            <li><a href="gestCompte.php">Gestion des comptes drivers</a></li>
            <li><a href="gestVoiture.php">Gestion des voitures</a></li>
            <li><a href="gestMission.php">Gestion des missions</a></li>
        </ul>
    </nav>
    <div class="dashboard">
        <h1>Tableau de Bord </h1>
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
                    ?>
        <div class="summary">
        <div class="card">
                <h2>
                <img src="report.png" alt="Icone rapport"> 
                Nombre de Rapport</h2>
                <div class="value">
                    <?php
                    // Requête SQL pour compter le nombre de rapports
                    $sql = "SELECT COUNT(*) AS total FROM rapport";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["total"];
                    ?>
                </div>
            </div>
            
            <div class="card">
                <a href="gestRapport.php"><h2>Voir les rapports recus </h2></a>
            </div>
            <div class="card">
                <h2>
                <img src="driver.png" alt="Icone driver"> 
                Nombre de Conducteurs </h2>
                <div class="value">
                    <?php

                    // Requête SQL pour compter le nombre de conducteurs
                    $sql = "SELECT COUNT(*) AS total FROM User";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["total"];
                    ?>
                </div>
            </div>
         
            <div class="card">
                <h2>
                <img src="car.png" alt="Icone car"> 
                Nombre de Vehicules</h2>
                <div class="value">
                    <?php
                    // Requête SQL pour compter le nombre de véhicules
                    $sql = "SELECT COUNT(*) AS total FROM car";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["total"];
                    ?>
                </div>
            </div>
            <div class="card">
                <h2>
                <img src="target.png" alt="Icone target"> 
                Nombre de Mission accomplie</h2>
                <div class="value">
                    <?php
                    // Requête SQL pour compter le nombre de missions accomplies
                    $sql = "SELECT COUNT(*) AS total FROM Mission WHERE Etat='Terminée'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["total"];
                    ?>
                </div>
            </div>
            <div class="card">
            <h2>
                <img src="failed.png" alt="Icone mission non accomplie">
                 Nombre de Mission non accomplie</h2> 
                <div class="value">
                    <?php
                    // Requête SQL pour compter le nombre de missions non accomplies
                    $sql = "SELECT COUNT(*) AS total FROM Mission WHERE Etat='En cours'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row["total"];
                    ?>
                </div>
            </div>
            
           
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>

   
</body>
</html>
