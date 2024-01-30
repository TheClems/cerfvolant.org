<?php
session_start();
session_unset(); // Efface toutes les données de session
session_destroy(); // Détruit la session
header('Location: login.php'); // Redirige vers la page de connexion ou autre page souhaitée
exit();
?>
