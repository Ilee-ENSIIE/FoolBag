<?php
if (isset($_POST['update_path'])){
	    $newkey=sha1('zehfkfz'.$_SESSION['username'].$_POST['date'].$_POST['departure'].$_POST['arrival'].'6tr4253dg');
	    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	$req= $bdd->prepare('UPDATE path SET pathkey=:newkey, departure=:departure, regular=:regular, date=:date, arrival=:arrival, frequency=:frequency, description=:description, price=:price WHERE pathkey=:pathkey');
        $req->bindValue(':newkey',$newkey,PDO::PARAM_STR);
        $req->bindValue(':departure',$_POST['departure'],PDO::PARAM_STR);
        $req->bindValue(':arrival',$_POST['arrival'],PDO::PARAM_STR);
        $req->bindValue(':date',$_POST['date'],PDO::PARAM_STR);
        $req->bindValue(':regular',$_POST['regular'],PDO::PARAM_STR);
        $req->bindValue(':frequency',$_POST['frequency'],PDO::PARAM_STR);
        $req->bindValue(':description',$_POST['description'],PDO::PARAM_STR);
        $req->bindValue(':price',$_POST['price'],PDO::PARAM_STR);
        $req->bindValue(':pathkey',$_POST['pathkey'],PDO::PARAM_STR);
        $req->execute();
        header('Location: my_path.php');
}
else if (isset($_POST['delete_path'])){
	    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	$req = $bdd->prepare('DELETE FROM path WHERE pathkey=:key');
    	$req->bindValue(':key',$_POST['pathkey'],PDO::PARAM_STR);
    	$req->execute();
    	header('Location: my_path.php');
}
else if (isset($_POST['back_path'])){
	    header('Location: my_path.php');
}
else if (isset($_POST['back_obj'])){
	    header('Location: my_obj.php');
}
else if (isset($_POST['delete_obj'])){
	    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	$req= $bdd->prepare('DELETE FROM object WHERE objectkey=:key');
    	$req->bindValue(':key',$_POST['objectkey'],PDO::PARAM_STR);
    	$req->execute();
    	header('Location: my_obj.php');
}
if (isset($_POST['update_obj'])){
	    $newkey=sha1('zehfkfz'.$_SESSION['username'].$_POST['name'].$_POST['departure'].$_POST['arrival'].'6tr4253dg');
	    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	$req= $bdd->prepare('UPDATE object SET objectkey=:newkey, departure=:departure, arrival=:arrival, name=:name, description=:description, weight=:weight, size_x=:sx, size_y=:sy, size_z=:sz, price=:price WHERE objectkey=:key');
    	$req->bindValue(':newkey',$newkey,PDO::PARAM_STR);
     	$req->bindValue(':departure',$_POST['departure'],PDO::PARAM_STR);
     	$req->bindValue(':arrival',$_POST['arrival'],PDO::PARAM_STR);
     	$req->bindValue(':name',$_POST['name'],PDO::PARAM_STR);
     	$req->bindValue(':weight',$_POST['weight'],PDO::PARAM_STR);
     	$req->bindValue(':sx',$_POST['size_x'],PDO::PARAM_STR);
     	$req->bindValue(':sy',$_POST['size_y'],PDO::PARAM_STR);
     	$req->bindValue(':sz',$_POST['size_z'],PDO::PARAM_STR);
     	$req->bindValue(':description',$_POST['description'],PDO::PARAM_STR);
     	$req->bindValue(':price',$_POST['price'],PDO::PARAM_STR);
    	$req->bindValue(':key',$_POST['objectkey'],PDO::PARAM_STR);
        $req->execute();
        header('Location: my_obj.php');
}
?>