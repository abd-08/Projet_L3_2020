<?php include "header.php"; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <form id="fromWeb" name="formulaire" action="PlagiatWeb.php" method="post">
                <div id="block" class="col-md-12">
                    <h5>Entrez votre texte afin de faire la recherche sur internet : </h5>
                    <br/>
                    <textarea name="text_1" cols="70" rows="12"></textarea>
                </div>
                <input id="compareweb" type="submit" value="Valider" class="btn btn-success"/>
            </form>
        </div>
    </div>
</body>
<?php include "footer.php"; ?>
