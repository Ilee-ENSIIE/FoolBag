<?php
session_start();
function age($date)
{
  return (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
}
session_start();
if (!isset($_SESSION['username']) && !isset($_GET['user'])){
  header('Location: connexion.php');
  exit();
}
if (!empty($_GET['user'])) {
    $user=$_GET['user'];
    $personnel=0;
    if ($user==$_SESSION['username']){
        $personnel=1;
    }
}
else {
    $user =$_SESSION['username']; 
    $personnel = 1;
}
?>
<link rel="stylesheet" href="css/main.css" />
<?php include "conbanner.php";
$bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
if ($personnel){
    ?>
    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Votre profil</b></span></p></br>
    <?php $req = $bdd->prepare('SELECT username, name, firstname, gender, email, birth, tel_num, description FROM users WHERE username=:user');
    $req->bindValue(':user',$user,PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetch();?>
    <div class="row">
        <div class="4u 12u(mobile)">
            <p style="text-align:center"><b>Pseudo : </b> <?php echo $data['username']?></p>
        </div>
        <div class="4u 12u(mobile)">
            <p style="text-align:center"><b>Nom : </b>: <?php echo $data['name']?></p>
        </div>
        <div class="4u 12u(mobile)">
            <p style="text-align:center;"><b>Prénom : </b>: <?php echo $data['firstname']?></p>
        </div>
    </div>
    <div class="row">
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Sexe : </b> <?php echo $data['gender']?></p>
        </div>
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Age : </b> <?php echo age($data['birth'])?></p>
        </div>
    </div>
    <div class="row">
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Email : </b> <?php echo $data['email']?></p>
        </div>
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Numéro de téléphone : </b> <?php echo $data['tel_num']?></p>
        </div>
    </div>
    <div class="row">
        <div class="1u">
        </div>
        <div class="8u">
            <b>Description :</b><br>  <?php echo str_replace("\n", "<br/>", $data['description']);?>
        </div>
    </div>
    <form method="POST" action="./change.php">
        <p style="text-align:right; padding-right:120px;"><button class="btn" type="submit" style="font-size:16px;">Editer mon profil</button></p>
    </form>
    <?php pg_free_result($req);
}
else{ ?>
    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Profil de <?php echo $user;?></b></span></p></br>
    <?php
    $req = $bdd->prepare('SELECT username, name, firstname, gender, email, birth, tel_num, description, tel_visible FROM users WHERE username=:user');
    $req->bindValue(':user',$user,PDO::PARAM_STR);
    $req->execute();
    $data = $req->fetch();?>
    <div class="row">
        <div class="4u 12u(mobile)">
            <p style="text-align:center"><b>Pseudo : </b> <?php echo $data['username']?></p>
        </div>
        <div class="4u 12u(mobile)">
            <p style="text-align:center"><b>Nom : </b> <?php echo $data['name']?></p>
        </div>
        <div class="4u 12u(mobile)">
            <p style="text-align:center;"><b>Prénom : </b> <?php echo $data['firstname']?></p>
        </div>
    </div>
    <div class="row">
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Sexe : </b> <?php echo $data['gender']?></p>
        </div>
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Age : </b> <?php echo age($data['birth'])?></p>
        </div>
    </div>
    <div class="row">
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Email : </b> <?php echo $data['email']?></p>
        </div>
        <?php
        if ($_POST['tel_visible']==TRUE){?>
        <div class="6u 12u(mobile)">
            <p style="text-align:center;"><b>Numéro de téléphone : </b> <?php echo $data['tel_num']?></p>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="1u">
        </div>
        <div class="8u">
            <b>Description :</b><br>  <?php echo str_replace("\n", "<br/>", $data['description']);?>
        </div>
    </div>
    <form method="GET" action="star_rating.php">
        <input type="hidden" name="user" value ="<?php echo $user;?>">
        <p style="text-align:right; padding-right:120px;"><button class="btn btn-primary" type="submit" style="font-size:16px;">Noter les services de <?php echo $user;?></button></p>
    </form>
    <?php
    $req1 = $bdd->prepare('SELECT * FROM path WHERE username=:user');
    $req2 = $bdd->prepare('SELECT departure, arrival, date, description, price FROM path WHERE username=:user AND regular=FALSE ORDER BY date DESC');
    $req3 = $bdd->prepare('SELECT departure, arrival, frequency, description, price FROM path WHERE username=:user AND regular=TRUE ORDER BY date DESC');
    $req4 = $bdd->prepare('SELECT name, departure, arrival, weight, size_x, size_y, size_z FROM object WHERE username=:user');
    $req1->bindValue(':user',$user,PDO::PARAM_STR);
    $req2->bindValue(':user',$user,PDO::PARAM_STR);
    $req3->bindValue(':user',$user,PDO::PARAM_STR);
    $req4->bindValue(':user',$user,PDO::PARAM_STR);
    $req1->execute();
    if($thereispath=$req1->fetch()){
        ?>
        <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Ses voyages</b></span></p></br>
        <?php
        $req2->execute();
        if($punctual=$req2->fetch()){
            ?>
            <p style="padding-top:7px; padding-left:120px;"><span style="border: 1px solid; border-radius:5px; padding:5px; font-size:12px;"><b>Voyages ponctuels</b></span></p></br>
            <div class="register">
                <table class="default">
                    <tr>
                        <th>Ville de départ</th>
                        <th>Ville d'arrivée</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Prix</th>
                    </tr>
                    <tr>
                        <td><?php echo $punctual['departure'];?></td>
                        <td><?php echo $punctual['arrival'];?></td>
                        <td><?php echo $punctual['date'];?></td>
                        <td><?php echo $punctual['description'];?></td>
                        <td><?php echo $punctual['price'];?></td>
                    </tr>
                    <?php
                    while($punctual=$req2->fetch()){
                        ?>
                        <tr>
                            <td><?php echo $punctual['departure'];?></td>
                            <td><?php echo $punctual['arrival'];?></td>
                            <td><?php echo $punctual['date'];?></td>
                            <td><?php echo $punctual['description'];?></td>
                            <td><?php echo $punctual['price'];?></td>
                        </tr>
                        <?php
                    }
                ?>
                </table>
            </div>
            <?php
        }
        $req3->execute();
        if($regular=$req3->fetch()){
            ?>
            <p style="padding-top:7px; padding-left:120px; padding-bot:0px;"><span style="border: 1px solid; border-radius:5px; padding:5px; font-size:12px;"><b>Voyages réguliers</b></span></p></br>
            <div class="register">
                <table class="default">
                    <tr>
                        <th>Ville de départ</th>
                        <th>Ville d'arrivée</th>
                        <th>Fréquence</th>
                        <th>Description</th>
                        <th>Prix</th>
                    </tr>
                    <tr>
                        <td><?php echo $regular['departure'];?></td>
                        <td><?php echo $regular['arrival'];?></td>
                        <td><?php echo $regular['frequency'];?></td>
                        <td><?php echo $regular['description'];?></td>
                        <td><?php echo $regular['price'];?></td>
                    </tr>
                    <?php
                    while($regular=$req3->fetch()){
                        ?>
                        <tr>
                            <td><?php echo $regular['departure'];?></td>
                            <td><?php echo $regular['arrival'];?></td>
                            <td><?php echo $regular['date'];?></td>
                            <td><?php echo $regular['description'];?></td>
                            <td><?php echo $regular['price'];?></td>
                        </tr>
                        <?php
                    }
                ?>
                </table>
            </div>
            <?php
        }
    }
    $req4->execute();
    if($object=$req4->fetch()){
        ?>
        <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Ses objets</b></span></p></br>
        <div class="register">
            <table class="default">
                    <tr>
                        <th>Ville de départ</th>
                        <th>Ville d'arrivée</th>
                        <th>Nom</th>
                        <th>Poids (kg)</th>
                        <th>Volume (L)</th>
                        <th>Description</th>
                        <th>Prix</th>
                    </tr>
                    <tr>
                        <td><?php echo $object['departure'];?></td>
                        <td><?php echo $object['arrival'];?></td>
                        <td><?php echo $object['name'];?></td>
                        <td><?php echo $object['weight'];?></td>
                        <td><?php echo ($object['size_x']*$object['size_y']*$object['size_z'])*0.001;?></td>
                        <td><?php echo $object['description'];?></td>
                        <td><?php echo $object['price'];?></td>
                    </tr>
                    <?php
                    while($object=$req4->fetch()){
                        ?>
                        <tr>
                            <td><?php echo $object['departure'];?></td>
                            <td><?php echo $object['arrival'];?></td>
                            <td><?php echo $object['name'];?></td>
                            <td><?php echo $object['weight'];?></td>
                            <td><?php echo ($object['size_x']*$object['size_y']*$object['size_z'])*0.001;?></td>
                            <td><?php echo $object['description'];?></td>
                            <td><?php echo $object['price'];?></td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>
        <?php
    }
}?>