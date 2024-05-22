<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rapports</title>
    <link rel="stylesheet" href="gestion.css">
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
            <li><a href="gestCompte.php">Gestion des conducteurs</a></li>
        </ul>
    </nav>

    <div style="margin: 0 80px;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <h2>Liste des Rapports</h2>
        </div>

        <table>
            <tr>
                <th>ID Rapport</th>
                <th>Nom du Conducteur</th>
                <th>Prénom du Conducteur</th>
                <th>Contenu du Rapport</th>
                <th>Actions</th>
            </tr>
         
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

            // Requête SQL pour récupérer les données de la table rapport avec le nom et prénom du conducteur
            $sql = "SELECT rapport.idRapport, user.nomUser, user.prenomUser, rapport.rapport 
                    FROM rapport 
                    INNER JOIN user ON rapport.idUser = user.idUser";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Afficher chaque rapport dans une ligne de tableau
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idRapport"] . "</td>";
                    echo "<td>" . $row["nomUser"] . "</td>";
                    echo "<td>" . $row["prenomUser"] . "</td>";
                    echo "<td>" . $row["rapport"] . "</td>";
                    echo "<td>
                            <form method='post' style='display: inline-block;'>
                                <input type='hidden' name='delete_id' value='" . $row['idRapport'] . "'>
                                <button type='submit' onclick=\"return confirm('Voulez-vous vraiment supprimer ce rapport ?');\">Supprimer</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Aucun rapport trouvé.</td></tr>";
            }
            $conn->close();
            ?>
        </table>

        <?php
        // Supprimer le rapport s'il y a une demande
        if (isset($_POST['delete_id']) && !empty($_POST['delete_id'])) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $delete_id = $_POST['delete_id'];
            $sql_delete_rapport = "DELETE FROM rapport WHERE idRapport='$delete_id'";
            
            if ($conn->query($sql_delete_rapport) === TRUE) {
                echo "<script>alert('Rapport supprimé avec succès');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression du rapport');</script>";
            }

            $conn->close();
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
