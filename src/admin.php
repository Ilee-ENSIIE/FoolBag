<?php session_start();
if(!$_SESSION['username']){
	header('Location : ./connexion2.php');
	exit();
}
if($_SESSION['username']!="admin"){
	header('Location : ./connected.php');
	exit();
}

include 'conbanner.php';
if(!empty($_POST)){
    if (isset($_POST['suppr_account'])){
        $user=$_POST['username'];
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('DELETE FROM path WHERE username=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM object WHERE username=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM star WHERE username=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM appreciation WHERE fstuser=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM appreciation WHERE snduser=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM users WHERE username=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
    }
    if (isset($_POST['suppr_appreciation'])){
        $user=$_POST['username'];
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('DELETE FROM appreciation WHERE fstuser=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare('DELETE FROM appreciation WHERE snduser=:user');
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->execute();
    }
    if (isset($_POST['change_pass'])){
        $user=$_POST['username'];
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $motdepasse = str_shuffle($char);
        $motdepasse = substr($motdepasse,0,8);
        echo $motdepasse;
        $motdepasse=sha1('i8uk5hj2nbeqg8d5w2'.$motdepasse.'e8gd5v32cxez8d5');
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare("UPDATE users SET passphrase =:mdp WHERE username=:user");
        $req->bindValue(':user',$user,PDO::PARAM_STR);
        $req->bindValue(':mdp',$motdepasse,PDO::PARAM_STR);
        $req->execute();
    }
};








$bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
$req = $bdd->prepare('SELECT username FROM users');
$req->execute();
echo '<form method="POST" action="admin.php"';
echo '<br/><br><br><input list="username" name="username">';
echo '<datalist id="username">';
while($data = $req->fetch()){
    echo "\n\t\t<option name=".$data[0]." value=".$data[0].">";
    }
echo '</datalist><br/>';
echo "<button class='btn btn-primary button' type='submit' name='suppr_account' style='font-size:12px;'>Supprimer le compte</button><br><button class='btn btn-primary button' type='submit' name='suppr_appreciation' style='font-size:12px;'>Supprimer les appreciations de cette personne</button><br/><button class='btn btn-primary button' type='submit' name='change_pass' style='font-size:12px;'>Changer le mot de passe de cette personne</button>";
echo "</form>";
?>


