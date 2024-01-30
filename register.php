<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join cerfvolant.org</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <img src="logo.png" class="logo" alt="logo">
    <h1>Join cerfvolant.org</h1>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="" required><br>
    
        <label for="userName">UserName</label>
        <input type="text" id="userName" name="userName" required><br>
    
        <label for="passWord">Password</label>
        <input type="passWord" id="passWord" name="passWord" required><br>
    
        <input type="submit" value="S'inscrire" class="submit">
    </form>
</body>
</html>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

require 'baseDeDonnee.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['userName'];
    $password = $_POST['passWord'];
    $sql = "INSERT INTO User(email, userName, passWord) VALUES ('$email', '$username', '$password')";
    
    if (mysqli_query($conn, $sql)) {
    }
    else {
        echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
    }
    
    $sql2 = "SELECT * FROM User WHERE email = ''";
    $delete = "DELETE FROM User WHERE email = ''";
    
    if ($result=mysqli_query($conn, $sql2)) {
        $rows = mysqli_num_rows($result);

        if ($rows) {
            while($row=mysqli_fetch_array($result)) {
                if (mysqli_query($conn, $delete)) {
                }
                else {
                    echo "Erreur : " . $delete . "<br>" . mysqli_error($conn);
                }
            }
        }
    } 
    else {
        echo "Erreur : " . $sql2 . "<br>" . mysqli_error($conn);
    }

    sleep(2);

    $sql10 = "SELECT * FROM User WHERE email = '".$email."'";

    if ($result=mysqli_query($conn, $sql10)) {
        $rows = mysqli_num_rows($result);

        if ($rows)
        {
            while($row=mysqli_fetch_array($result)) {
                $user = $row;
            }
        }
    } 
    else {
        echo "Erreur : " . $sql10 . "<br>" . mysqli_error($conn);
    }

    if ($user) {

        if ($password=$user['passWord']) {
            $_SESSION['utilisateur'] = $user;
            exit();
        } 
        else {
            echo "<p style='text-align:center;'>" ."Mot de passe incorrect". "</p>";
        }
    }
    else {
        echo  "<p style='text-align:center;'>"."Adresse email ou mot de passe invalide". "</p>";
    }

    header('Location: register.php');
}

if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];

    echo "ID de l'utilisateur : $id <br>";
    echo "Nom d'utilisateur : $userName <br>";
    echo "Adresse e-mail : $email <br>";
    echo '<a href="deconnexion.php">Déconnexion</a>';

}  
?>