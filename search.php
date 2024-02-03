<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="chat.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Chercher</title>
</head>
    <?php include("nav.php"); ?>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


require 'baseDeDonnee.php';

if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];
}else{
    header("Location: login.php");
    exit(); // Ensure script stops execution after the redirect

} 

$ID_URL = isset($_GET['myID']) ? $_GET['myID'] : null;

if($ID_URL<>$id){
    header("Location:search.php?myID=".$id);
}
$sql = "SELECT * FROM User";
if ($result=mysqli_query($conn, $sql)) {
      $rows = mysqli_num_rows($result);

    if ($rows) {
        while($row=mysqli_fetch_array($result)) {
            $recipient_id_search = $row['id'];
            echo '<a style="display: flex;margin: 2vw 0 2vw;font-size:1.5vw;width: 15vw;align-items:center;padding: 1vw;color: white;font-family:Arial;text-decoration: none;border-radius: 1vw;background-color: #434343;" href="chat.php?myID=' . $id . '&amp;recipientID=' . $row['id'] . '">'."<img style='width:3vw; border-radius:50%;margin-right:1vw' src='".$row['Image']."' />" . $row['userName'] ."<br>". '</a>';

        }
    }
} 
else {
    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
}


?>