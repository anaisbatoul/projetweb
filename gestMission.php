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
// Supprimer une mission s'il y a une demande
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql_delete_mission = "DELETE FROM mission WHERE idMission='$delete_id'";
    
    if ($conn->query($sql_delete_mission) === TRUE) {
        echo "<script>alert('Mission supprimée avec succès');</script>";
    } else {
        echo "<script>alert('Erreur lors de la suppression de la mission');</script>";
    }
} 

// Requête SQL pour récupérer la liste des missions avec le nom et le prénom du conducteur
$sql = "SELECT mission.*, user.nomUser, user.prenomUser FROM mission INNER JOIN user ON mission.idUser = user.idUser";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des missions</title>
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
            <h2>Liste des Missions</h2>
            <button onclick="location.href='ajouterMission.php'" style="margin-bottom: 20px; margin-top: 20px;">Ajouter une nouvelle mission</button>
        </div>

        <table>
            <tr>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Distance</th>
                <th>Prix</th>
                <th>Etat</th>
                <th>Véhicule</th>
                <th>Conducteur</th>
                <th>Actions</th>
            </tr>
         
            <?php
            if ($result->num_rows > 0) {
                // Afficher chaque mission dans une ligne de tableau
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["DateDebut"] . "</td>";
                    echo "<td>" . $row["DateFin"] . "</td>";
                    echo "<td>" . $row["Distance"] . "</td>";
                    echo "<td>" . $row["Prix"] . "</td>";
                    echo "<td>" . $row["Etat"] . "</td>";
                    echo "<td>" . $row["idCar"] . "</td>";
                    echo "<td>" . $row["prenomUser"] . " " . $row["nomUser"] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"location.href='modifMission.php?id=" . $row["idMission"] . "'\">Modifier</button>";
                    echo "<button onclick=\"if(confirm('Voulez-vous vraiment supprimer cette mission ?')){window.location.href='gestMission.php?delete_id=" . $row["idMission"] . "'}\">Supprimer</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Aucune mission trouvée.</td></tr>";
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
