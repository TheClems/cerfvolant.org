<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'baseDeDonnee.php';
session_start();

$recipientID = $_GET['recipientID'];
$myID = $_GET['myID'];

if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];
} 
// Retrieve and combine messages from both directions, sorted by idMSG
$recuperemessage = "SELECT * FROM messages  
                    WHERE (idDest = '$myID' AND idAuthor = '$recipientID')
                    OR (idDest = '$recipientID' AND idAuthor = '$myID')
                    ORDER BY idMSG ASC";

if ($result=mysqli_query($conn, $recuperemessage)) {
    $rows = mysqli_num_rows($result);
                    
    if ($rows) {
        while($row=mysqli_fetch_array($result)) {
            if($row['idAuthor']==$myID){
                                echo    "<li class='spacing'></li>
                            <li class='message'>
                                <div class='message-bubble'>
                                    <div class='message-text'>
                                        <p>". $row['MSG']."</p>                                    
                                    </div>
                                </div>
                            </li>";
            }
            else {
                echo    "<li class='spacing'></li>
                            <li class='message--friend'>
                                <div class='message-bubble'>
                                    <div class='message-text'>
                                        <p>". $row['MSG']."</p>
                                    </div>
                                </div>
                            </li>";
            }
        }
    }
} 
else {
    echo "Erreur : " . $recuperemessage . "<br>" . mysqli_error($conn);
}
?>


