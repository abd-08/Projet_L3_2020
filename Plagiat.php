
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




$mot =  "Alors que certains hommes mentionnaient que leur sexualit� �tait cach�e � leurs connaissances ou � leurs coll�gues de travail, tous les participants ont syst�matiquement reconnu la stigmatisation de l?homosexualit� dans les cultures traditionnelles asiatiques du Pacifique et ont adapt� leur expression personnelle � ces param�tres. En tant que tel, la compartimentation de l?identit� homosexuelle dans le contexte familial �tait commune. Cependant, les personnes interrog�es ne consid�raient pas que leur identit� sexuelle �tait compar�e � leur identit� ethnique pour se �fermer� elles-m�mes. Ils consid�raient que l?action prot�geait les membres de la famille contre le sujet tabou de la sexualit�.";
$mop ="Certains hommes ont dit qu?ils dissimulaient leur sexualit� � des connaissances ou � des coll�gues, mais tous les participants ont reconnu avoir �prouv� une sorte de stigmatisation de l?homosexualit� dans leurs cultures traditionnelles. La plupart ont dit qu?ils ont adapt� leur auto-expression pour s?adapter � ces param�tres. Ils ont donc compar� leur identit� homosexuelle lorsqu?ils �taient en famille.Cependant , de nombreux participants ne consid�raient pas cela comme une �fermeture� eux-m�mes; ils le consid�raient plut�t comme un moyen de prot�ger les membres de la famille contre des sujets tabous.";



   /* $texte1= $_POST['text_1'];
    $texte2= $_POST['text_2'];
    file_put_contents("pdf_generateur/copie.txt", $texte1);
    file_put_contents("pdf_generateur/copie2.txt", $texte2);*/



    $re = compareMot2($texte_1, $texte_2);

    $_SESSION['plagiat'] = $re;
    $_SESSION['texte'] = "<p>".$re[1]."</p>";
    $_SESSION['texte_2'] = "<p>".$re[2]."</p>";
    $_SESSION['similitude'] =  number_format($re[0]/strlen($texte_1) , 2) ;
     file_put_contents("pdf_generateur/copie.txt", "<p>".$re[1]."</p>");
     file_put_contents("pdf_generateur/copie_2.txt", "<p>".$re[2]."</p>");
     file_put_contents("pdf_generateur/similarite.txt","<p>".number_format($re[0]/strlen($mot) , 2)."</p>");
    echo "<section>";

    $res = number_format($re[0]/strlen($texte_1) , 2)*100;

    if ($res <=50){
        echo "<div class=\"progress-circle p$res\">
       <span>$res%</span>
       <div class=\"left-half-clipper\">
          <div class=\"first50-bar\"></div>
          <div class=\"value-bar\"></div>
       </div>
    </div>";
    }elseif ($res>50 && $res<=100 ){
        echo "<div class=\"progress-circle over50 p$res\">
           <span>$res%</span>
           <div class=\"left-half-clipper\">
              <div class=\"first50-bar\"></div>
              <div class=\"value-bar\"></div>
           </div>
        </div>";
    }else{
        echo "<div class=\"progress-circle over50 p100\">
           <span>100%</span>
           <div class=\"left-half-clipper\">
              <div class=\"first50-bar\"></div>
              <div class=\"value-bar\"></div>
           </div>
        </div>";
        }

    //echo "<h1 style='text-align: center'>".color_pourcentage($res)."</h1>";

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
    echo ' <input type="hidden" name="var1" value="<?php '.$re[1].'?>"></input>';
    echo ' <input type="hidden" name="var2" value="<?php '.$re[2].'?>"></input>';
    echo '<button type="submit"  formaction="pdf_generateur/ex.php" id="btn" class="btn mb-2">Générer un Pdf</button>';
    echo  '</form>';

    echo "</section>";

    echo "<br/><br/><br/>";


    include "footer.php";
    ?>

</body>



