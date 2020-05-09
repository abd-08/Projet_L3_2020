<?php
session_start();
include "header.php"; ?>
<!DOCTYPE html>
<html>
<head>

    <title>Exemple de code HTML5</title>

        <link rel="stylesheet" type="text/css" href="css/default.css"/>
                <!--[if IE]><link rel="stylesheet" type="text/css" href="css/default-ie.css" /><![endif]-->

        <!-- Empêcher la mise en cache de la page par le navigateur -->
        <meta http-equiv="pragma" content="no-cache" />
        <meta charset="ISO-8859-1">

</head>



<section>

<?php

 require "traitement.php";
 require "TraitementOnline.php";

if (strlen($_POST['text_1'])>1){
     $texte1= $_POST['text_1'];
}
else{
    var_dump($_FILES['image_2']);
	if(isset($_FILES['image_2'])){
	    $file_name = $_FILES['image_2']['name'];
	    $file_tmp =$_FILES['image_2']['tmp_name'];
	    move_uploaded_file($file_tmp,"images/".$file_name);
	    $texte_2 = CVTexte($file_name);//utilisation de cloud vision pour recuperer le texte
	}
	else $texte1 = "VIDE";

}



echo "<br/>";
echo "<h4> Resultat recherche web  </h4> ";



$varf =rechercheTexteWeb($texte1);
$_SESSION["tableau"]=$varf;
echo '<form action="pdf_generateur/Pdf_web.php" method="post" enctype="multipart/form-data">';

echo '<input type="submit" value="générer un pdf"   class="btn btn-outline-dark"/>';
echo  '</form>';
afficheFormeTab($varf);

?>

</section>


<?php  include "footer.php"; ?>

</html>