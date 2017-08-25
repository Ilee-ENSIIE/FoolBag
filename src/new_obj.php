<?php
session_start();
if (isset($_POST['new_obj'])) {
    if (!empty($_POST['departure']) && !empty($_POST['arrival']) && !empty($_POST['price'])){
        if ($_POST['arrival'] == $_POST['departure']) {
            echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">Les villes de départ et d'arrivée doivent être différentes</span></div>\n</div>";
        }
        else {
            $usr = $_SESSION['username'];
            $dep = $_POST['departure'];
            $arr = $_POST['arrival'];
            $name = $_POST['name'];
            $wgt = $_POST['weight'];
            $sx = $_POST['size_x'];
            $sy = $_POST['size_y'];
            $sz = $_POST['size_z'];
            $dsc = $_POST['description'];
            $prc = $_POST['price'];
            $key = sha1('zehfkfz'.$usr.$name.$dep.$arr.'6tr4253dg');
            
            $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            $req = $bdd->prepare('SELECT objectkey FROM object WHERE objectkey = :key');
            $req->bindValue(':key',$key,PDO::PARAM_STR);
            $req->execute();
            $resultat = $req->fetch();
            if (isset($resultat['objectkey'])) {
                echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">  Vous avez déjà inscrit un objet similaire parmi vos trajets.</span></div>\n</div>";
            }
            
            else {
                $req = $bdd->prepare('INSERT INTO object VALUES (:key,:path,:dep,:arr, :usr,:name,:wgt,:sx,:sy,:sz,:desc,:price)');
                $req->bindValue(':key',$key,PDO::PARAM_STR);
                $req->bindValue(':path',NULL,PDO::PARAM_STR);
                $req->bindValue(':usr',$usr,PDO::PARAM_STR);
                $req->bindValue(':dep',$dep,PDO::PARAM_STR);
                $req->bindValue(':arr',$arr,PDO::PARAM_STR);
                $req->bindValue(':name',$name,PDO::PARAM_STR);
                $req->bindValue(':sx',$sx,PDO::PARAM_STR);
                $req->bindValue(':sy',$sy,PDO::PARAM_STR);
                $req->bindValue(':sz',$sz,PDO::PARAM_STR);
                $req->bindValue(':wgt',$wgt,PDO::PARAM_STR);
                $req->bindValue(':desc',$dsc,PDO::PARAM_STR);
                $req->bindValue(':price',$prc,PDO::PARAM_STR);
                $req->execute();
                echo "Cet objet a été correctement ajouté.";
                $req->closeCursor();
                header('Location: ./my_obj.php');
                exit();
                
            }
        }
    }
    else {
        echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">Vous avez oublié de remplir un champ.</span></div>\n</div>";
    }
}
?>

<!DOCTYPE HTML>
<html>
	<?php include 'conbanner.php' ?>
	<body>
	   <div class="register">
	        <form method="POST" class="well" action="./new_obj.php">
	            <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Annonce pour un nouveau colis</b></span></p>
	            <div class="row">
	            <div class="4u 12u(mobile)">
	            <div class="form-group">
	                <label><i class="fa fa-home" aria-hidden="true"></i> - Ville de départ :</label>
	                <input class="register_input" list="departure" name="departure" autocomplete="off" maxlength="40" placeholder="Saisissez la ville de départ">
	                <datalist id="departure">
	                    <?php
	                    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
                        $req = $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM object UNION SELECT arrival FROM object UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
                        $req->execute();
                        while($data = $req->fetch()){
                            echo "<option name=".$data[0]." value=".$data[0].">";
                        }
                        $req->closeCursor();
                        ?>
	                </datalist>
	            </div>
	            </div>
	            <div class="4u 12u(mobile)">
	            <div class="form-group">
	                <label><i class="fa fa-car" aria-hidden="true"></i> - Ville d'arrivée :</label>
	                <input class="register_input" list="arrival" name="arrival" autocomplete="off" maxlength="40" placeholder="Saisissez la ville de départ">
	                <datalist id="arrival">
	                    <?php
	                    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
                        $req = $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM object UNION SELECT arrival FROM object UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
                        $req->execute();
                        while($data = $req->fetch()){
                            echo "<option name=".$data[0]." value=".$data[0].">";
                        }
                        $req->closeCursor();
                        ?>
	                </datalist>
	            </div>
	            </div>
	            <div class="4u 12u(mobile)">
	                <div class="form-group">
	                <label><i class="fa fa-money" aria-hidden="true"></i> - Prix :</label>
	                <input class="register_input"  type="number" name="price" autocomplete="off" placeholder="Saisissez le prix du trajet">
	            </div>
	            </div>
	            </div>
	            <div class="form-group">
	                <label><i class="fa fa-shopping-basket" aria-hidden="true"></i> - Nom :</label>
	                <input class="register_input"  type="text" name="name" maxlength="1000" autocomplete="off" placeholder="Quel est cet objet?">
	            </div>
	            <div class="form-group">
	                <label><i class="fa fa-shopping-basket" aria-hidden="true"></i> - Description :</label>
	                <input class="register_input"  type="text" name="description" maxlength="1000" autocomplete="off" placeholder="Décrivez votre colis">
	            </div>
	            <div class="row">
	            <div class="4u 12u(mobile)">
                <div class="form-group">
	                <label><i class="fa fa-history" aria-hidden="true"></i> - Poids:</label>
	                <input class="register_input"  type="number" name="weight" autocomplete="off" placeholder="Saisissez le poids">
	            </div>
	            </div>
	            <div class="8u 12u(mobile)">
	            <div class="form-group"> 
	                <label><i class="fa fa-history" aria-hidden="true"></i> - Taille: </label>
	                <input class="register_input"  type="number" name="size_x" autocomplete="off">x
	                <input class="register_input"  type="number" name="size_y" autocomplete="off">x
	                <input class="register_input"  type="number" name="size_z" autocomplete="off">cm
	            </div>
	            </div>
	            </div>
	            </br>
    	            <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="new_obj" style="font-size:16px;">Ajouter cet objet à mes colis</button></p>
	        </form>
	   </div>
	   </br>
    </body>
</html>