<?php
session_start();
if (isset($_POST['new_path'])) {
    if (!empty($_POST['departure']) && !empty($_POST['arrival']) && !empty($_POST['regular']) && !empty($_POST['price'])){
        if ($_POST['arrival'] == $_POST['departure']) {
            echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">Les villes de départ et d'arrivée doivent être différentes</span></div>\n</div>";
        }
        else {
            $usr = $_SESSION['username'];
            $dep = $_POST['departure'];
            $arr = $_POST['arrival'];
            $date = $_POST['date'];
            $reg = $_POST['regular'];
            $frq = $_POST['frequency'];
            $dsc = $_POST['description'];
            $prc = $_POST['price'];
            $key = sha1('zehfkfz'.$usr.$date.$dep.$arr.'6tr4253dg');
            
            $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
            $req = $bdd->prepare('SELECT pathkey FROM path WHERE pathkey = :key');
            $req->bindValue(':key',$key,PDO::PARAM_STR);
            $req->execute();
            $resultat = $req->fetch();
            if (isset($resultat['pathkey'])) {
                echo "<div class=\"row\">\n<div class=\"col-lg 4 col-lg-offset 2\"><span class=\"error-msg\">  Vous avez déjà inscrit un trajet similaire parmi vos trajets.</span></div>\n</div>";
            }
            
            else {
                $req = $bdd->prepare('INSERT INTO path VALUES (:key,:usr,:dep,:arr,:date,:reg,:freq,:desc,:price)');
                $req->bindValue(':key',$key,PDO::PARAM_STR);
                $req->bindValue(':usr',$usr,PDO::PARAM_STR);
                $req->bindValue(':dep',$dep,PDO::PARAM_STR);
                $req->bindValue(':arr',$arr,PDO::PARAM_STR);
                $req->bindValue(':date',$date,PDO::PARAM_STR);
                $req->bindValue(':reg',$reg,PDO::PARAM_STR);
                if($_POST['frequency']!=''){
                    $req->bindValue(':freq',$frq,PDO::PARAM_STR);
                }
                else{
                    $req->bindValue(':freq',PDO::PARAM_NULL,PDO::PARAM_STR);
                }
                $req->bindValue(':desc',$dsc,PDO::PARAM_STR);
                $req->bindValue(':price',$prc,PDO::PARAM_STR);
                $req->execute();
                echo "Ce trajet a été correctement ajouté.";
                $req->closeCursor();
                header('Location: ./my_path.php');
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
	<?php include 'conbanner.php'; ?>
	<body>
	   <div class="register">
	        <form method="POST" class="well" action="./new_path.php">
	             <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Création d'un nouveau trajet</b></span></p>
	            <div class="row" style="padding-bot:0px">
	            <div class="4u 12u(mobile)">
	            <div class="form-group">
	                <p style="text-align:center;"><label><i class="fa fa-home" aria-hidden="true"></i> - Ville de départ :</label></p>
	                <p style="text-align:center;"><input class="register_input" list="departure" name="departure" autocomplete="off" maxlength="40" placeholder="Saisissez la ville de départ"></p>
	                <datalist id="departure">
	                    <?php
	                    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
                        $req = $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
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
	                <p style="text-align:center;"><label><i class="fa fa-car" aria-hidden="true"></i> - Ville d'arrivée :</label></p>
	                <p style="text-align:center;"><input class="register_input" list="arrival" name="arrival" autocomplete="off" maxlength="40" placeholder="Saisissez la ville de départ"></p>
	                <datalist id="arrival">
	                    <?php
	                    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
                        $req = $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
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
	                <p style="text-align:center;"><label><i class="fa fa-money" aria-hidden="true"></i> - Prix :</label></p>
	                <p style="text-align:center;"><input class="register_input"  type="number" name="price" autocomplete="off" placeholder="Saisissez le prix du trajet"></p>
	            </div>
	            </div>
	            </div>
	            <div class="row" style="padding-bot:0px">
	            <div class="4u 12u(mobile)">
	            <div class="form-group">
	                <p style="text-align:center;"><label><i class="fa fa-calendar" aria-hidden="true"></i> - Date :</label></p>
	                <p style="text-align:center;"><input class="register_input"  type="date" name="date" autocomplete="off" placeholder="Saisissez la date du départ"></p>
	            </div>
	            </div>
	            <div class="4u 12u(mobile)">
	            <div class="form-group">
                    <p style="text-align:center;"><label><i class="fa fa-refresh" aria-hidden="true"></i> - Trajet régulier :</label></p>
                        <p style="text-align:center;"><input class="register_input"  type="radio" name="regular" value="f" checked>
                        Non
                        <input class="register_input"  type="radio" name="regular" value="t">
                        Oui</p>
                </div>
                </div>
                <div class="4u 12u(mobile)">
                <div class="form-group">
	                <p style="text-align:center;"><label><i class="fa fa-history" aria-hidden="true"></i> - Fréquence :</label></p>
	                <p style="text-align:center;"><input class="register_input"  type="number" name="frequency" autocomplete="off" placeholder="Saisissez la fréquence du trajet"></p>
	            </div>
	            </div>
	            </div>
	            <div class="row" style="padding-bot:0px">
	            <div class="12u">
                <div class="form-group">
	                <p style="text-align:center;"><label><i class="fa fa-shopping-basket" aria-hidden="true"></i> - Description :</label></p>
	                <p style="text-align:center;"><input class="register_input"  type="text" name="description" maxlength="1000" autocomplete="off" placeholder="Décrivez votre trajet"></p>
	            </div>
	            </div>
	            </div>
	            </br>
	            <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="new_path" style="font-size:16px;">Ajouter ce trajet à mes trajets</button></p>	        
	            </form>
	   </div>
	   </br>
    </body>
</html>