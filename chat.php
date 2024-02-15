

<?php
require 'baseDeDonnee.php';
session_start();




if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];
}else{
    header("Location: login.php");
    exit(); 

} 

$MYID_URL = $_GET['myID'];
$RECIPIENTID_URL =  $_GET['recipientID'];
if ($id !== $MYID_URL) {
    header("Location: chat.php?myID=".$id."&recipientID=".$recipient_id_search);
    exit();
}
if($RECIPIENTID_URL==="" or !$RECIPIENTID_URL ){
    header("Location: search.php?myID=".$id);
    exit();

}

$message = isset($_POST['message']) ? $_POST['message'] : '';

$sql = "INSERT INTO messages(idAuthor, idDest, MSG) VALUES (?, ?, ?)";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iis", $MYID_URL, $RECIPIENTID_URL, $message);

    if (mysqli_stmt_execute($stmt)) {
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
    }
}


if($RECIPIENTID_URL==="null"){
    $barredesaisie="displayNone";
    $bouton="displayNone";
}else{
    $barredesaisie="inp-msg";
    $bouton="button-send";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="chat.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script-chat.js"></script>

    <title>Chat</title>
</head>
<body>
    <?php include("nav.php"); ?>

    <div class="split">
        <div class="contacts-bar" id="contacts-bar">
            
            <?php
            require 'baseDeDonnee.php';
            session_start();
            
            $test = 0;
            
            if (isset($_SESSION['utilisateur'])) {
                $utilisateur = $_SESSION['utilisateur'];
                $id = $utilisateur['id'];
                $userName = $utilisateur['userName'];
                $email = $utilisateur['email'];
            }
            
            $recuperemessage = "SELECT m.* FROM messages m
                                JOIN (
                                    SELECT idDest, MAX(temps_ajout) AS derniereDate
                                    FROM messages
                                    WHERE idAuthor = $id
                                    GROUP BY idDest
                                ) AS derniersMessages
                                ON m.idDest = derniersMessages.idDest
                                AND m.temps_ajout = derniersMessages.derniereDate
                                ORDER BY m.temps_ajout ASC";
            
            if ($result = mysqli_query($conn, $recuperemessage)) {
                $rows = mysqli_num_rows($result);
            
                if ($rows) {
                    $resultats = array(); 
            
                    while ($row = mysqli_fetch_array($result)) {
                        $idDest = $row['idDest'];
                        $date = $row['temps_ajout'];
            
                        $valeursUniques = array();
                        $valeursUniquesDate = array();
                    
                        if (!in_array($idDest, $valeursUniques)) {
                            $valeursUniques[] = $idDest;
                            $valeursUniquesDate[] = $date;
                    
                            $dateActuelle = date('Y-m-d H:i:s');
                            $timestamp = strtotime($dateActuelle . ' +1 hour');
                            $date2 = date('Y-m-d H:i:s', $timestamp);
                            $diffEnSecondes = strtotime($date2) - strtotime($date);
                            $diffFormatee = gmdate("H:i:s", $diffEnSecondes);
                    
                            $recuperemessage2 = "SELECT * FROM User WHERE id=" . $idDest;
                            if ($result2 = mysqli_query($conn, $recuperemessage2)) {
                                $rows2 = mysqli_num_rows($result2);
                    
                                if ($rows2) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $prenom = $row2['userName'];
                                        $resultats[$diffFormatee] = array('prenom' => $prenom, 'idDest' => $idDest);
                                    }
                                } else {
                                    echo "Aucun résultat trouvé dans la table User pour l'idDest : " . $idDest;
                                }
                    
                                mysqli_free_result($result2); 
                            } else {
                                echo "Erreur : " . $recuperemessage2 . "<br>" . mysqli_error($conn);
                            }
                        }
                    }
            
                    ksort($resultats);
            
                    foreach ($resultats as $diffFormatee => $info) {
                        echo "<br><a href='chat.php?myID=".$id."&recipientID=".$info['idDest']."' style='color:white;'>" . $info['prenom'] . ' - Différence formatée : ' . $diffFormatee . '</a><br>';
                    }
                }
                mysqli_free_result($result);
            } else {
                echo "Erreur : " . $recuperemessage . "<br>" . mysqli_error($conn);
            }
            ?>
            
            
        </div>
        <div class="chat">
            <ol class="messages-list" id="messages-list">
                
               <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                require 'baseDeDonnee.php';

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
            </ol>
            <form class="chat-input" method="POST" action="">
                <input class="<?php echo $barredesaisie; ?>" type="text" id="message" name="message" autofocus>
                <button class="<?php echo $bouton; ?>" role="button" type="submit">Send</button>
            </form>
        </div>
    </div>
    <div>
        <!--
        <?php echo "ID de l'utilisateur : $id <br>";echo "Nom d'utilisateur : $userName <br>";echo "Adresse e-mail : $email <br>";echo '<a href="deconnexion.php">Déconnexion</a>';
        ?>
        -->
    </div>
</body>



</html>

<script>

setInterval('load_messages()', 500);
setInterval('load_friends()', 500);

function load_messages(){
    $('#messages-list').load('loadmessage.php?myID=<?php echo $MYID_URL; ?>&recipientID=<?php echo $RECIPIENTID_URL; ?>');
    
}
function load_friends(){
    $('#contacts-bar').load('loadfriends.php');
    
}

var chatContainer = document.getElementById("#messages-list");

    function scrollToBottom() {
  const el = document.getElementById("messages-list");
    el.scrollTop = el.scrollHeight;
}


scrollToBottom()
</script>
