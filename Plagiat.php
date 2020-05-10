
<?php
session_start();
 include "header.php"; ?>

<body>

<?php
require "vendor/autoload.php";
 require "traitement.php";
 require "TraitementOnline.php";
 use Google\Cloud\Vision\VisionClient;




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




$mot =  "Alors que certains hommes mentionnaient que leur sexualité était cachée à leurs connaissances ou à leurs collègues de travail, tous les participants ont systématiquement reconnu la stigmatisation de l’homosexualité dans les cultures traditionnelles asiatiques du Pacifique et ont adapté leur expression personnelle à ces paramètres. En tant que tel, la compartimentation de l’identité homosexuelle dans le contexte familial était commune. Cependant, les personnes interrogées ne considéraient pas que leur identité sexuelle était comparée à leur identité ethnique pour se «fermer» elles-mêmes. Ils considéraient que l’action protégeait les membres de la famille contre le sujet tabou de la sexualité.";
$mop ="Certains hommes ont dit qu’ils dissimulaient leur sexualité à des connaissances ou à des collègues, mais tous les participants ont reconnu avoir éprouvé une sorte de stigmatisation de l’homosexualité dans leurs cultures traditionnelles. La plupart ont dit qu’ils ont adapté leur auto-expression pour s’adapter à ces paramètres. Ils ont donc comparé leur identité homosexuelle lorsqu’ils étaient en famille.Cependant , de nombreux participants ne considéraient pas cela comme une «fermeture» eux-mêmes; ils le considéraient plutôt comme un moyen de protéger les membres de la famille contre des sujets tabous.";



   /* $texte1= $_POST['text_1'];
    $texte2= $_POST['text_2'];
    file_put_contents("pdf_generateur/copie.txt", $texte1);
    file_put_contents("pdf_generateur/copie2.txt", $texte2);*/



    $re = compareMot2($texte_1, $texte_2);

    $_SESSION['plagiat'] = $re;
    $_SESSION['texte'] = "<p>".$re[1]."</p>";
    $_SESSION['texte_2'] = "<p>".$re[2]."</p>";
    $_SESSION['similitude'] =  number_format($re[0]*100/strlen($texte_1) , 2) ;
    $_SESSION['similitude_2'] =  number_format($re[0]*100/strlen($texte_2) , 2) ;

    echo "<section>";
    echo "<h1>".number_format($re[0]*100/strlen($texte_1) , 2)."</h1>";


    echo "<h5> Texte 1 </h5> ";
    echo "<p class='test'>";
        echo $re[1] ;
    echo "</p>";

    echo "<br/>";


 echo "<h1>".number_format($re[0]*100/strlen($texte_2) , 2)."</h1>";
    echo "<h5> Texte 2 </h5> ";
    echo "<p class='test'>";
            echo $re[2];
    echo "</p>";


    echo "</section>";

    echo '<form action="pdf_generateur/ex.php" method="post" enctype="multipart/form-data">';
    echo ' <input type="hidden" name="var1" value="<?php '.$re[1].'?>"></input>';
    echo ' <input type="hidden" name="var2" value="<?php '.$re[2].'?>"></input>';
    echo '<button type="submit"  formaction="pdf_generateur/ex.php" class="btn btn-lg btn-outline-dark">Generer un Pdf</button>';
    echo  '</form>';


    include "footer.php";
    ?>

</body>



