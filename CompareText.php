<?php include "header.php"; ?>

<body>
    <div class="container-fluid">
        <h5 style="margin-top: 15px"> Entrez vos deux textes afin d'effectuer la comparaison :</h5><br/>
        <div class="row">
            <form id="formText" name="formulaire" action="plagiat.php" method="post">
                <div id="block1" class="col-md-6">
                    <label for='name1'>Texte 1 :</label><br/>
                    <textarea name="text_1" cols="50" rows="15"></textarea>
                </div>
                <div id="block2" class="col-md-6">
                    <label for='name2'>Texte 2 :</label><br/>
                    <textarea name="text_2" cols="50" rows="15"></textarea> <br/>
                </div>
            </form>
        </div>
        <input type="submit" value="Valider" class="btn btn-success"/>
    </div>
    <?php  include "footer.php"; ?>
</body>