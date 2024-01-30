<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<form action="#" method="post">
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required><br>

    <label for="userName">Nom d'utilisateur :</label>
    <input type="text" id="userName" name="userName" required><br>

    <label for="passWord">Mot de passe :</label>
    <input type="passWord" id="passWord" name="passWord" required><br>

    <input type="submit" value="S'inscrire">
</form>
</body>
</html>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'baseDeDonnee.php';

$email = $_POST['email'];
$username = $_POST['userName'];
$password = $_POST['passWord'];

session_start();

$sql = "INSERT INTO User(email, userName, passWord) VALUES ('$email', '$username', '$password')";

if (mysqli_query($conn, $sql)) {
} else {
      echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
}


?>