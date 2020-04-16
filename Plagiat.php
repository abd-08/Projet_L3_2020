
<?php include "header.php"; ?>

<body>
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
    echo "<section>";
    echo "<h5> Texte 1 </h5> ";
    echo "<p class='test'>";
        $tableau=preg_split("/[\.]/",$texte1);
        affichetab($tableau);
    echo "</p>";

    echo "<br/>";

    echo "<h5> Texte 2 </h5> ";
    echo "<p class='test'>";
        $tableau2=preg_split("/[\.]/",$texte2);
        affichetab($tableau2);
    echo "</p>";

    echo "<br/> <br/>";
    echo "le resultat first algo= ".(100*comparaison_phrase($texte1,$texte2)/((strlen($texte1)+strlen($texte2))/2));
    echo "<br/> <br/>";

    echo "le resultat php similar = ".(100*similar_text($texte1,$texte2)/strlen($texte1));
    echo "<br/> <br/>";
    echo "<br/> <br/>";
    echo "le resultat algorithme mot = ".compareStrings($texte1, $texte2);
    echo "<br/> <br/>";
    echo "le resultat last algo = ".compareMot($texte1, $texte2);
    echo "<br/> <br/>";

    echo "</section>";

    include "footer.php";
    ?>

</body>



