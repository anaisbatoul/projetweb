<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une mission</title>
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
        <h2>Ajouter une nouvelle mission</h2>
        <form method="post">
            <label for="conducteur">Conducteur</label>
            <select id="conducteur" name="idUser" required>
                <option value="">Sélectionner un conducteur</option>
                <?php
                // Connexion à la base de données
                $conn = new mysqli("localhost", "root", "", "carproject");

                // Vérification de la connexion
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $conducteur_query = "SELECT * FROM user";
                $result = $conn->query($conducteur_query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["idUser"] . "'>" . $row["prenomUser"] . "</option>";
                    }
                }
                ?>
            </select>

            <label for="vehicule">Véhicule</label>
            <select id="vehicule" name="vehicule" required>
                <option value="">Sélectionner un véhicule</option>
                <?php
                $vehicule_query = "SELECT * FROM car";
                $result = $conn->query($vehicule_query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["idCar"] . "'>" . $row["TypeVoiture"] ." " . $row["Marque"] . "</option>";
                    }
                }
                $conn->close();
                ?>
            </select>

            <label for="dateDebut">Date de Début</label>
            <input type="date" id="dateDebut" name="dateDebut" required>

            <label for="dateFin">Date de Fin</label>
            <input type="date" id="dateFin" name="dateFin" required>

            <label for="distance">Distance</label>
            <input type="text" id="distance" name="distance" required>

            <label for="prix">Prix</label>
            <input type="number" id="prix" name="prix" step="0.01" min="0" required>

            <label for="etat">Etat</label>
            <select id="etat" name="etat" required>
                <option value="">Sélectionner un état</option>
                <option value="Terminée">Terminée</option>
                <option value="En cours">En cours</option>
                <option value="Annulée">Annulée</option>
            </select>

            <button type="submit">Ajouter</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérifier si les variables POST sont définies
            if(isset($_POST["idUser"], $_POST["vehicule"], $_POST["dateDebut"], $_POST["dateFin"], $_POST["distance"], $_POST["etat"], $_POST["prix"])){
                $conn = new mysqli("localhost", "root", "", "carproject");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $conducteur = $_POST["idUser"];
                $vehicule = $_POST["vehicule"];
                $dateDebut = $_POST["dateDebut"];
                $dateFin = $_POST["dateFin"];
                $distance = $_POST["distance"];
                $etat = $_POST["etat"];
                $prix = $_POST["prix"];

                // Préparer et exécuter la requête SQL
                $insert_query = $conn->prepare("INSERT INTO mission (idUser, idCar, DateDebut, DateFin, Distance, Etat, Prix) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insert_query->bind_param("iississ", $conducteur, $vehicule, $dateDebut, $dateFin, $distance, $etat, $prix);
                if ($insert_query->execute()) {
                    echo "<script>alert('Mission ajoutée avec succès');</script>";
                } else {
                    echo "<script>alert('Erreur lors de l\'ajout de la mission');</script>";
                }

                $conn->close();
            } else {
                echo "<script>alert('Veuillez remplir tous les champs');</script>";
            }
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
