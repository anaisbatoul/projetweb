
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "admin@gmail.com" && $password == "root") {
        header("Location: admin.php");
        exit();
    }

    $sql = "SELECT * FROM User WHERE adresse='$email' AND motDePasse='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        header("Location: profil.php?id=" . $user['idUser']);
        exit();
    } else {
        $error_message = "Invalid email or password!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Connexion - Fleetprodrivers</title>
        <link rel="stylesheet" type="text/css" href="login.css">
    </head>
    <body>
        <menu>
            <nav>
                <table width="100%">
                    <tr>
                        <td>
                            <font color="#336699" size="20">Fleetprodrivers</font> 
                            <font size="5">Connexion</font>
                        </td>
                        <td width="5%">
                            <a href="index.html"> 
                                <img src="home.png" height="25" width="30"></img>
                            </a>
                        </td>
                    </tr>
                </table>
            </nav>
        </menu>
        <div class="login-box">
            <center><img src="car.png" height="25" width="30"></center>
            <h2>Welcome back</h2>
            <p>Log in to Fleetprodrivers</p>
            
            <form action="" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your email">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Your password">
                
                <input type="submit" value="Log In">
            </form>
            
            <?php 
            if(isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
            
            <p>You don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
        
    </body>
</html>
