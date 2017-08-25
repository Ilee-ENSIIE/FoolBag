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
<!DOCTYPE html>
<html>
<head>
    <title>Recherche de Trajet</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css" />
</head>
<?php include 'conbanner.php'; ?>
<body>
    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Recherche de trajet</b></span></p>
    <div class="register">
<form method="POST" action="sear_path_result.php" id="sear_path" style="padding-bot:0em;">
    <div class="row">
        <div class="6u 12u(mobile)">
            <div class="form-group">
                <p style="text-align:center;"><label><i class="fa fa-home" aria-hidden="true"></i> - Ville de départ :</label></p>
                <p style="text-align:center;"><input list="departure" name="departure" autocomplete="off" value="<?php echo $_POST['departure']?>"></p>
                <datalist id="departure">
                <?php 
                if (!($dbconn=pg_connect("host=localhost dbname=BagTrip user=admin password=admin"))){
                    echo "Error! Connexion impossible";
                    die();
                }
                $sear_departure="SELECT DISTINCT departure FROM path ORDER BY departure";
                $req=pg_query($dbconn,$sear_departure) or die('Erreur SQL'.$sear_departure);
                while($data=pg_fetch_array($req)){
                    echo "\n\t\t<option name=".$data[0]." value=".$data[0].">";
                }
                ?>
                </datalist>
            </div>
        </div>
        <div class="6u 12u(mobile)">
            <div class="form-group">
                <p style="text-align:center;"><i class="fa fa-car" aria-hidden="true"></i> - Ville d'arrivée :</label></p>
                <p style="text-align:center;"><input list="arrival" name="arrival" autocomplete="off" value="<?php echo $_POST['arrival']?>"></p>
                <datalist id="arrival">
                <?php
                if (!($dbconn=pg_connect("host=localhost dbname=BagTrip user=admin password=admin"))){
                    echo "Error! Connexion impossible";
                    die();
                }
                $sear_arrival="SELECT DISTINCT arrival FROM path ORDER BY arrival";
                $req=pg_query($dbconn,$sear_arrival) or die('Erreur SQL'.$sear_arrival);
                while($data=pg_fetch_array($req)){
                echo "\n\t\t<option name=".$data[0]." value=".$data[0].">";
                }?>
                </datalist>
            </div>
        </div>
    </div>
    <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="recherche" style="font-size:16px;">Rechercher</button></p>
</form>
<?php
if (!($dbconn=pg_connect("host=localhost dbname=BagTrip user=admin password=admin"))){
    echo "Error! Connexion impossible";
    die();
}
if(isset($_POST)){
    if((empty($_POST['departure']))&&(empty($_POST['arrival']))){
        if(isset($_POST['recherche'])){
        echo "Vous devez remplir au moins l'un des champs de recherche<br>";
    }
    }
    else if (empty($_POST['departure'])){
        echo "<table class=\"default\"><thead><tr><th>Utilisateur</th><th>Ville de départ</th><th>Ville d'arrivée</th><th>Date</th><th>Régularité</th><th>Fréquence</th><th>Description</th><th>Prix</th></tr></thead></br>";
        $sear_path="SELECT username, departure, arrival, date, regular, frequency, description, price FROM path WHERE arrival='".$_POST['arrival']."' AND ((date>=CURRENT_DATE) OR regular IS TRUE)";
        $req=pg_query($dbconn,$sear_path) or die('SQL ERROR : '.$sear_path);
        while($data=pg_fetch_array($req, null, PGSQL_ASSOC)){
            echo "<tr>";
            /*foreach ($data as $val) {
                    echo "<td>".$val."</td>";
            }*/
            echo "<td><a href=\"perso.php?user=".$data['username']."\">".$data['username']."</a></td>";
            echo "<td>".$data['departure']."</td>";
            echo "<td>".$data['arrival']."</td>";
            echo "<td>".$data['date']."</td>";
            echo "<td>".$data['regular']."</td>";
            echo "<td>".$data['frequency']."</td>";
            echo "<td>".$data['description']."</td>";
            echo "<td>".$data['price']."</td>";
            
            
            
            echo "</tr></br>";
        }
        echo "</table>";
    }
    else if (empty($_POST['arrival'])){ 
        echo "<table class=\"default\"><thead><tr><th>Utilisateur</th><th>Ville de départ</th><th>Ville d'arrivée</th><th>Date</th><th>Régularité</th><th>Fréquence</th><th>Description</th><th>Prix</th></tr></thead></br>";
        $sear_path="SELECT username, departure, arrival, date, regular, frequency, description, price FROM path WHERE departure='".$_POST['departure']."'  AND ((date>=CURRENT_DATE) or regular IS TRUE)";
        $req=pg_query($dbconn,$sear_path) or die('SQL ERROR : '.$sear_path);
        while($data=pg_fetch_array($req, null, PGSQL_ASSOC)){
            echo "<tr>";
            // foreach ($data as $val) {
            //         echo "<td>".$val."</td>";
            // }
            echo "<td><a href=\"perso.php?user=".$data['username']."\">".$data['username']."</a></td>";
            echo "<td>".$data['departure']."</td>";
            echo "<td>".$data['arrival']."</td>";
            echo "<td>".$data['date']."</td>";
            echo "<td>".$data['regular']."</td>";
            echo "<td>".$data['frequency']."</td>";
            echo "<td>".$data['description']."</td>";
            echo "<td>".$data['price']."</td>";
            echo "</tr></br>";
        }
        echo "</table>";
    }
    else {
        echo "<table class=\"default\"><thead><tr><th>Utilisateur</th><th>Ville de départ</th><th>Ville d'arrivée</th><th>Date</th><th>Régularité</th><th>Fréquence</th><th>Description</th><th>Prix</th></tr></thead></br>";
        $sear_path="SELECT username, departure, arrival, date, regular, frequency, description, price FROM path WHERE arrival='".$_POST['arrival']."' AND departure='".$_POST['departure']."' AND ((date>=CURRENT_DATE) OR regular IS TRUE)";
        $req=pg_query($dbconn,$sear_path) or die('SQL ERROR : '.$sear_path);
        while($data=pg_fetch_array($req, null, PGSQL_ASSOC)){
            echo "<tr>";
            // foreach ($data as $val) {
            //         echo "<td>".$val."</td>";
            // }
            echo "<td><a href=\"perso.php?user=".$data['username']."\">".$data['username']."</a></td>";
            echo "<td>".$data['departure']."</td>";
            echo "<td>".$data['arrival']."</td>";
            echo "<td>".$data['date']."</td>";
            echo "<td>".$data['regular']."</td>";
            echo "<td>".$data['frequency']."</td>";
            echo "<td>".$data['description']."</td>";
            echo "<td>".$data['price']."</td>";
            echo "</tr></br>";
        }
        echo "</table>";
    }
    
}
?>
</div>
</body>
</html>