<?php
session_start();
include "header.php"; ?>

<body>

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
        echo "<h4> Résultats de la recherche internet : </h4> ";

        $varf =rechercheTexteWeb($texte1);
        $_SESSION["tableau"]=$varf;
        echo '<form action="pdf_generateur/Pdf_web.php" method="post" enctype="multipart/form-data">';
        echo "<br/>";
        echo '<input type="submit" value="Générer un pdf" id="btn" class="btn mb-2"/>';
        echo  '</form>';
        afficheFormeTab($varf);

        echo "<br/>";
        ?>
    </section>
</body>



<?php  include "footer.php"; ?>

</html>