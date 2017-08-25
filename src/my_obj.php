<!DOCTYPE HTML>
<html>
	<?php include 'conbanner.php' ?>
	<?php 
	function list_key(){
	     $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	 $req = $bdd->prepare('SELECT objectkey FROM object WHERE username=:user');
     	 $req->bindValue(':user',$_SESSION['username'],PDO::PARAM_STR);
    	 $req->execute();
    	 $x=1;
    	 $array=array();
    	 while ($data=$req->fetch()){
    	     $array[]=$data['objectkey'];
    	 }
    	 return $array;
	}
	
	function text($key){
	        $bdd = new PDO('pgsql:host=localhost;dbname=BagTrip', 'admin', 'admin', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    	    $req = $bdd->prepare('SELECT objectkey, name, description, departure, arrival, weight, size_x, size_y, size_z, price FROM object WHERE username = :usr');
    	    $req2= $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
    	    $req3= $bdd->prepare('SELECT DISTINCT * FROM (SELECT departure FROM path UNION SELECT arrival FROM path UNION SELECT departure FROM object UNION SELECT arrival FROM object) AS foo ORDER BY departure;');
            $req->bindValue(':usr',$_SESSION['username'],PDO::PARAM_STR);
            $req->execute();
            $req2->execute();
            $req3->execute();
            $cnt=0;
            echo "<thead><tr><td>Nom</td><td>Description</td><td>Ville de départ</td><td>Ville d'arrivée</td><td>Poids (kg)</td><td>Longueur (cm)</td><td>Largueur (cm)</td><td>Hauteur (cm)</td><td>Prix</td><td></td></tr></thead>";
            while($data=$req->fetch()){
                $cnt++;
                if($data['objectkey']==$key){
                    echo "<form method='POST' action='./update_data.php' id='update_delete'>";
                    echo "<tr>";
                    echo "<td><input class='register_input register_input_text'  type='text' name='name' autocomplete='off' value='".$data['name']."' form='update_delete' maxlength='40'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_text'  type='text' name='description' maxlength='1000' autocomplete='off' value='".$data['description']."' form='update_delete'>";
                    echo "</td>";
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
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='weight' autocomplete='off' value='".$data['weight']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='size_x' autocomplete='off' value='".$data['size_x']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='size_y' autocomplete='off' value='".$data['size_y']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='size_z' autocomplete='off' value='".$data['size_z']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td>";
                    echo "<input class='register_input register_input_number'  type='number' name='price' autocomplete='off' value='".$data['price']."' form='update_delete'>";
                    echo "</td>";
                    echo "<td><input type='hidden' name='objectkey' value='".$key."' form='update_delete'><button class='btn btn-primary button' type='submit' name='update_obj' form='update_delete' style='font-size:12px;'>Modifier</button><button class='btn btn-primary button' type='submit' name='delete_obj' form='update_delete' style='font-size:12px;'>Supprimer</button><button class='btn btn-primary button' type='submit' name='back_obj' form='update_delete' style='font-size:12px;'>Annuler</button></td>";
                    echo "</tr>";
                    echo "</form>";
                }
                else {
                    echo "<tr>";
                    echo "<td>".$data['name']."</td>";
                    echo "<td>".$data['description']."</td>";
                    echo "<td>".$data['departure']."</td>";
                    echo "<td>".$data['arrival']."</td>";
                    echo "<td>".$data['weight']."</td>";
                    echo "<td>".$data['size_x']."</td>";
                    echo "<td>".$data['size_y']."</td>";
                    echo "<td>".$data['size_z']."</td>";
                    echo "<td>".$data['price']."</td>";
                    echo "<td></td>";
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
	
	<body>
	    <p style="text-align:center; padding-top:7px;"><span style="border: 1px solid; border-radius:5px; padding:5px;"><b>Mes colis</b></span></p>
	    <p style="text-align:center; padding-bot: -1em;"><a href="./new_obj.php" class="button">Vous avez besoin de transporter un nouvel objet ?</a></p>
	    <div class="register">
    	    <table class="default" id="tableau" style="width:100%;">
    	        <thead>
    	        <tr>
    	            <td>
    	                Nom
    	            </td>
    	            <td>
        	            Description
        	        </td>
        	        <td>
        	            Ville de départ
        	        </td>   
        	        <td>
        	            Ville d'arrivée
        	        </td>
        	        <td>
        	            Poids (kg)
        	        </td>
        	        <td>
        	            Volume (L)
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
        	    $req = $bdd->prepare('SELECT name, description, departure, arrival, weight, size_x, size_y, size_z, price FROM object WHERE username = :pseudo');
                $req->bindValue(':pseudo',$_SESSION['username'],PDO::PARAM_STR);
                $req->execute();
                $cnt=0;
                while($resultat = $req->fetch()){
                    $cnt++;
                    echo "<tr>\n";
                    echo "\t<td>".$resultat['name']."</td>\n";
                    echo "\t<td>".$resultat['description']."</td>\n";
                    echo "\t<td>".$resultat['departure']."</td>\n";
                    echo "\t<td>".$resultat['arrival']."</td>\n";
                    echo "\t<td>".$resultat['weight']."</td>\n";
                    echo "\t<td>".$resultat['size_x']*$resultat['size_y']*$resultat['size_z']*0.001."</td>\n";
                    echo "\t<td>".$resultat['price']."</td>\n";
                    echo "\t<td><button type=\"button\" onclick=\"updatedelete('".$cnt."','".$resultat['objectkey']."')\">Modifier ou supprimer</button></td>\n";
                    echo "</tr>\n";
                }
                ?>
            </table>
        </div>
	</body>
</html>