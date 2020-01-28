<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel = stylesheet type = text/css href = "css/style.css"/>
</head>
<body>
    <?php
        include "header.php";
    ?>
    <form method="POST" action="traitement.php">
        <label for="story1" id ="zone1">Zone texte 1 :</label>
        <textarea name="zone1"
                  rows="5" cols="33">
        </textarea>

        <label for="story2" id = "zone2">Zone texte 2 :</label>
        <textarea name="zone2"
                  rows="5" cols="33">
        </textarea>
        <input type="submit" value="Valider">
    </form>
    <?php
        include "footer.php";
    ?>

</body>
</html>
