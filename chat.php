

<?php
require 'baseDeDonnee.php';
session_start();

$MYID_URL = isset($_GET['myID']) ? $_GET['myID'] : null;
$RECIPIENTID_URL = isset($_GET['recipientID']) ? $_GET['recipientID'] : null;


if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];
} 

if ($id !== $MYID_URL) {
    header("Location: chat.php?myID=".$id."&recipientID=".$recipient_id_search);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="chat.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <title>Chat</title>
</head>
<body>
    <?php include("nav.php"); ?>

    <div class="split">
        <div class="contacts-bar">
        </div>
        <div class="chat">
            <ol class="messages-list" id="messages-list">
                
                <?php
        
                    // Retrieve and combine messages from both directions, sorted by idMSG
                    $recuperemessage = "SELECT * FROM messages  
                                        WHERE (idDest = '$id' AND idAuthor = '$RECIPIENTID_URL')
                                        OR (idDest ='$RECIPIENTID_URL' AND idAuthor = '$id')
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
                    
                                }else{
                    
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
                <input class="inp-msg" type="text" id="message" name="message">
                <button class="button-send" role="button" type="submit">Send</button>
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

<script>
    
setInterval(load_messages, 500);

function load_messages() {
    // Utilisation directe des valeurs PHP dans le script JavaScript
    var url = 'loadmessage.php?myID=<?php echo $MYID_URL; ?>&recipientID=<?php echo $RECIPIENTID_URL; ?>';

    // Chargez les messages en utilisant jQuery.load
    $('#messages-list').load(url);
}

    var chatContainer = document.getElementById("messages-list");
function scrollToBottom() {
  // Utilise setTimeout pour retarder l'exécution de la fonction
  setTimeout(function() {
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }, 0);
}
                
    scrollToBottom();

</script>
</html>

<?php

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
?>
