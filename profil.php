<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <header style="width: 100%; margin-bottom: 20px;">
        <nav>
            <table width="100%">
                <tr>
                    <td style="vertical-align: middle;">
                        <h1 style="margin: 0; text-align: left;">Fleetprodrivers</h1>
                        <h2 style="margin: 0; font-size: 24px;">Profil</h2>
                    </td>
                    <td width="5%">
                        <a href="index.php">Deconnexion</a>
                    </td>
                </tr>
            </table>
        </nav>
    </header>

    <div class="container">
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

$userId = ""; // Initialisation de $userId

if(isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Requête SQL pour récupérer les informations de l'utilisateur
    $sql = "SELECT * FROM User WHERE idUser='$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='profile-info'>";
            echo "<img src='user.png' alt='Driver Photo' width='150'>";
            echo "<p><strong>Nom Prénom:</strong> " . $row['prenomUser'] . " " . $row['nomUser'] . "</p>";
            echo "<p><strong>Date de Naissance:</strong> " . $row['dateNaissance'] . "</p>";
            echo "<p><strong>Lieu de naissance:</strong> " . $row['lieuNaissance'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "Aucun utilisateur trouvé.";
    }
} else {
    if(isset($_POST['idUser'])) {
        $userId = $_POST['idUser'];
    } else {
        echo "Aucun utilisateur sélectionné.";
        exit(); // Si aucun utilisateur n'est sélectionné, on arrête l'exécution du reste du code.
    }
}
?>

        <div class="mission">
            <?php
            // Requête SQL pour récupérer les missions en cours de l'utilisateur
            $sql = "SELECT * FROM Mission WHERE idUser='$userId' AND Etat='En cours'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>";
                echo "<th colspan='2'>Mission non accomplie</th>";
                echo "</tr>";
                echo "<td>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<input type='checkbox' id='mission" . $row['idMission'] . "'>";
                    echo "<label for='mission" . $row['idMission'] . "'>" . $row['idMission'] . " - Voir Plus de Détails</label>";
                    echo "<div class='mission-details'>";
                    echo "<p><strong>Date de Départ:</strong> " . $row['DateDebut'] . "</p>";
                    echo "<p><strong>Date d'Arrivée:</strong> " . $row['DateFin'] . "</p>";
                    echo "<p><strong>Prix:</strong> $" . $row['Prix'] . "</p>";
                    echo "<p><strong>Distance:</strong> " . $row['Distance'] . " km</p>";
                    echo "<p><strong>Voiture:</strong> " . $row['idCar'] . "</p>";
                    echo "</div>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "</td>";
                echo "</table>";
            } else {
                echo "Aucune mission trouvée.";
            }
            ?>
        </div>

        <table>
            <tr>
                <th colspan="2">Plus d'Information</th>
            </tr>
           
            <tr>
                <?php
                $sql = "SELECT * FROM Mission WHERE idUser='$userId' AND Etat='Terminée'";
                $result = $conn->query($sql);

                $missions_accomplies = $result->num_rows;
                ?>
                <td>Total des Missions Accomplies</td>
                <td><?php echo $missions_accomplies; ?></td>
            </tr>

            <tr>
                <?php
                $sql = "SELECT * FROM usertypepermis WHERE idUser='$userId' ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<td colspan='2'>";
                    echo "<strong>Licences de Conduite</strong><br>";
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        $idPermis = $row['idPermis'];
                        // Requête SQL pour récupérer le type de permis
                        $permis_sql = "SELECT * FROM typepermis WHERE idPermis='$idPermis'";
                        $permis_result = $conn->query($permis_sql);
                        if ($permis_result->num_rows > 0) {
                            $permis_row = $permis_result->fetch_assoc();
                            echo "<li>" . $permis_row['typepermis'] . "</li>";
                        }
                    }
                    echo "</ul>";
                    echo "</td>";
                } else {
                    echo "<td colspan='2'>Aucune licence de conduite trouvée.</td>";
                }
                ?>
            </tr>

            <tr>
                <td colspan="2">
                    <strong>Historique des Missions Accomplies:</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <ul>
                    <?php
                    $sql = "SELECT * FROM Mission WHERE idUser='$userId' AND Etat='Terminée'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>";
                            echo "<input type='checkbox' id='mission" . $row['idMission'] .  "'>";
                            echo "<label class='historique-mission' for='mission" . $row['idMission'] . "'>Mission " . $row['idMission'] . " - Voir Plus de Détails</label>";
                            echo "<div class='mission-details'>";
                            echo "<p><strong>Date de Départ:</strong> " . $row['DateDebut'] . "</p>";
                            echo "<p><strong>Date d'Arrivée:</strong> " . $row['DateFin'] . "</p>";
                            echo "<p><strong>Prix:</strong> $" . $row['Prix'] . "</p>";
                            echo "<p><strong>Distance:</strong> " . $row['Distance'] . " km</p>";
                            echo "<p><strong>Voiture:</strong> " . $row['idCar'] . "</p>";
                            echo "</div>";
                            echo "</li>";
                        }
                    } else {
                        echo "<li>Aucune mission trouvée.</li>";
                    }
                ?>

                    </ul>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <div class="comment-box">
                        <h2>Rapport</h2>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Vérifie si le formulaire a été soumis
                            $rapport = $_POST["rapport"];
                            $idUser = $_POST["idUser"];

                            // Requête SQL pour insérer le rapport
                            $sql_insert = "INSERT INTO rapport (idUser, rapport) VALUES ('$idUser', '$rapport')";

                            if ($conn->query($sql_insert) === TRUE) {
                                echo "<p style='color: green;'>Rapport envoyé avec succès.</p>";
                            } else {
                                echo "<p style='color: red;'>Erreur lors de l'envoi du rapport: " . $conn->error . "</p>";
                            }
                        }
                        ?>
                        <form method="post" action="">
                            <textarea name="rapport" placeholder="Entrez votre rapport ici"></textarea>
                            <input type="hidden" name="idUser" value="<?php echo $userId; ?>">
                            <button type="submit">Envoyer</button>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
