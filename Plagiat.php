
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



    $re = compareMot2($texte_1, $texte_2);

    $_SESSION['plagiat'] = $re;
    $_SESSION['texte'] = "<p>".$re[1]."</p>";
    $_SESSION['texte_2'] = "<p>".$re[2]."</p>";
    $_SESSION['similitude'] =  number_format($re[0]/strlen($texte_1) , 2) ;
    echo "<section>";

    $res = number_format($re[0]/strlen($texte_1) , 2)*100;//resultat sans virgule
    $res_detail =  number_format($re[0]/strlen($texte_1) , 4)*100 ;//resultat avec 2 chiffre après la virgule

    if ($res <=50){
        echo "<div class=\"progress-circle p$res\">
       <span>$res_detail%</span>
       <div class=\"left-half-clipper\">
          <div class=\"first50-bar\"></div>
          <div class=\"value-bar\"></div>
       </div>
    </div>";
    }elseif ($res>50 && $res<=100 ){
        echo "<div class=\"progress-circle over50 p$res\">
           <span>$res_detail%</span>
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


