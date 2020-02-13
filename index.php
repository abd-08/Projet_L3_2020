<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploader votre image </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
        }
        .bg {
            background-image: url("images/bg.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="bg">
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin: auto; background: white; padding: 20px; box-shadow: 10px 10px 5px #888">
                <div class="panel-heading">
                    <h2>Google Cloud Vision API</h2>
                    <p style="font-style: italic;">Coolest Image Processing Engine on Earth</p>
                </div>
                <hr>
                <form action="check.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" accept="image/*" class="form-control">
                    <br>
                    <button type="submit" style="border-radius: 0px;" class="btn btn-lg btn-block btn-outline-success">Analyse Image</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php require "traitement.php"; ?>


<?php

echo "<h1> Détection plagiat <br/> </h1>";


$texte1 = "Vous avez besoin d'être aimé et admiré, et pourtant vous êtes critique avec vous-même. Vous avez certes des points faibles dans votre personnalité, mais vous savez généralement les compenser. Vous avez un potentiel considérable que vous n'avez pas encore utilisé à votre avantage. À l'extérieur vous êtes discipliné et vous savez vous contrôler, mais à l'intérieur vous tendez à être préoccupé et pas très sûr de vous-même. Parfois vous vous demandez sérieusement si vous avez pris la bonne décision ou fait ce qu'il fallait. Vous préférez une certaine dose de changement et de variété, et devenez insatisfait si on vous entoure de restrictions et de limitations. Vous vous flattez d'être un esprit indépendant ; et vous n'acceptez l'opinion d'autrui que dûment démontrée. Vous avez trouvé qu'il était maladroit de se révéler trop facilement aux autres. Par moments vous êtes très extraverti, bavard et sociable, tandis qu'à d'autres moments vous êtes introverti, circonspect et réservé. Certaines de vos aspirations tendent à être assez irréalistes." ;
$texte2 = $texte1;
$texte3 = "Vous avez besoin d'être aimé et admiré, et pourtant vous êtes critique avec vous-même.";

$tableau=preg_split("/[\.]/",$texte1);
affichetab($tableau);



echo "<br/> <br/>";
echo "le resultat = ".comparaison_texte_texte($texte1,$texte1);



?>
