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
// Supprimer un utilisateur s'il y a une demande
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Requête SQL pour vérifier si l'ID du conducteur existe dans la table des missions
    $sql_check_mission = "SELECT idMission FROM mission WHERE idUser='$delete_id'";
    $result_check_mission = $conn->query($sql_check_mission);

    if ($result_check_mission->num_rows > 0) {
        // Si l'ID du conducteur existe dans la table des missions, afficher un message
        echo "<script>alert('Impossible de supprimer le conducteur car il est associé à une mission.');</script>";
    } else {
        // Si l'ID du conducteur n'existe pas dans la table des missions, supprimer le conducteur
        // Requête SQL pour supprimer les enregistrements dans la table usertypepermis associés au conducteur
        $sql_delete_usertypepermis = "DELETE FROM usertypepermis WHERE idUser='$delete_id'";

        if ($conn->query($sql_delete_usertypepermis) === TRUE) {
            // Ensuite, supprimer le conducteur de la table user
            $sql_delete_user = "DELETE FROM user WHERE idUser='$delete_id'";
            
            if ($conn->query($sql_delete_user) === TRUE) {
                echo "<script>alert('Conducteur supprimé avec succès');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression du conducteur');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors de la suppression des permis du conducteur');</script>";
        }
    }
}

// Requête SQL pour récupérer la liste des utilisateurs
$sql = "SELECT * FROM User";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des comptes drivers</title>
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
            <h2>Liste des Utilisateurs</h2>
            <button onclick="location.href='ajouterCompte.php'" style="margin-bottom: 20px; margin-top: 20px;">Ajouter un nouveau Conducteur</button>
        </div>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Afficher chaque utilisateur dans une ligne de tableau
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nomUser"] . "</td>";
                    echo "<td>" . $row["prenomUser"] . "</td>";
                    echo "<td>" . $row["adresse"] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"location.href='modifierCompte.php?id=" . $row["idUser"] . "'\">Modifier</button>";
                    echo "<button onclick=\"if(confirm('Voulez-vous vraiment supprimer cet utilisateur ?')){window.location.href='gestCompte.php?delete_id=" . $row["idUser"] . "'}\">Supprimer</button>";
                    echo "<button onclick=\"location.href='infoCompte.php?id=" . $row["idUser"] . "'\">Voir plus</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucun utilisateur trouvé.</td></tr>";
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
