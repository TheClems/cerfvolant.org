

<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require 'baseDeDonnee.php';
session_start();
if (isset($_SESSION['utilisateur'])) {
    $utilisateur = $_SESSION['utilisateur'];
    $id = $utilisateur['id'];
    $userName = $utilisateur['userName'];
    $email = $utilisateur['email'];

}

$sql = "SELECT * FROM User WHERE id = '".$id."'";

if ($result=mysqli_query($conn, $sql)) {
    $rows = mysqli_num_rows($result);

    if ($rows) {
        while($row=mysqli_fetch_array($result)) {
            $id= $row['id'];
            $userName= $row['userName'];
            $Date= $row['Date'];
            $image=$row['Image'];
            $activeSince = date('Y-m-d H:i:s', strtotime($Date . ' + 1 hour'));


        }
    }
} 

      
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile cerfvolant.org</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="conn-page.css">
    <link rel="stylesheet" href="myProfile.css">

    
    
</head>
<body>
    <?php include("nav.php"); ?>

    <h1>Profil cerfvolant.org</h1>
    <img src="<?php echo $row['Image']; ?>"/>
    <img class="profile_image" src="<?php echo $image; ?>" />
    <div class="infos_profil">
        <h2><?php echo $userName; ?> #<?php echo $id; ?></h2>
        <p>Actif depuis : <?php echo $activeSince; ?></p>
    </div>

</body>
</html>