<?php
// Vérifier si un ID de mission est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: gestMission.php");
    exit();
}

$mission_id = $_GET['id'];

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carproject";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les détails de la mission à modifier
$sql_mission = "SELECT * FROM Mission WHERE idMission = $mission_id";
$result_mission = $conn->query($sql_mission);
if ($result_mission->num_rows <= 0) {
    echo "Mission non trouvée.";
    $conn->close();
    exit();
}
$mission = $result_mission->fetch_assoc();

// Récupérer les conducteurs
$sql_conducteurs = "SELECT * FROM user";
$result_conducteurs = $conn->query($sql_conducteurs);

// Récupérer les véhicules
$sql_vehicules = "SELECT * FROM car";
$result_vehicules = $conn->query($sql_vehicules);

// Traitement de la mise à jour de la mission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les variables POST sont définies
    if(isset($_POST["idUser"], $_POST["vehicule"], $_POST["dateDebut"], $_POST["dateFin"], $_POST["distance"], $_POST["etat"], $_POST["prix"])){
        $conducteur = $_POST["idUser"];
        $vehicule = $_POST["vehicule"];
        $dateDebut = $_POST["dateDebut"];
        $dateFin = $_POST["dateFin"];
        $distance = $_POST["distance"];
        $etat = $_POST["etat"];
        $prix = $_POST["prix"];

        // Préparer et exécuter la requête SQL de mise à jour
        $update_query = $conn->prepare("UPDATE Mission SET idUser=?, idCar=?, DateDebut=?, DateFin=?, Distance=?, Etat=?, Prix=? WHERE idMission=?");
        $update_query->bind_param("iissisdi", $conducteur, $vehicule, $dateDebut, $dateFin, $distance, $etat, $prix, $mission_id);
        if ($update_query->execute()) {
            echo "<script>alert('Mission mise à jour avec succès');</script>";
        } else {
            echo "<script>alert('Erreur lors de la mise à jour de la mission');</script>";
        }

        // Redirection vers gestMission.php
        header("Location: gestMission.php");
        exit();
    } else {
        echo "<script>alert('Veuillez remplir tous les champs');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une mission</title>
    <style>
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

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
            <li><a href="admin.php">Home</a></li>
            <li><a href="gestCompte.php">Gestion des comptes drivers</a></li>
            <li><a href="gestMission.php">Gestion des missions</a></li>
            <li><a href="gestVoiture.php">Gestion des voitures</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Modifier la mission</h2>
        <form method="post">
            <input type="hidden" name="mission_id" value="<?php echo $mission_id; ?>">

            <label for="conducteur">Conducteur</label>
            <select id="conducteur" name="idUser" required>
                <option value="">Sélectionner un conducteur</option>
                <?php
                if ($result_conducteurs->num_rows > 0) {
                    while ($row = $result_conducteurs->fetch_assoc()) {
                        $selected = ($mission['idUser'] == $row['idUser']) ? 'selected' : '';
                        echo "<option value='" . $row["idUser"] . "' $selected>" . $row["prenomUser"] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="vehicule">Véhicule</label>
            <select id="vehicule" name="vehicule" required>
                <option value="">Sélectionner un véhicule</option>
                <?php
                if ($result_vehicules->num_rows > 0) {
                    while ($row = $result_vehicules->fetch_assoc()) {
                        $selected = ($mission['idCar'] == $row['idCar']) ? 'selected' : '';
                        echo "<option value='" . $row["idCar"] . "' $selected>" . $row["TypeVoiture"] ." " . $row["Marque"] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="dateDebut">Date de Début</label>
            <input type="date" id="dateDebut" name="dateDebut" value="<?php echo $mission['DateDebut']; ?>" required>

            <label for="dateFin">Date de Fin</label>
            <input type="date" id="dateFin" name="dateFin" value="<?php echo $mission['DateFin']; ?>" required>

            <label for="distance">Distance</label>
            <input type="text" id="distance" name="distance" value="<?php echo $mission['Distance']; ?>" required>

            <label for="prix">Prix</label>
            <input type="number" id="prix" name="prix" step="0.01" min="0" value="<?php echo $mission['Prix']; ?>" required>

            <label for="etat">Etat</label>
            <select id="etat" name="etat" required>
                <option value="">Sélectionner un état</option>
                <option value="Terminée" <?php echo ($mission['Etat'] == 'Terminée') ? 'selected' : ''; ?>>Terminée</option>
                <option value="En cours" <?php echo ($mission['Etat'] == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                <option value="Annulée" <?php echo ($mission['Etat'] == 'Annulée') ? 'selected' : ''; ?>>Annulée</option>
            </select>

            <button type="submit">Modifier</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
