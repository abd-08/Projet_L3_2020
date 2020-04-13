<?php include "header.php"; ?>

<body class="bg">
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="panel-heading">
                    <h4>Veuillez choisir une image : </h4>

                </div>
                <hr>
                <form action="Cloudvision.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" accept="image/*" class="form-control">
                    <br>
                    <button type="submit" formaction="Cloudvision.php" class="btn btn-lg btn-block btn-outline-dark">Analyse Image Cloud Vision</button>
                    <button type="submit" formaction="Tesseract.php" class="btn btn-lg btn-block btn-outline-dark">Analyse Image TESSERACT</button>
                 </form>
                    <br/>
                    <form>
                    <button type="submit" formaction="CompareText.php" class="btn btn-lg btn-block btn-outline-dark">Comparer 2 textes</button>
                    <button type="submit" formaction="CompareWeb.php" class="btn btn-lg btn-block btn-outline-dark">Recherche plagiat internet</button>
                    </form> <br/>
            </div>
        </div>
    </div>
  
      <?php  include "footer.php"; ?>
</body>
</html>

