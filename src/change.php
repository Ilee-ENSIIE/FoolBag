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
$emailErr = $email2Err = $passwordErr = $new_passwordErr = $new_password2Err = $emailpassErr = $tpassErr= $telErr = $descErr = $descpassErr ="";
$email2 = $email = $telnum =$emailpass = $password = $new_password = $new_password2 = $description = "";

  if (!isset($_POST["email"])) {
    $emailErr = "Veuillez remplir ce champ";
  } else {
    $email = test_input($_POST["email"]);
    $email =$_POST["email"];
  }
  
  if (!isset($_POST["email2"])) {
    $email2Err = "Veuillez remplir ce champ";
  } else {
    $email2 = test_input($_POST["email2"]);
    $email2 =$_POST["email2"];
  }
    
  if (!isset($_POST["psswrd"])) {
    $passwordErr = "Veuillez remplir ce champ";
  } else {
    $password = test_input($_POST["psswrd"]);
    $pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$password.'e8gd5v32cxez8d5');
  }
  
  if (!isset($_POST["epsswrd"])) {
    $emailpassErr = "Veuillez remplir ce champ";
  } else {
    $emailpass = test_input($_POST["epsswrd"]);
    $pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$emailpass.'e8gd5v32cxez8d5');
    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $req = $bdd->prepare('SELECT passphrase FROM users WHERE username = :pseudo');
    $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetch();
    if ($resultat['passphrase'] != $pass_hache)
    {
      $epasswordErr = "Mauvais mot de passe";
    }
   else
   {
     if ($email==$email2 && $email!=""){
       $req = $bdd->prepare('UPDATE users SET email = :mail WHERE username= :pseudo');
          $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
          $req->bindValue(':mail',$email,PDO::PARAM_STR);
          $req->execute();
     }
    }
  }
  
  if (!isset($_POST["nw_psswrd"])) {
    $new_passwordErr = "Veuillez remplir ce champ";
  } else {
    $new_password = test_input($_POST["nw_psswrd"]);
  }

  if (!isset($_POST["nw_psswrd2"])) {
    $new_password2Err = "Veuillez remplir ce champ";
  } 
  else {
    $new_password2 = test_input($_POST['nw_psswrd2']);
    if ((isset($_POST['nw_psswrd'])) && ((isset($_POST['psswrd'])) )){
      if ($new_password==$new_password2){
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('SELECT passphrase FROM users WHERE username = :pseudo');
        $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch();
        if ($resultat['passphrase'] != $pass_hache)
        {
          $passwordErr = "Mauvais mot de passe";
        }
        else
        {
          $new_pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$new_password.'e8gd5v32cxez8d5');
          $req = $bdd->prepare('UPDATE users SET passphrase = :nwpass WHERE username= :pseudo');
          $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
          $req->bindValue(':nwpass',$new_pass_hache,PDO::PARAM_STR);
          $req->execute() ;
        }
      }
      else{
        $new_password2Err=' Mot de passe non identique';
      }
    }
  }

 if (!isset($_POST["telnum"])) {
    $telErr = "Veuillez remplir ce champ";
  } else {
    $telnum = test_input($_POST["telnum"]);
  }

if (!isset($_POST["tpsswrd"])) {
    $tpassErr = "Veuillez remplir ce champ";
  } else {
    $telpass = test_input($_POST["tpsswrd"]);
    $pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$telpass.'e8gd5v32cxez8d5');
    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $req = $bdd->prepare('SELECT passphrase FROM users WHERE username = :pseudo');
    $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetch();
    if ($resultat['passphrase'] != $pass_hache)
    {
      $tpassErr = "Mauvais mot de passe";
    }
   else
   {
     if ($telnum!=""){
       $req = $bdd->prepare('UPDATE users SET tel_num = :telnum WHERE username= :pseudo');
          $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
          $req->bindValue(':telnum',$telnum,PDO::PARAM_STR);
          $req->execute();
     }
    }
  }
  
  
  if (!isset($_POST["description"])) {
    $descErr = "Veuillez remplir ce champ";
  } else {
    $description = test_input($_POST["description"]);
  }
  
  if (isset($_POST["telvis"])) {
    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $req = $bdd->prepare('UPDATE users SET tel_visible=:bool WHERE username = :pseudo');
    $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
    if($_POST['visible']=="oui"){
      $req->bindValue(':bool',TRUE,PDO::PARAM_STR);
    }
    else {
      $req->bindValue(':bool',"FALSE",PDO::PARAM_STR);
    }
    $req->execute();
  }
  
  if (!isset($_POST["descpsswrd"])) {
    $descpassErr = "Veuillez remplir ce champ";
  } else {
    $descpass = test_input($_POST["descpsswrd"]);
    $pass_hache = sha1('i8uk5hj2nbeqg8d5w2'.$descpass.'e8gd5v32cxez8d5');
    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $req = $bdd->prepare('SELECT passphrase FROM users WHERE username = :pseudo');
    $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
    $req->execute();
    $resultat = $req->fetch();
    if ($resultat['passphrase'] != $pass_hache)
    {
      $descpassErr = "Mauvais mot de passe";
    }
   else
   {
     if ($description!=""){
       $req = $bdd->prepare('UPDATE users SET description = :desc WHERE username= :pseudo');
          $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
          $req->bindValue(':desc',$description,PDO::PARAM_STR);
          $req->execute();
     }
    }
  }
  
  
