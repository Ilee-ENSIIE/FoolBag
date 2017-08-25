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

function display_star(){
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('SELECT star,num FROM star WHERE username= :user');
        $req->bindValue(':user',$_SESSION['username'],PDO::PARAM_STR);
        $req->execute();
        $data=$req->fetch();
        $note=$data['star'];
        if ($data['num']==0){
            echo '<p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Vous n\'avez pas encore été noté</b></span></p></br>';
            exit();
        }
        else {
        $note=round($note*2);
        $half=($note % 2 == 1);
        $black=round(5-($note/2),0,PHP_ROUND_HALF_DOWN);
        $gold=round($note/2,0,PHP_ROUND_HALF_DOWN);
        $str="<div class='display'>";
        for ($i=0;$i<$gold;$i++){
            $str.='<i class="fa fa-star" aria-hidden="true"></i> ';
        }
        if ($half){
            $str.='<i class="fa fa-star-half-o" aria-hidden="true"></i> ';
        }
        for ($i=0;$i<$black;$i++){
            $str.='<i class="fa fa-star-o" aria-hidden="true"></i> ';
        }
        $str.="</div><br/><div class='note'>";
        $str.=$note/2;
        $str.="/5</div>";
        echo $str;
        }
}
function display_star_comment($note){
        $black=5-$note;
        $str="<div class='displaycomm'>";
        for ($i=0;$i<$note;$i++){
            $str.='<i class="fa fa-star" aria-hidden="true"></i> ';
        }
        for ($i=0;$i<$black;$i++){
            $str.='<i class="fa fa-star-o" aria-hidden="true"></i> ';
        }
        $str.="</div>";
        return $str;
}
function display_comm(){
        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        $req = $bdd->prepare('SELECT snduser,note,day,titlecomm,commentary FROM appreciation WHERE fstuser= :user AND day>(current_date-365)');
        $req->bindValue(':user',$_SESSION['username'],PDO::PARAM_STR);
        $req->execute();
        while ($data=$req->fetch()){
            $str ='<div class="comment">
            <div class="comment-avatar">
                <img src=images/user-512.png>
            </div>
            <div class="comment-box">
            <div class="comment-title">';
            $str.=$data['titlecomm'];
            $str.=display_star_comment($data['note']);
            $str.='</div><div class="comment-text">';
            $str.=str_replace("\n", "<br/>", $data['commentary']);
            $str.='<div class="comment-footer">
          <div class="comment-info">
            <span class="comment-author">
              <a href="perso.php?user='.$data['snduser'].'">';
              $str.=$data['snduser'];
              $str.='</a>
            </span>
            <span class="comment-date">';
            $str.=$data['day'];
            $str.='</span>
          </div>

          <div class="comment-actions">
            <a href="#"></a>
          </div>
        </div>
      </div>
    </div><br/>';
    echo $str;
              
        };
        
}
?>
<?php include 'conbanner.php' ?>
<link rel="stylesheet" href="assets/css/rating.css">
<link rel="stylesheet" href="assets/css/comment.css"><br/>
<div id="comm">
<p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Votre note moyenne</b></span></p></br>
<?php display_star(); ?>
<p style="padding-top:7px; padding-left:120px; padding-bot:0px;"><span style="border: 1px solid; border-radius:5px; padding:5px; font-size:12px;"><b>Commentaires qui vous ont été laissés</b></span></p></br>
<?php display_comm(); ?>
</div>

</html>