<?php
// Vérifier si l'ID du user est passé dans l'URL
if(isset($_GET['id'])) {
    // Récupérer l'ID du user depuis l'URL
    $idUser = $_GET['id'];

    // Connexion à la base de données (à remplacer avec vos informations de connexion)
    $servername = "localhost"; 
    $username = "root"; 
    $password_db = ""; 
    $dbname = "carproject";
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparation de la requête SQL pour sélectionner les informations du user
    $sql = "SELECT * FROM user WHERE idUser = $idUser";

    // Exécution de la requête
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupération des données du user
        $row = $result->fetch_assoc();
        $firstName = $row["prenomUser"];
        $lastName = $row["nomUser"];
        $dateOfBirth = $row["dateNaissance"];
        $placeOfBirth = $row["lieuNaissance"];
        $email = $row["adresse"];
        $password = $row["motDePasse"];

        // Si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des nouvelles données du formulaire
            $newFirstName = $_POST["firstName"];
            $newLastName = $_POST["lastName"];
            $newDateOfBirth = $_POST["dateOfBirth"];
            $newPlaceOfBirth = $_POST["placeOfBirth"];
            $newEmail = $_POST["email"];
            $newPassword = $_POST["password"];

            // Préparation de la requête SQL d'update
            $updateSql = "UPDATE user SET prenomUser = '$newFirstName', nomUser = '$newLastName', dateNaissance = '$newDateOfBirth', lieuNaissance = '$newPlaceOfBirth', adresse = '$newEmail', motDePasse = '$newPassword' WHERE idUser = $idUser";

            // Exécution de la requête d'update
            if ($conn->query($updateSql) === TRUE) {
                // Redirection vers gestCompte.php
                header("Location: gestCompte.php");
                exit(); // Assure que le script s'arrête ici pour éviter tout affichage supplémentaire
            } else {
                echo "Erreur lors de la modification du compte conducteur: " . $conn->error;
            }
        }

        // Affichage du formulaire prérempli avec les données du user
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier un compte conducteur</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4; 
                }

                header {
                    background-color: #ffffff; /* Blanc */
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

                input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
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
                    <li><a href="admin.php">Home</a></li>
                    <li><a href="gestVoiture.php">Gestion des voitures</a></li>
                    <li><a href="gestMission.php">Gestion des missions</a></li>
                    <li><a href="gestCompte.php">Gestion des comptes drivers</a></li>
                </ul>
            </nav>

            <div class="container">
                <h2>Modifier un compte conducteur</h2>
                <form method="post">
                    <label for="firstName">Prénom</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required>

                    <label for="lastName">Nom</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required>

                    <label for="dateOfBirth">Date de naissance</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>" required>

                    <label for="placeOfBirth">Lieu de naissance</label>
                    <input type="text" id="placeOfBirth" name="placeOfBirth" value="<?php echo $placeOfBirth; ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>

                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>

                    <button type="submit">Modifier</button>
                </form>
            </div>

            <footer>
                <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
            </footer>
        </body>
        </html>

        <?php
    } else {
        echo "Aucun compte trouvé avec cet ID.";
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
} else {
    echo "ID du user non spécifié.";
}
?>