// }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css" />
    <title>Compte</title>
</head>
<?php include'conbanner.php';?>
<body>
  <div class='register'>
<p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Edition de compte</b></span></p>
<br>
<div class="row">
  <div class="4u 12u(mobile)">
    <p style="text-align:center;"><button id="pass_button" class="change_button" style="font-size:16px;">Changement de mot de passe</button></p>
  </div>
  <div class="4u 12u(mobile)">
    <p style="text-align:center;"><button id="mail_button" class="change_button" style="font-size:16px;">Changement d'adresse mail</button></p>
  </div>
  <div class="4u 12u(mobile)">
    <p style="text-align:center;"><button id="desc_button" class="change_button" style="font-size:16px;">Changement de description</button></p>
  </div>
</div>
<div class="row">
  <div class="6u 12u(mobile)">
    <p style="text-align:center;"><button id="tel_button" class="change_button" style="font-size:16px;">Changement du numéro de téléphone</button></p>
  </div>
  <div class="6u 12u(mobile)">
    <p style="text-align:center;"><button id="tel_vis_button" class="change_button" style="font-size:16px;">Changer la visibilité du numéro de téléphone</button></p>
  </div>
</div>
  
<div id="passDiv">
    <form method="POST" action="change.php" >
    <div class="row">
    <div class="6u 12u(mobile)">
    <div class="form-group">
    <p style="text-align:center;"><label><i class="fa fa-lock" aria-hidden="true"></i> - Nouveau mot de passe :</label></p>
    <input type="password" name="nw_psswrd"/><?php if (isset($_POST['mdp']) && $new_passwordErr!="") { echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$new_passwordErr."</span></p>";} ?>  
    </div>
    </div>
    <div class="6u 12u(mobile)">
      <div class="form-group">
      <p style="text-align:center;"><i class="fa fa-lock" aria-hidden="true"></i> - Confirmation du nouveau mot de passe :</label></p>
      <input type="password" name="nw_psswrd2"/><?php if (isset($_POST['mdp']) && $new_password2Err!="") {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$new_password2Err."</span></p>"; } ?>  
      </div>
    </div>
    </div>
    <div class="row">
    <div class="12u">
      <div class="form-group">
        <p style="text-align:center;"><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe actuel :</label></p>
        <input type="password" name="psswrd"/> <?php if (isset($_POST['mdp']) && ($passwordErr != "")) {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$passwordErr."</span></p>"; } ?>
      </div>
    
    </div>
    </div>
    </br>
    <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="mdp" style="font-size:16px;">Changer de mot de passe</button></p>
    </form>
</div>

<div id="mailDiv">
<form method="POST" action="change.php" >
  <div class="row">
    <div class="6u 12u(mobile)">
      <div class="form-group">
        <p style="text-align:center;"><label><i class="fa fa-envelope-o" aria-hidden="true"></i> - Nouvelle adresse mail :</label></p>
        <input type="email" name="email"/><?php if (isset($_POST['mail']) && $emailErr!="") {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$emailErr."</span></p>";} ?>
      </div>
    </div>
    <div class="6u 12u(mobile)">
      <div class="form-group">
     <p style="text-align:center;"><label><i class="fa fa-envelope-o" aria-hidden="true"></i> - Confirmation de la nouvelle adresse mail :</label></p>
    <input type="email" name="email2"/><?php if (isset($_POST['mail']) && $email2Err!="") {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$email2Err."</span></p>";} ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="12u">
      <div class="form-group">
        <p style="text-align:center;"><label><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe :</label></p>
        <input type="password" name="epsswrd"/><?php if (isset($_POST['mail']) && $epassErr!="") { echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$epassErr."</span></p>";} ?>
      </div>
    </div>
  </div>
  </br>
    <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="mail" style="font-size:16px;">Changer d'adresse mail</button></p>
</form>
</div>

<div id="telDiv">
<form method="POST" action="change.php" >
  <div class="row">
    <div class="4u 12u(mobile)">
      <div class="form-group">
        <p><label><i class="fa fa-phone" aria-hidden="true"></i> - Nouveau numéro de téléphone :</label></p>
        <input type="number" name="telnum"/><?php if (isset($_POST['tel']) && $telErr!="") {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$telErr."</span></p>";} ?>
      </div>
    </div>
    <div class="8u 12u(mobile)">
      <div class="form-group">
        <p style="text-align:center;"><label><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe :</p></label>
        <input type="password" name="tpsswrd"/><?php if (isset($_POST['tel']) && $tpassErr!="" ) {echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$tpassErr."</span></p>";} ?>
      </div>
    </div>
  </div>
  </br>
   <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="tel" style="font-size:16px;">Changer de numéro de téléphone</button></p>
