<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'baseDeDonnee.php';

session_start();
$id_url = "0";
if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];
    $id_url = $id;
    
    echo "ID de l'utilisateur : $id <br>";
    echo "Nom d'utilisateur : $userName <br>";
    echo "Adresse e-mail : $email <br>";
    echo '<a href="deconnexion.php">Déconnexion</a>';
    $chat = 'chat.php?myID='.$id;
    if (basename($_SERVER['PHP_SELF']) != $chat) {
        header("Location: chat.php?myID=$id");
        exit(); // Assurez-vous de terminer le script après la redirection
    }
} 


/*$user1 = "";
$sql = "SELECT * FROM messages WHERE idAuthor ='".$id."'";
if ($result=mysqli_query($conn, $sql)) {
      $rows = mysqli_num_rows($result);

    if ($rows) {
        while($row=mysqli_fetch_array($result)) {
            $user1 =$row['idDest'];
            
        }
    }
} 
else {
    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
}

$sql2 = "SELECT * FROM User WHERE id ='".$user1."'";
if ($result=mysqli_query($conn, $sql2)) {
      $rows = mysqli_num_rows($result);

    if ($rows) {
        while($row=mysqli_fetch_array($result)) {
            echo $row['userName'];
        }
    }
} 
else {
    echo "Erreur : " . $sql2 . "<br>" . mysqli_error($conn);
}
*/
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="chat.css">
    <title>Chat</title>
</head>
<body>
    <nav>
        <a>
            <img src="logo.png" class="nav-logo" alt="logo">
        </a>
        <a>
            CerfVolant.org
        </a>
        
        <a>
            Messages
        </a>
        <a>
            <?php echo $userName; ?>
        </a>
    </nav>
    <div class="split">
        <div class="contacts-bar">
        </div>
        <div class="chat">
            <div class="chat-history">
            </div>
            <form class="chat-input">
                <input class="inp-msg" type="text">

                <button class="button-send" role="button">Send</button>
            </form>
        </div>
    </div>
    <div>
        <?php     echo "ID de l'utilisateur : $id <br>";echo "Nom d'utilisateur : $userName <br>";echo "Adresse e-mail : $email <br>";echo '<a href="deconnexion.php">Déconnexion</a>';
 ?>
    </div>
</body>
</html>


