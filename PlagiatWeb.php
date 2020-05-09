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

<?php include "header.php"; ?>

<section>

<?php

 require "traitement.php";
 require "TraitementOnline.php";
 use Google\Cloud\Vision\VisionClient;

if (isset($_POST['formmulaire'])){
     $texte1= $_POST['text_1'];

}
 $texte1= $_POST['text_1'];

echo "<br/>";
echo "<h4> Resultat recherche web  </h4> ";

$varf = rechercheTexteWeb($texte1);

?>


<table>
        <thead>
                <tr>
                        <td>Pharse à comparer</td>
                        <td>Site</td>
                        <td> % </td>
                </tr>
        </thead>
        <tbody>

                <?php for($i=0; $i<sizeof($varf); $i++){ ?>
                <tr>
                        <td> <?= $varf[$i][0] ?> </td>
                        <td> <?= $varf[$i][1] ?> </td>
                        <td> <?= $varf[$i][2] ?> </td>
                </tr>
                <?php } ?>

        </tbody>
</table>




</section>

<?php  include "footer.php"; ?>

</html>