</form>
</div>



<div id="descDiv">
<form method="POST" action="change.php" >
  <div class="row">
    <div class="12u">
      <div class="form-group">
        <p><label><i class="fa fa-bars" aria-hidden="true"></i> - Description :</label></p>
        <textarea name="description" maxlength="400"></textarea>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="12u">
      <div class="form-group">
        <p><label><i class="fa fa-key" aria-hidden="true"></i> - Mot de passe :</label></p>
        <input type="password" name="descpsswrd"/><?php if (isset($_POST['desc']) && $descpassErr!="") { echo "<p style='padding-top:4px;text-align:center;font-size:20px;'><span style='border: 1px solid; border-radius:5px; padding:5px; border-color:red; color:red;'>".$descpassErr."</span></p>";} ?>
      </div>
    </div>
  </div>
  </br>
  <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="desc" style="font-size:16px;">Changer ma description</button></p>
</form>
</div>

<div id="telVisDiv">
<form method="POST" action="change.php">
  <div class="row">
    <div class="6u 12u(mobile)">
      <div class="form-group">
        <p><label><i class="fa fa-phone" aria-hidden="true"></i> - Votre numéro est visible aux autres utilisateurs :</label></p>
        <?php
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('SELECT tel_visible FROM users WHERE username=:user');
        $req->bindValue(':user',$_SESSION['username'],PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch();
        if ($data['tel_visible']==TRUE){
          ?>
          <input class="register_input"  type="radio" name="visible" value="oui" checked>
          Oui
          <input class="register_input"  type="radio" name="visible" value="non">
          Non
          <?php
        }
        else {
          ?>
          <input class="register_input"  type="radio" name="visible" value="oui">
          Oui
          <input class="register_input"  type="radio" name="visible" value="non" checked>
          Non
          <?php
        }
        ?>
        <br/>
        <input type="submit" name="telvis" value="Enregistrer les modifications"/>
      </div>
    </div>
  </div>
</form>
</div>

<script>
document.querySelector("#mailDiv").style.display="none";
document.querySelector("#passDiv").style.display="none";
document.querySelector("#telDiv").style.display="none";
document.querySelector("#descDiv").style.display="none";
document.querySelector("#telVisDiv").style.display="none";

document.querySelector("#mail_button").onclick = function() {
if (window.getComputedStyle(document.querySelector('#mailDiv')).display=='none'){
document.querySelector("#mailDiv").style.display="block";
document.querySelector("#passDiv").style.display="none";
document.querySelector("#telDiv").style.display="none";
document.querySelector("#descDiv").style.display="none";
document.querySelector("#telVisDiv").style.display="none";
} else {
document.querySelector("#mailDiv").style.display="none";
}
}

document.querySelector("#pass_button").onclick = function() {
if (window.getComputedStyle(document.querySelector('#passDiv')).display=='none'){
document.querySelector("#passDiv").style.display="block";
document.querySelector("#mailDiv").style.display="none";
document.querySelector("#telDiv").style.display="none";
document.querySelector("#descDiv").style.display="none";
document.querySelector("#telVisDiv").style.display="none";
} else {
document.querySelector("#passDiv").style.display="none";
}
}

document.querySelector("#tel_button").onclick = function() {
if (window.getComputedStyle(document.querySelector('#telDiv')).display=='none'){
document.querySelector("#telDiv").style.display="block";
document.querySelector("#mailDiv").style.display="none";
document.querySelector("#passDiv").style.display="none";
document.querySelector("#descDiv").style.display="none";
document.querySelector("#telVisDiv").style.display="none";
} else {
document.querySelector("#telDiv").style.display="none";
}
}

document.querySelector("#desc_button").onclick = function() {
if (window.getComputedStyle(document.querySelector('#descDiv')).display=='none'){
document.querySelector("#descDiv").style.display="block";
document.querySelector("#mailDiv").style.display="none";
document.querySelector("#passDiv").style.display="none";
document.querySelector("#telDiv").style.display="none";
document.querySelector("#telVisDiv").style.display="none";
} else {
document.querySelector("#descDiv").style.display="none";
}
}

document.querySelector("#tel_vis_button").onclick = function() {
if (window.getComputedStyle(document.querySelector('#telVisDiv')).display=='none'){
document.querySelector("#telVisDiv").style.display="block";
document.querySelector("#descDiv").style.display="none";
document.querySelector("#mailDiv").style.display="none";
document.querySelector("#passDiv").style.display="none";
document.querySelector("#telDiv").style.display="none";
} else {
document.querySelector("#telVisDiv").style.display="none";
}
}
</script>
</div>
</body>
</html>