<?php include "header.php"; ?>

<body class="bg">
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin: auto; background: white; padding: 20px; box-shadow: 10px 10px 5px #888">
                <div class="panel-heading">
                    <h2>Veuillez choisir une image : </h2>

                </div>
                <hr>
                <form action="Cloudvision.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" accept="image/*" class="form-control">
                    <br>
                    <button type="submit" style="border-radius: 0px;" formaction="Cloudvision.php" class="btn btn-lg btn-block btn-outline-success">Analyse Image Cloud Vision</button>
                    <button type="submit" style="border-radius: 0px;" formaction="Tesseract.php" class="btn btn-lg btn-block btn-outline-success">Analyse Image TESSERACT</button>
                 </form>
                    <br/>
                    <br/>
                    <br/>
                    <form>
                    <button type="submit" style="border-radius: 0px;" formaction="CompareText.php" class="btn btn-lg btn-block btn-outline-success">Comparer 2 textes</button>
                    <button type="submit" style="border-radius: 0px;" formaction="CompareWeb.php" class="btn btn-lg btn-block btn-outline-success">Recherche plagiat internet</button>
                    </form>
            </div>
        </div>
    </div>
  
      <?php  include "footer.php"; ?>
</body>
</html>

