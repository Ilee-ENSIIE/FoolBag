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
if (isset($_POST['sub'])) {
    if (!empty($_POST['usrnm']) && !empty($_POST['mail']) && !empty($_POST['name']) && !empty($_POST['firstname']) && !empty($_POST['gender']) && !empty($_POST['pwd']) && !empty($_POST['pwd2'])) {
        if ($_POST['pwd'] != $_POST['pwd2']) {
            echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">Vous avez saisi deux mots de passe différents</span></div>\n</div>";
        }
        else {
            $usrnm = $_POST['usrnm'];
            $mail = $_POST['mail'];
            $name = $_POST['name'];
            $fname = $_POST['firstname'];
            $gnd = $_POST['gender'];
            $pwd = sha1('i8uk5hj2nbeqg8d5w2'.$_POST['pwd'].'e8gd5v32cxez8d5');
            $tel = $_POST['tel'];
            $birth = $_POST['birth'];
            
            $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            $req = $bdd->prepare('SELECT username FROM users WHERE username = :pseudo');
            $req->bindValue(':pseudo',$usrnm,PDO::PARAM_STR);
            $req->execute();
            $resultat = $req->fetch();
            
            $req = $bdd->prepare('SELECT username FROM users WHERE email = :mail');
            $req->bindValue(':mail',$mail,PDO::PARAM_STR);
            $req->execute();
            $resultat2 = $req->fetch();
            if (isset($resultat['username'])) {
                echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">  Ce pseudo existe déjà. Merci de recommencer</span></div>\n</div>";
            }
            elseif (isset($resultat2['username'])) {
                echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">  Cette adresse mail est déjà utilisé. Merci de recommencer</span></div>\n</div>";
            }
            else {
                $req = $bdd->prepare('INSERT INTO users VALUES (:pseudo,:pwd,:name,:fname,:gnd,:mail,:birth,:tel,:desc,FALSE)');
                $req->bindValue(':pseudo',$usrnm,PDO::PARAM_STR);
                $req->bindValue(':pwd',$pwd,PDO::PARAM_STR);
                $req->bindValue(':name',$name,PDO::PARAM_STR);
                $req->bindValue(':fname',$fname,PDO::PARAM_STR);
                $req->bindValue(':gnd',$gnd,PDO::PARAM_STR);
                $req->bindValue(':mail',$mail,PDO::PARAM_STR);
                $req->bindValue(':birth',$birth,PDO::PARAM_STR);
                $req->bindValue(':tel',$tel,PDO::PARAM_STR);
                $req->bindValue(':desc',PDO::PARAM_NULL,PDO::PARAM_STR);
                $req->execute();
                $req = $bdd->prepare('INSERT INTO star VALUES (:pseudo,NULL,0)');
                $req->bindValue(':pseudo',$usrnm,PDO::PARAM_STR);
                $req->execute();
                echo "Inscription réussie";
                header('Location: connexion2.php');
                exit();
            }
        }
    }
    else {
        echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">Vous avez oublié de remplir un champ.</span></div>\n</div>";
        //echo  $_POST['usrnm'].$_POST['mail']." name".$_POST['name']." fname".$_POST['firstname'].$_POST['gender'].$_POST['pwd'].$_POST['pwd2'].$_POST['tel'].$_POST['birth'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<?php include 'dconbanner.php' ?>
<body>
    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Formulaire d'inscription</b></span></p>
    <div class="register">
<form class="well" method="POST" action="./register.php" name="inscription">
    <div class="row">
        <div class="6u 12u(mobile)">
        <div class="form-group">
        <label><i class="fa fa-users" aria-hidden="true"></i> - Identifiant :</label>
        <input class="register_input"  type="text" name="usrnm" autocomplete="off"  maxlength="20" placeholder="Saisissez votre nom de compte" autofocus>
        </div>
        </div>
        <div class="6u 12u(mobile)">
        <div class="form-group">
        <label><i class="fa fa-envelope" aria-hidden="true"></i> - Mail :</label>
        <input class="register_input"  type="email" name="mail" autocomplete="on"  maxlength="100" placeholder="Saisissez votre adresse mail">
        </div>
        </div>
    </div>
    <div class="row">
        <div class="6u 12u(mobile)">
        <div class="form-group">
            <label><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe :</label>
            <input class="register_input"  type="password" name="pwd"  maxlength="100" placeholder="Saisissez votre mot de passe">
        </div>
        </div>
        <div class="6u 12u(mobile)">
        <div class="form-group">
            <label><i class="fa fa-key" aria-hidden="true"></i> - Confirmation de mot de passe :</label>
            <input class="register_input"  type="password" name="pwd2"  maxlength="100" placeholder="Confirmez votre mot de passe">
        </div>
        </div>
    </div>
    <div class="row">
    <div class="6u 12u(mobile)">
    <div class="form-group">
        <label><i class="fa fa-address-card-o" aria-hidden="true"></i> - Prénom :</label>
        <input class="register_input"  type="text" name="firstname" autocomplete="off"  maxlength="40" placeholder="Saisissez votre Prénom">
    </div>
    </div>
    <div class="6u 12u(mobile)">
    <div class="form-group">
        <label><i class="fa fa-address-card-o" aria-hidden="true"></i> - Nom :</label>
        <input class="register_input"  type="text" name="name" autocomplete="off"  maxlength="40" placeholder="Saisissez votre nom">
    </div>
    </div>
    </div>
    <div class="row">
    <div class="4u 12u(mobile)">
    <div class="form-group">
        <label><i class="fa fa-venus-mars" aria-hidden="true"></i> - Genre :</label>
            <input class="register_input"  type="radio" name="gender" value="H" checked>
            Homme
            <input class="register_input"  type="radio" name="gender" value="F">
            Femme 
            <input class="register_input"  type="radio" name="gender" value="A">
            Autre
    </div>
    </div>
    <div class="4u 12u(mobile)">
    <div class="form-group">
        <label><i class="fa fa-birthday-cake" aria-hidden="true"></i> - Date de naissance :</label>
        <input class="register_input"  type="date" name="birth">
    </div>
    </div>
    <div class="4u 12u(mobile)">
    <div class="form-group">
        <label><i class="fa fa-phone" aria-hidden="true"></i> - Numéro de téléphone :</label>
        <input class="register_input"  type="number" name="tel">
    </div>
    </div>
    </div>
    </br>
<p style="text-align:center;"><button class="btn btn-primary" type="submit" name="sub" style="font-size:16px;">S'inscrire</button></p>
</form>
</div>
</body>
</html>