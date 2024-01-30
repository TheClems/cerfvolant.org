<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
<form action="" method="post">
    <label for="user1">Nom d'utilisateur ou adresse email:</label>
    <input type="text" id="user1" name="user1" required><br>

    <label for="passWord">Mot de passe :</label>
    <input type="passWord" id="passWord" name="passWord" required><br>

    <input type="submit" value="Se connecter">
</form>
</body>
</html>

<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require 'baseDeDonnee.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user1'];
    $password = $_POST['passWord'];
   

    $sql = "SELECT * FROM User WHERE email = '".$username."'";

    if ($result=mysqli_query($conn, $sql)) {
        $rows = mysqli_num_rows($result);

        if ($rows)
        {
            while($row=mysqli_fetch_array($result))
            {
                $user = $row;
            }
        }
    } 
    else 
    {
        echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
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



}

if (isset($_SESSION['utilisateur'])) 
{
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