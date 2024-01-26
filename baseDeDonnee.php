<?php

$host = "localhost";
$userName = "";
$passWord = "";
$dbName = "";

$conn = mysqli_connect($host, $userName, $passWord, $dbname);
if (!$conn) {
    die("Echec de la connexion " . mysqli_connect_error());
}