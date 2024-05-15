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
            <li><a href="gestMission.php">Gestion des mission</a></li>
            <li><a href="gestCompte.php">Gestion des conducteurs</a></li>
        </ul>
    </nav>

    <div style="margin: 0 80px;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <h2>Liste des Missions</h2>
            <button onclick="location.href='ajouterMission.html'" style="margin-bottom: 20px; margin-top: 20px;">Ajouter une nouvelle mission</button>
        </div>

        <table>
            <tr>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Distance</th>
                <th>Prix</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td>01/05/2024</td>
                <td>05/05/2024</td>
                <td>500 km</td>
                <td>200 €</td>
                <td>Test1</td>
                <td>Toyota Camry</td>
                <td>
                    <button onclick="location.href='modifMission.html'" >Modifier</button>
                    <button>Supprimer</button>
                    <button>Voir plus</button>
                </td>
            </tr>
            
          
        </table>
    </div> 

    <footer>
        <p>&copy; 2024 Fleet and Mission Management System. All rights reserved.</p>
    </footer>
</body>
</html>
