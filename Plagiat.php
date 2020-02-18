<h1> Détection plagiat <br/> </h1>



<?php

 require "traitement.php";

if (isset($_POST['formmulaire'])){
     $texte1= $_POST['text_1'];
     $texte2= $_POST['text_2'];
}


/*
echo "<h1> Détection plagiat <br/> </h1>";


echo "<label for='name'>Texte 1:</label>" ;
echo '<textarea name="paragraph_text" cols="100" rows="15"></textarea> <br/><br/>' ;
echo "<label for='name'>Texte 2:</label>" ;
echo '<textarea name="paragraph_text_2" cols="100" rows="15"></textarea> <br/><br/>' ;
echo ' <button type="submit"  formaction="Tesseract.php" >comparer</button> <br/><br/>';*/



/*

$texte1 = "Vous avez besoin d'être aimé et admiré, et pourtant vous êtes critique avec vous-même. Vous avez certes des points faibles dans votre personnalité, mais vous savez généralement les compenser. Vous avez un potentiel considérable que vous n'avez pas encore utilisé à votre avantage. À l'extérieur vous êtes discipliné et vous savez vous contrôler, mais à l'intérieur vous tendez à être préoccupé et pas très sûr de vous-même. Parfois vous vous demandez sérieusement si vous avez pris la bonne décision ou fait ce qu'il fallait. Vous préférez une certaine dose de changement et de variété, et devenez insatisfait si on vous entoure de restrictions et de limitations. Vous vous flattez d'être un esprit indépendant ; et vous n'acceptez l'opinion d'autrui que dûment démontrée. Vous avez trouvé qu'il était maladroit de se révéler trop facilement aux autres. Par moments vous êtes très extraverti, bavard et sociable, tandis qu'à d'autres moments vous êtes introverti, circonspect et réservé. Certaines de vos aspirations tendent à être assez irréalistes." ;
$texte2 = $texte1;
$texte3 = "Vous avez besoin d'être aimé et admiré, et pourtant vous êtes critique avec vous-même.";
*/

     $texte1= $_POST['text_1'];
     $texte2= $_POST['text_2'];


$tableau=preg_split("/[\.]/",$texte1);
affichetab($tableau);

$tableau2=preg_split("/[\.]/",$texte2);
affichetab($tableau2);


echo "<br/> <br/>";
echo "le resultat = ".comparaison_phrase($texte1,$texte2);



?>
