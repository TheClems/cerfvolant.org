<?php
require 'baseDeDonnee.php';

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
    <a href="/chat.php?myID=<?php echo $id; ?>">
        Messages
    </a>
    <a href="/search.php?myID=<?php echo $id; ?>">
        Chercher
    </a>
    <a>
        <?php echo $userName; ?>
    </a>
</nav>