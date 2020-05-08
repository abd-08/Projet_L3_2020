<?php include "header.php"; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <form id="fromWeb" class="form-inline" action="PlagiatWeb.php" method="post">

                <div id="block1" class="col-md-6">
                    <h5>Entrez votre texte afin de faire la recherche sur internet : </h5>
                    <textarea name="text_1" cols="60" rows="11"></textarea>
                </div>


                <div id="block1Web" class="col-md-6">
                    <h5>Séléctionnez un fichier image :</h5>
                    <input type="file" name="image" accept="image/*" class="form-control" /><br/>
                    <button type="submit" class="btn mb-2">Télécharger</button>
                </div>

                <input id="compareweb" type="submit" value="Valider" class="btn mb-2"/>
            </form>
        </div>
    </div>
    <br> <br>
</body>
<?php include "footer.php"; ?>

