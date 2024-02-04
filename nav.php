<?php
require 'baseDeDonnee.php';

session_start();
$RECIPIENTID_URL =  $_GET['recipientID'];

if($RECIPIENTID_URL){
    $test=$RECIPIENTID_URL;
}else
{
    $test="null";
}
if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];

}  


?>

<link rel="stylesheet" href="nav.css">
<nav>
    <a>
        <img src="logo.png" class="nav-logo" alt="logo">
        CerfVolant.org
    </a>
    <a href="/chat.php?myID=<?php echo $id; ?>&recipientID=<?php echo $test; ?>">
        Messages
    </a>
    <a href="/search.php?myID=<?php echo $id; ?>">
        Chercher
    </a>
    <a href="/myProfil.php?ID=<?php echo $id; ?>">
        <?php echo $userName; ?>
    </a>
</nav>