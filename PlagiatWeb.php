<?php
session_start();
include "header.php"; ?>

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
echo "<h4> Resultat recherche web  </h4> ";
$varf =rechercheTexteWeb($texte1);

$res=0;
for($i=0;$i<count($varf);$i++){
	$res = $varf[$i][2]+$res;
}
$res =$res / count($varf);
$res =  number_format($res , 1);
echo "<h1  style=' text-align: center;'>Plagiat : ".$res."% </h1>";


echo $texte1."<br/><br/>";

$_SESSION["tableau"]=$varf;
echo '<form action="pdf_generateur/Pdf_web.php" method="post" enctype="multipart/form-data">';

echo '<input type="submit" value="générer un pdf"   class="btn btn-outline-dark"/>';
echo  '</form>';
afficheFormeTab($varf);

?>

</section>


<?php  include "footer.php"; ?>

</html>