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


<h1> Détection plagiat <br/> </h1>



<?php

 require "traitement.php";
 require "TraitementOnline.php";
 use Google\Cloud\Vision\VisionClient;

if (isset($_POST['formmulaire'])){
     $texte1= $_POST['text_1'];

}
 $texte1= $_POST['text_1'];


echo "<h3> Resultat recherche web  </h3> ";



echo "<br/> <br/>";
echo "<br/> <br/>";

$varf =rechercheTexteWeb($texte1);
var_dump($varf);


echo "RECHERCHE AVANCEE ";
var_dump(avance($varf));



?>
</html>