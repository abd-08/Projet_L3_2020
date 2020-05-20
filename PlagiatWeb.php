<?php
session_start();
include "header.php";
require "vendor/autoload.php";
require "traitement.php";
require "TraitementOnline.php"; ?>

<body>

<section>
    <?php



    if (strlen($_POST['text_1'])>1){
        $texte1= $_POST['text_1'];
    }
    else{
        var_dump($_FILES['image_2']);
        if(isset($_FILES['image_2'])){
            $file_name = $_FILES['image_2']['name'];
            $file_tmp =$_FILES['image_2']['tmp_name'];
            move_uploaded_file($file_tmp,"images/".$file_name);
            $texte_1 = CVTexte($file_name);//utilisation de cloud vision pour recuperer le texte
        }
        else $texte1 = "VIDE";

    }




    $varf =rechercheTexteWeb($texte1);

    //on calcul le resultat total et les phraase du texte surligner

    $res=0;
    $texte_surligne = "";
    for ($i=0;$i<count($varf);$i++){
    	$res = $res + $varf[$i][2];
    	$texte_surligne = $texte_surligne.$varf[$i][3];
    }
    $texte_surligne = "<p>".$texte_surligne."</p>";
    $res=$res/count($varf);
    $res= number_format($res , 2);
    afficheResultat($res);

    echo "<br/>";
    echo "<h4> Résultats de la recherche internet : </h4> ";


    echo "<p class='textCompare'>";
    echo $texte_surligne ;
    echo "</p>";


    $_SESSION["tableau"]=$varf;
    $_SESSION["resultat"]=$res;
    $_SESSION["texte"]=$texte_surligne;
    echo '<form action="pdf_generateur/Pdf_web.php" method="post" enctype="multipart/form-data">';
    echo "<br/>";
    echo '<input type="submit" value="Générer un pdf" id="btn" class="btn mb-2"/>';
    echo  '</form>';

    afficheFormeTab($varf);
    ?>
</section>

</body>


<?php  include "footer.php"; ?>
