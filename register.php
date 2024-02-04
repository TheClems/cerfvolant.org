


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join cerfvolant.org</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="conn-page.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <?php include("nav.php"); ?>

    <img src="logo.png" class="logo" alt="logo">
    <h1>Join cerfvolant.org</h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="updateCheckboxValues()">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="" required><br>
    
        <label for="userName">UserName</label>
        <input type="text" id="userName" name="userName" required><br>
    
        <label for="passWord">Password</label>
        <input type="password" id="passWord" name="passWord" required><br>
        
        <label for="profilephoto">Profile Photo</label>
        <input type="file" id="profilephoto" name="profilephoto" onchange="handleImageSelection()" required><br>
        
        <div id="chekbox">
            
        </div>

        <input type="submit" value="S'inscrire" class="submit">
    </form>

    <script type="text/javascript">
        function handleImageSelection() {
            var input = document.getElementById('profilephoto');

            if (input.files && input.files[0]) {
                var image = new Image();

                image.onload = function () {
                    var width = image.width;
                    var height = image.height;
                    if(width==height){
                        
                    }else if (width > height) {
                        var crop1 = "Cropper de droite";
                        var crop2 = "Cropper de gauche";

                        createCheckbox("checkbox1", "checkbox1", crop1);
                        createCheckbox("checkbox2", "checkbox2", crop2);
                    } else {
                        var crop3 = "Cropper d'en haut";
                        var crop4 = "Cropper d'en bas";

                        createCheckbox("checkbox3", "checkbox3", crop3);
                        createCheckbox("checkbox4", "checkbox4", crop4);
                    }
                };

                image.src = URL.createObjectURL(input.files[0]);
            }
        }

function createCheckbox(id, name, labelContent, labelClass) {
    var newCheckbox = document.createElement("input");
    newCheckbox.type = "checkbox";
    newCheckbox.id = id;
    newCheckbox.name = name;
    newCheckbox.required = false;

    var hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = name + "_hidden"; 
    hiddenInput.value = newCheckbox.checked ? "1" : "0";

    var label = document.createElement("label");
    label.innerHTML = labelContent;
    label.setAttribute("for", id);
    label.classList.add("labelchekbox");
    

    var container = document.getElementById("chekbox");
    container.appendChild(newCheckbox);
    container.appendChild(hiddenInput);
    container.appendChild(label);

    // Ajouter un saut de ligne après chaque case à cocher
    var lineBreak = document.createElement("br");
    container.appendChild(lineBreak);

    newCheckbox.addEventListener("change", function() {
        hiddenInput.value = this.checked ? "1" : "0";
    });
}


        function updateCheckboxValues() {
            document.querySelectorAll('[type="checkbox"]').forEach(function(checkbox) {
                document.querySelector('#' + checkbox.id + '_hidden').value = checkbox.checked ? "1" : "0";
            });
        }
    </script>
  
  
  
 <?php
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

require 'baseDeDonnee.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['userName'];
    $password = $_POST['passWord'];
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);  
    $nom = $_FILES['profilephoto']['tmp_name'];
    $extension = strtolower(pathinfo($_FILES['profilephoto']['name'], PATHINFO_EXTENSION));
    
    $checkbox1Value = isset($_POST['checkbox1_hidden']) ? $_POST['checkbox1_hidden'] : 0;
    $checkbox2Value = isset($_POST['checkbox2_hidden']) ? $_POST['checkbox2_hidden'] : 0;
    $checkbox3Value = isset($_POST['checkbox3_hidden']) ? $_POST['checkbox3_hidden'] : 0;
    $checkbox4Value = isset($_POST['checkbox4_hidden']) ? $_POST['checkbox4_hidden'] : 0;

    


    // Fonction pour générer une chaîne aléatoire
    function genererChaineAleatoire($longueur = 10)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++) {
            $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $chaineAleatoire;
    }

    // Vérifier si l'extension est valide
    $extensionsValides = ["jpeg", "jpg", "png", "gif", "svg"];
    if (in_array($extension, $extensionsValides)) {
        $nomFichier = genererChaineAleatoire(40);
        $nomDestination = './PhotoProfile/' . $nomFichier . "." . $extension;

        if (file_exists($nomDestination)) {
            $nomFichier = genererChaineAleatoire(40);
            $nomDestination = './PhotoProfile/' . $nomFichier . "." . $extension;
        }

        // Charger l'image à partir du fichier téléchargé
        $image = imagecreatefromstring(file_get_contents($nom));
        
        // Obtenir les dimensions de l'image d'origine
        // Obtenir les dimensions de l'image d'origine
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);
        
        // Déterminer la taille maximale pour le carré
        $maxSize = min($originalWidth, $originalHeight);
        if ($checkbox3Value) {
            $senscropy=$originalHeight-$maxSize;
            $senscropx=0;
        }
        if ($checkbox4Value) {
            $senscropy=0;
            $senscropx=0;

        }
        
        if ($checkbox1Value) {
            $senscropx=$originalWidth-$maxSize;
            $senscropy=0;
        }
        if ($checkbox2Value) {
            $senscropx=0;
            $senscropy=0;
        }
        // Définir les coordonnées de recadrage pour le bas de l'image
        $cropX = $senscropx;
        $cropY = $senscropy;
        
        // Créer une nouvelle image carrée
        $croppedImage = imagecrop($image, ['x' => $cropX, 'y' => $cropY, 'width' => $maxSize, 'height' => $maxSize]);

        
        // Sauvegarder l'image carrée
        imagejpeg($croppedImage, $nomDestination);

        // Libérer la mémoire
        imagedestroy($croppedImage);
        imagedestroy($image);

        // Insertion dans la base de données
        $sql = "INSERT INTO User(email, userName, passWord, Image) VALUES ('$email', '$username', '$passwordHashed', '$nomDestination')";
    
        if (mysqli_query($conn, $sql)) {
            // Succès
        } else {
            echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
        }

        // Suppression des utilisateurs avec email vide (ne semble pas nécessaire ici)

        sleep(2);

        // Récupération de l'utilisateur créé
        $sql10 = "SELECT * FROM User WHERE email = '".$email."'";
        if ($result = mysqli_query($conn, $sql10)) {
            $rows = mysqli_num_rows($result);

            if ($rows) {
                while ($row = mysqli_fetch_array($result)) {
                    $user = $row;
                }
            }
        } else {
            echo "Erreur : " . $sql10 . "<br>" . mysqli_error($conn);
        }

        if ($user) {
            // Vérification du mot de passe
            if (password_verify($password, $user['passWord'])) {
                $_SESSION['utilisateur'] = $user;
                // Redirection
                header('Location: register.php');
                exit();
            } else {
                echo "<p style='text-align:center;'>" ."Mot de passe incorrect". "</p>";
            }
        } else {
            echo "<p style='text-align:center;'>"."Adresse email ou mot de passe invalide". "</p>";
        }
    } else {
        echo ("Enregistrement non accepté, car votre photo de profil n'est pas au format souhaité (jpg, jpeg, png, gif, svg)");
    }
}

if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];

    echo "ID de l'utilisateur : $id <br>";
    echo "Nom d'utilisateur : $userName <br>";
    echo "Adresse e-mail : $email <br>";
    echo '<a href="deconnexion.php">Déconnexion</a>';
}
?>