
<?php
session_start();
include "header.php";
require "vendor/autoload.php";
require "Fonction/FonctionInternet.php";
require "Fonction/FonctionTraitement.php";
?>

<body>

<?php


$choix  = $_POST['choix'];
$choix2  = $_POST['choix2'];

if ($choix == "texte") $texte_1 = $_POST["text_1"];
else {
    if(isset($_FILES['image_1'])){
        $file_name = $_FILES['image_1']['name'];
        $file_tmp =$_FILES['image_1']['tmp_name'];
        move_uploaded_file($file_tmp,"images/".$file_name);
        $texte_1 = CVTexte($file_name);;//utilisation de cloud vision pour recuperer le texte
    }
}

if ($choix2 == "texte") $texte_2 = $_POST["text_2"];
else {
    if(isset($_FILES['image_2'])){
        $file_name = $_FILES['image_2']['name'];
        $file_tmp =$_FILES['image_2']['tmp_name'];
        move_uploaded_file($file_tmp,"images/".$file_name);
        $texte_2 = CVTexte($file_name);//utilisation de cloud vision pour recuperer le texte
    }
}


    $re = compareMot2($texte_1, $texte_2);

    $_SESSION['plagiat'] = $re;
    $_SESSION['texte'] = "<p>".$re[1]."</p>";
    $_SESSION['texte_2'] = "<p>".$re[2]."</p>";
    $_SESSION['similitude'] =  number_format($re[0]/strlen($texte_1) , 2) ;
    $_SESSION['similitude_2'] =  number_format($re[0]/strlen($texte_2) , 2) ;
    echo "<section>";

    $res = number_format($re[0]/strlen($texte_1) , 2)*100;//resultat sans virgule
   afficheResultat($res);

    echo "<br/>";
    echo "<h6> Paragraphe 1 : </h6> ";
    echo "<p class='textCompare'>";
        echo $re[1] ;
    echo "</p>";
    echo "<br/>";
    echo "<h6> Paragraphe 2 : </h6> ";
    echo "<p class='textCompare'>";
            echo $re[2];
    echo "</p>";

    echo '<form action="pdf_generateur/ex.php" method="post" enctype="multipart/form-data">';
    echo ' <input type="hidden" name="var1" value="<?php '.$re[1].'?>"></input>';//une autre façon d'envoyer le texte 1 au générateur de pdf
    echo ' <input type="hidden" name="var2" value="<?php '.$re[2].'?>"></input>';//une autre façon d'envoyer le texte 2 au générateur de pdf
    echo '<button type="submit"  formaction="pdf_generateur/Pdf_texte.php" id="btn" class="btn mb-2">Générer un Pdf</button>';
    echo  '</form>';

    echo "</section>";
    echo "<br/><br/><br/>";
    ?>
</body>
<?php  include "footer.php"; ?>


