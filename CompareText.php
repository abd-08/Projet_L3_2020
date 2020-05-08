<?php include "header.php"; ?>


<script type="text/javascript">

    var copie = "texte";
    var copie2 = "texte";

    function mode(idtext , idimg , mode ){

        alert(formText.choix[1].value);
        if (mode == "texte"){
            copie = "texte";
            document.getElementById(idtext).style.visibility='visible';
            document.getElementById(idimg).style.visibility='hidden';
        }
        else if (mode == "image") {
            copie = "image";
            document.getElementById(idtext).style.visibility='hidden';
            document.getElementById(idimg).style.visibility='visible';
        }
        else{
            document.getElementById(idtext).style.visibility='hidden';
            document.getElementById(idimg).style.visibility='hidden';
        }
    }

</script>

<script type="text/javascript">
    function checkForm(){

        if(document.getElementById('text_1').value == "" ){
            alert('Vous devez entrer un texte '+copie);
            return false;
        }else{
            document.getElementById('formText').submit();
        }
    }
</script>

<body>
<div class="container-fluid">
    <h5 style="margin-top: 15px"> Entrez vos deux textes afin d'effectuer la comparaison :</h5>
    <div class="row">
        <form id="formText" class="form-inline" action="plagiat.php" method="post" enctype="multipart/form-data">

            <div id="block1" class="col-md-6" >
                texte <input type="radio" name="choix" value="texte" onclick="mode('block1','im1','texte');" checked />
                image <input type="radio" name="choix" value="image" onclick="mode('block1','im1','image');" />
                <br/>
                <label for='name1' class="mr-sm-2"></label>
                <textarea name="text_1" id="text_1" cols="50" rows="15"  placeholder="Entrez votre texte 1"></textarea>
            </div>

            <div id="block11" class="col-md-6" >
                <input type="file" id="im1" name="image_1" accept="image/*" class="form-control" />
                <input type="button" name="valider" value="Valider" class="btn mb-2" onClick="checkForm()" />
            </div>

            <div id="block2" class="col-md-6" >
                texte <input type="radio" name="choix2" value="texte" onclick="mode('block2','im2','texte');" checked />
                image <input type="radio" name="choix2" value="image" onclick="mode('block2','im2','image');" />
                <br/>
                <label for='name2' class="mr-sm-2"></label>
                <textarea name="text_2" cols="50" rows="15" placeholder="Entrez votre texte 2"></textarea>
            </div>

            <div id="block22" class="col-md-6">
                <input type="file" id="im2" name="image_2" accept="image/*" class="form-control" />
                <input type="submit" id="compareweb" value="Valider"  class="btn mb-2"/>
            </div>
        </form>
    </div>

</div>
<br/>
</body>

<?php include "footer.php"; ?>