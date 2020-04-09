
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="pragma" content="no-cache" />
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
      <?php include "header.php"; ?>
    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin: auto; background: white; padding: 20px; box-shadow: 10px 10px 5px #888">
                <div class="panel-heading">
                    <h2>API ORC</h2>

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
                    <button type="submit" style="border-radius: 0px;" formaction="CompareText.php" class="btn btn-lg btn-block btn-outline-success">Comparer 2 textesT</button>
                    <button type="submit" style="border-radius: 0px;" formaction="CompareWeb.php" class="btn btn-lg btn-block btn-outline-success">Recherche plagiat internet</button>
                    </form>
            </div>
        </div>
    </div>
  
      <?php  include "footer.php"; ?>
</body>
</html>

