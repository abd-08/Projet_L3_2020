<!DOCTYPE html>
<html>
<head>

    <title>Exemple de code HTML5</title>

        <link rel="stylesheet" type="text/css" href="css/default.css"/>
                <!--[if IE]><link rel="stylesheet" type="text/css" href="css/default-ie.css" /><![endif]-->

        <!-- Empêcher la mise en cache de la page par le navigateur -->
        <meta http-equiv="pragma" content="no-cache" />

</head>


<h1> Détection plagiat <br/> </h1>



<?php

 require "traitement.php";
 require "TraitementOnline.php";
 use Google\Cloud\Vision\VisionClient;

if (isset($_POST['formmulaire'])){
     $texte1= $_POST['text_1'];
     $texte2= $_POST['text_2'];
}



     $texte1= $_POST['text_1'];
     $texte2= $_POST['text_2'];

echo "<h3> Texte 1  </h3> ";
$tableau=preg_split("/[\.]/",$texte1);
affichetab($tableau);

echo "<br/> <br/>";
echo "<br/> <br/>";

echo "<h3> Texte 2  </h3> ";
$tableau2=preg_split("/[\.]/",$texte2);
affichetab($tableau2);


echo "<br/> <br/>";
                   echo "<br/> <br/>";
echo "le resultat first algo= ".(100*comparaison_phrase($texte1,$texte2)/((strlen($texte1)+strlen($texte2))/2));
echo "<br/> <br/>";
echo "<br/> <br/>";

echo "le resultat php similar = ".(100*similar_text($texte1,$texte2)/strlen($texte1));
echo "<br/> <br/>";
echo "<br/> <br/>";
echo "le resultat algorithme mot = ".compareStrings($texte1, $texte2);
echo "<br/> <br/>";
echo "<br/> <br/>";
echo "le resultat last algo = ".compareMot($texte1, $texte2);
echo "<br/> <br/>";



?>







</html>


