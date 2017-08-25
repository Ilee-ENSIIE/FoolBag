<?php

session_start();

if(!empty($_POST) OR !empty($_FILES))
{
    $_SESSION['sauvegarde'] = $_POST ;
    $_SESSION['sauvegardeFILES'] = $_FILES ;
    
    $fichierActuel = $_SERVER['PHP_SELF'] ;
    if(!empty($_SERVER['QUERY_STRING']))
    {
        $fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ;
    }
    
    header('Location: ' . $fichierActuel);
    exit;
}
if(isset($_SESSION['sauvegarde']))
{
    $_POST = $_SESSION['sauvegarde'] ;
    $_FILES = $_SESSION['sauvegardeFILES'] ;
    unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
}

?>
<?php 
session_start();
include 'dconbanner.php';
if (isset($_POST['sub'])){
$pseudo=$_POST['usrnm'];
// Hachage du mot de passe
$pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$_POST['pwd'].'e8gd5v32cxez8d5');

// Vérification des identifiants
$bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
$req = $bdd->prepare('SELECT username FROM users WHERE username = :pseudo AND passphrase = :pass');
$req->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
$req->bindValue(':pass',$pass_hache,PDO::PARAM_STR);
$req->execute();

$resultat = $req->fetch();
if (!$resultat)
{
    echo "<p style='padding-top:4px;text-align:center;font-size:12px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>Mauvais identifiant ou mot de passe</span></p>";
}
else
{
    session_start();
    $_SESSION['username'] = $resultat['username'];
    header('Location: connected.php');
    exit();
}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <div class="register">
<p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Page de connexion</b></span></p>
</br>
<form method="POST" action="connexion2.php" name="con">
    <div class="row">
        <div class="6u 12u(mobile)">
        <div class="form-group">
        <label><i class="fa fa-users" aria-hidden="true"></i> - Identifiant :</label>
        <input class="register_input"  type="text" name="usrnm" autocomplete="off"  maxlength="20" placeholder="Saisissez votre nom de compte" autofocus>
        </div>
        </div>
        <div class="6u 12u(mobile)">
        <div class="form-group">
            <label><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe :</label>
            <input class="register_input"  type="password" name="pwd"  maxlength="100" placeholder="Saisissez votre mot de passe">
        </div>
        </div>
    </div>
    </br>
    <p style="text-align:center;"><button class="btn btn-primary" type="submit" name="sub" style="font-size:16px;">Se connecter</button></p>
</form>
<a class="button" href="register.php" style="font-size:12px;">Vous n'êtes pas encore inscrit ?</a><br/>
</div>
</body>
</html>