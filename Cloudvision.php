<?php

require "vendor/autoload.php";
 require "traitement.php";
 require "TraitementOnline.php";

if(isset($_FILES['image'])){
    $file_name = $_FILES['image']['name'];
    $file_tmp =$_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp,"images/".$file_name);


    echo ' <div style = "display:grid;"><div class="item" style = "display:flex;"><div><h3>Image Upload Success</h3>';
    echo '<img src="images/'.$file_name.'" style="width:60%;"></div></div>';



    $contenu_img = CVTexte($file_name);//utilisation de cloud vision pour recuperer le texte

    $varf =rechercheTexteWeb($contenu_img);
    afficheFormeTab($varf);

    echo " </div>";


}


?>
