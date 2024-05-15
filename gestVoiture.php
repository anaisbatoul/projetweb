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
// Supprimer une voiture si l'ID est passé en paramètre
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Requête SQL pour vérifier si l'ID de la voiture existe dans la table des missions
    $sql_check_mission = "SELECT idMission FROM mission WHERE idCar='$delete_id'";
    $result_check_mission = $conn->query($sql_check_mission);

    if ($result_check_mission->num_rows > 0) {
        // Si l'ID de la voiture existe dans la table des missions, afficher un message
        echo "<script>alert('Impossible de supprimer la voiture car elle est associée à une mission.');</script>";
    } else {
        // Si l'ID de la voiture n'existe pas dans la table des missions, supprimer la voiture
        // Requête SQL pour supprimer les enregistrements dans la table des missions associées à la voiture
        $sql_delete_mission = "DELETE FROM mission WHERE idCar='$delete_id'";

        if ($conn->query($sql_delete_mission) === TRUE) {
            // Ensuite, supprimer la voiture de la table car
            $sql_delete_car = "DELETE FROM car WHERE idCar='$delete_id'";
            
            if ($conn->query($sql_delete_car) === TRUE) {
                echo "<script>alert('Voiture supprimée avec succès');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression de la voiture');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors de la suppression des missions associées à la voiture');</script>";
        }
    }
}


// Requête SQL pour récupérer la liste des voitures
$sql = "SELECT * FROM car";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des voitures</title>
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
            <li><a href="gestMission.php">Gestion des mission</a></li>
            <li><a href="gestCompte.php">Gestion des conducteurs</a></li>
        </ul>
    </nav>

    <div style="margin: 0 80px;"> 
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <h2>Liste des Voitures</h2>
            <button onclick="location.href='ajouterVoiture.php'" style="margin-bottom: 20px; margin-top: 20px;">Ajouter une nouvelle voiture</button>
        </div>

        <table>
            <tr>
                <th>Service Number</th>
                <th>Carte Grise</th>
                <th>Contrôle Technique</th>
                <th>Type de Voiture</th>
                <th>Marque</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["serviceNumber"] . "</td>";
                    echo "<td>" . $row["carteGrise"] . "</td>";
                    echo "<td>" . $row["dateControle"] . "</td>";
                    echo "<td>" . $row["TypeVoiture"] . "</td>";
                    echo "<td>" . $row["Marque"] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"location.href='modifVoiture.php?id=" . $row["idCar"] . "'\">Modifier</button>";
                    echo " <button onclick=\"if(confirm('Voulez-vous vraiment supprimer cette voiture ?')){window.location.href='gestVoiture.php?delete_id=" . $row["idCar"] . "'}\">Supprimer</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucune voiture trouvée.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        
    </div> 

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
