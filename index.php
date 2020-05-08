<?php include "header.php"; ?>

<body>
    <div class="container-fluid">
        <div class="row" id="index">
            <div class="col-md-6 offset-md-3">
                    <form action="Cloudvision.php" method="post" enctype="multipart/form-data">
                    <button type="submit" formaction="CompareText.php" class="btn btn-lg btn-block">Plagiat entre 2 copies</button>
                    <button type="submit" formaction="CompareWeb.php" class="btn btn-lg btn-block">Détection plagiat internet</button>
                    </form> <br/>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php  include "footer.php"; ?>
</body>

