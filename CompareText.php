<?php include "header.php"; ?>

<body>
    <div class="container-fluid">
        <h5 style="margin-top: 15px"> Entrez vos deux textes afin d'effectuer la comparaison :</h5><br/>
        <div class="row">
            <form id="formText" class="form-inline" action="plagiat.php" method="post">
                <div id="block1" class="col-md-6">
                    <label for='name1' class="mr-sm-2"></label>
                    <textarea name="text_1" cols="50" rows="15" placeholder="Entrez votre texte 1"></textarea>
                </div>
                <div id="block2" class="col-md-6">
                    <label for='name2' class="mr-sm-2"></label>
                    <textarea name="text_2" cols="50" rows="15" placeholder="Entrez votre texte 2"></textarea> <br/>
                </div>
                <input type="submit" id="compareweb" value="Valider" class="btn btn-success mb-2"/>
            </form>
        </div>
    </div>

    <?php  include "footer.php"; ?>
</body>