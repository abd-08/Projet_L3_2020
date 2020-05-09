<?php include "header.php"; ?>

	<body>
	<div class="container-fluid">
		<div class="row">
			<form id="fromWeb" class="form-inline" action="PlagiatWeb.php" method="post">

				<div id="block1" class="col-md-6">
					<h5>Entrez votre texte afin de faire la recherche sur internet : </h5>
					<textarea name="text_1" cols="54" rows="11"></textarea>
					<input type="submit" value="Valider" class="btn mb-2"/>
				</div>


				<div id="block1Web" class="col-md-6">
					<h5>Séléctionnez un fichier image :</h5>
					<input type="file"   name="image_2" accept="image/*" class="form-control" />
				</div>

			</form>
		</div>
	</div>
	<br> <br>
	</body>
<?php include "footer.php"; ?>