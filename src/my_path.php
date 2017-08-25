<!DOCTYPE HTML>

<html>
	<?php include 'conbanner.php';
	?>
	<?php 
	function list_key(){
	     $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	 $req = $bdd->prepare('SELECT pathkey FROM path WHERE username=:user');
     	 $req->bindValue(':user',$_SESSION['username'],PDO::PARAM_STR);
    	 $req->execute();
    	 $x=1;
    	 $array=array();
    	 while ($data=$req->fetch()){
    	     $array[]=$data['pathkey'];
    	 }
    	 return $array;
	}
	function text($key){
	        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	    $req = $bdd->prepare('SELECT pathkey, departure, arrival, date, regular, frequency, description, price FROM path WHERE username = :usr');
    	    $req2= $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
    	    $req3= $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
            $req->bindValue(':usr',$_SESSION['username'],PDO::PARAM_STR);
            $req->execute();
            $req2->execute();
            $req3->execute();
            $cnt=0;
            echo "<thead><tr><td>Ville de départ</td><td>Ville d'arrivée</td><td>Date</td><td>Régularité</td><td>Fréquence</td><td>Description</td><td>Prix</td><td></td><td></td></tr></thead>";
            while($data=$req->fetch()){
                $cnt++;
                if($data['pathkey']==$key){
                    echo "<form method='POST' action='./update_data.php' id='update_delete'>";
                    echo "<tr>";
                    echo "<td><input class='register_input register_input_text' list='departure' name='departure' autocomplete='off' maxlength='40' value='".$data['departure']."'  form='update_delete'>";
                    echo "<datalist id='departure'>";
                    while($data2=$req2->fetch()){
                            echo "<option name=".$data2[0]." value=".$data2[0].">";
                      }
                    echo "</datalist></td>";
                    echo "<td><input class='register_input register_input_text' list='arrival' name='arrival' autocomplete='off' maxlength='40' value='".$data['arrival']."' form='update_delete'>";
                    echo "<datalist id='arrival'>";
                    while($data3=$req3->fetch()){
                       echo "<option name=".$data3[0]." value=".$data3[0].">";
                     }
                    echo "</datalist></td>";
                    echo "<td><input class='register_input'  type='date' name='date' autocomplete='off' value='".$data['date']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input'  type='radio' name='regular' value='f' checked form='update_delete'> Non <br/><input class='register_input'  type='radio' name='regular' value='t' form='update_delete'> Oui";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='frequency' autocomplete='off' value='".$data['frequency']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_text'  type='text' name='description' maxlength='1000' autocomplete='off' value='".$data['description']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='price' autocomplete='off' value='".$data['price']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td><input type='hidden' name='pathkey' value='".$key."' form='update_delete'><button class='btn btn-primary button' type='submit' name='update_path' form='update_delete' style='font-size:12px;'>Modifier</button></br><button class='btn btn-primary button' type='submit' name='delete_path' form='update_delete' style='font-size:12px;'>Supprimer</button><button class='btn btn-primary button' type='submit' name='back_path' form='update_delete' style='font-size:12px;'>Annuler</button></td>";
                    echo "</tr>";
                    echo "</form>";
                }
                else {
                    echo "<tr>";
                    echo "<td>".$data['departure']."</td>";
                    echo "<td>".$data['arrival']."</td>";
                    echo "<td>".$data['date']."</td>";
                    echo "<td>".$data['regular']."</td>";
                    if ($resultat['frequency']==''){
                        echo "<td></td>";
                    }
                    else{
                        echo "<td>".$resultat['frequency']."</td>";
                    }
                    echo "<td>".$data['description']."</td>";
                    echo "<td>".$data['price']."</td>";
                    echo "</tr>";
                }
            }
    
	}
	?>
    <script>
        function updatedelete(id,key){
            if (id=='1'){
                document.getElementById("tableau").innerHTML="<?php text(list_key()[0]); ?>";
            }
            if (id=='2'){
                document.getElementById("tableau").innerHTML="<?php text(list_key()[1]); ?>";
            }
            if (id=='3'){
                document.getElementById("tableau").innerHTML="<?php text(list_key()[2]); ?>";
            }
            if (id=='4'){
                document.getElementById("tableau").innerHTML="<?php text(list_key()[3]); ?>";
            }
            if (id=='5'){
                document.getElementById("tableau").innerHTML="<?php text(list_key()[4]); ?>";
            }
        }
    </script>
    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Mes voyages</b></span></p>
    <p style="text-align: center; padding-bot: -1em;">
        <a href="./new_path.php" class="button">Vous allez effectuer un nouveau trajet ?</a>
    </p>
    <div class="register">
	    <table class="default" id="tableau">
	        <thead>
	        <tr>
    	        <td>
    	            Ville de départ
    	        </td>
    	        <td>
    	            Ville d'arrivée
    	        </td>
    	        <td>
    	            Date
    	        </td>
    	        <td>
    	            Régularité
    	        </td>
    	        <td>
    	            Fréquence
    	        </td>
    	        <td>
    	            Description
    	        </td>
    	        <td>
    	            Prix
	            </td>
	            <td>

	            </td>
    	    </tr>
    	    </thead>
    	    <?php
    	    $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	    $req = $bdd->prepare('SELECT pathkey, departure, arrival, date, regular, frequency, description, price FROM path WHERE username = :pseudo');
            $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
            $req->execute();
            $cnt=0;
            while($resultat = $req->fetch()){
                $cnt++;
                echo "\n\t\t\t<tr>\n";
                echo "\t\t\t\t<td>".$resultat['departure']."</td>\n";
                echo "\t\t\t\t<td>".$resultat['arrival']."</td>\n";
                echo "\t\t\t\t<td>".$resultat['date']."</td>\n";
                if ($resultat['regular']===TRUE){
                    echo "\t\t\t\t<td style=\"text-align:center;\">X</td>\n";
                }
                else {
                    echo "\t\t\t\t<td></td>\n";
                }
                if ($resultat['frequency']==''){
                    echo "<td></td>";
                }
                else{
                    echo "\t\t\t\t<td>".$resultat['frequency']."</td>\n";
                }
                echo "\t\t\t\t<td>".$resultat['description']."</td>\n";
                echo "\t\t\t\t<td>".$resultat['price']."</td>\n";
                echo "\t\t\t\t<td><button type=\"button\" onclick=\"updatedelete('".$cnt."','".$resultat['pathkey']."')\">Modifier ou supprimer</button></td>\n";
                echo "\t\t\t</tr>\n";
            }
            ?>
        </table>
    </div>
	</body>
</html>