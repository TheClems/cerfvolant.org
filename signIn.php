<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<form method="post">
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
require 'baseDeDonnee.php';

$email = $_POST['email'];
$username = $_POST['userName'];
$password = $_POST['passWord'];

session_start();
?>