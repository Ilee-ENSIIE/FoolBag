<!DOCTYPE html>
<html >
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
if (isset($_POST['submit'])){
  if (!isset($_POST['note']) OR !isset($_POST['username'])){
    header('Location: connected.php' );
    exit;
  }
  else{
    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $req = $bdd->prepare('INSERT INTO appreciation VALUES (:fstuser,:snduser,:note,:day,:titlecomm,:commentary)');
    $req->bindValue(':fstuser',$_POST['username'],PDO::PARAM_STR);
    $req->bindValue(':snduser',$_SESSION['username'],PDO::PARAM_STR);
    $req->bindValue(':note',$_POST['note'],PDO::PARAM_INT);
    $req->bindValue(':day',date("Y-m-d"),PDO::PARAM_STR);
    $req->bindValue(':titlecomm',$_POST['titlecomm'],PDO::PARAM_STR);
    $req->bindValue(':commentary',$_POST['comm'],PDO::PARAM_STR);
    $req->execute();
    $req = $bdd->prepare('SELECT star, num from star where username= :user');
    $req->bindValue(':user',$_POST['username'],PDO::PARAM_STR);
    $req->execute();
    $data=$req->fetch();
    $num=$data['num'];
    if ($data['star']!=NULL){
      $star=$data['star'];
      $note=$_POST['note'];
      $newstar=($star*$num+$note)/($num+1);
    }
    else {
        $newstar=$_POST['note'];
    }
    $req = $bdd->prepare("update star set star = :newstar ,num=:newnum where username=:user");
    $req->bindValue(':newstar',$newstar,PDO::PARAM_STR);
    $req->bindValue(':newnum',($num+1),PDO::PARAM_INT);
    $req->bindValue(':user',$_POST['username'],PDO::PARAM_STR);
    $req->execute();
    header('Location: connected.php' );
    exit;
     
  }
}
?>

<head>
  <?php include "conbanner.php";?>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/rating.css">
</head>
<body>
  <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Notez les services de <?php echo $_GET['user'];?></b></span></p>
  <div class="rating gold">
       <div s="5" t="Excellent !"></div>
       <div s="4" t="Très bon !" ></div>
       <div s="3" t="Bon" class="selected"></div>
       <div s="2" t="Moyen "></div>
       <div s="1" t="Médiocre"></div>
  </div> 
  <b><div id="select" style="text-align: center;"><p>3 - Moyen</p></div></b>
  <p style="padding-top:7px; padding-left:120px; padding-bot:0px;"><span style="border: 1px solid; border-radius:5px; padding:5px; font-size:12px;"><b>Commentaire</b></span></p></br>
  <div class="row">
    
  </div>
    <form style="text-align: center;" method="POST">
      <input type="hidden" name="username" value ="<?php echo $_GET['user'];?>">
      <input type="hidden" name="note" id="note" value=3>
      
      <input type="text" name="titlecomm" maxlength="40" placeholder="Titre" style="margin:auto; background:#fff; width:500px;text-align: center;height:20px;"></br>
      <textarea name="comm" maxlength="400" placeholder="Vous pouvez laissez un commentaire si vous le souhaitez." style="background:#fff;margin:auto; width:500px; height:200px;"></textarea><br/>
      <p style="text-align:center;"><button class="btn btn-primary button" type="submit" name="submit" value="Valider" style="font-size:16px;">Noter <?php echo $_GET['user'];?></button></p>
    </form>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>

    <script>
      $('.rating div').addClass('star');
      $('.star').click(function(){
  if (this+":not(.selected)"){
    $('.star').removeClass('selected');
    $(this).addClass('selected');
    var starId = $(this).attr('s');
    var starText = $(this).attr('t');
    document.getElementById('select').innerHTML="<p>".concat(starId," - ",starText,"</p>");
    var note = document.getElementById('note');
    note.setAttribute("value",starId);
}});
    </script>

</body>
</html>
