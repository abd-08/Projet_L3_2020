<?php include "header.php"; ?>


	<script type="text/javascript" src="js/fonctionsjs.js"></script>

	<body>
	<div class="container-fluid">
		<h5 style="margin-top: 15px"> Entrez vos deux textes afin d'effectuer la comparaison :</h5>
		<div class="row">
			<form id="formText" class="form-inline" action="plagiat.php" method="post" enctype="multipart/form-data">

				<div id="block1" class="col-md-6" >
					texte <input type="radio" name="choix" value="texte" onclick="mode('text_1','im1','texte', 'vld');" checked/>
					image <input type="radio" name="choix" value="image" onclick="mode('text_1','im1','image','');" />
					<br/>
					<textarea name="text_1" id="text_1" cols="50" rows="15"  placeholder="Entrez votre texte 1"></textarea>
					<input type="file" id="im1" name="image_1" accept="image/*" class="form-control" />
				</div>

				<div id="block2" class="col-md-6" >
					texte <input type="radio" name="choix2" value="texte" onclick="mode('text_2','im2','texte','vld');" checked/>
					image <input type="radio" name="choix2" value="image" onclick="mode('text_2','im2','image','');" />
					<br/>
					<textarea name="text_2" id="text_2" cols="50" rows="15" placeholder="Entrez votre texte 2"></textarea>
					<input type="file" id="im2" name="image_2" accept="image/*" class="form-control" />
				</div>

				<div id="block22" class="col-md-6">
					<input type="submit" id="vld" value="Valider"  class="btn mb-2"/>
				</div>
			</form>
		</div>

	</div>
	<br/>
	</body>

<?php include "footer.php"; ?>