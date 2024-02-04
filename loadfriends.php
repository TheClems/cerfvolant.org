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
        
                    mysqli_free_result($result2); // Libérer la mémoire après avoir utilisé le résultat
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
