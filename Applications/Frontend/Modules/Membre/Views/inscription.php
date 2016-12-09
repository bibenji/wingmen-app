<div class="row">
<div class="col-lg-7 col-md-7 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<?php if (isset($title) AND $title == "Inscription") { ?>
	<h2><?php echo $title; ?></h2>
	<h4>Inscrivez-vous pour pouvoir profiter de toutes les fonctionnalités du site !</h4>
<?php } else { ?>
	<h2>Modification de compte</h2>
	<h4>Modifiez-ici les paramètres de votre compte.</h4>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">

	<?php echo $form; ?>
	
	<input type="submit" value="<?php 
		echo ( $title == "Inscription" ? "S'inscrire" : "Enregistrer les modifications" );
	?>" class="btn btn-success" /> <input type="reset" value="Recommencer" class="btn btn-warning" />
	
	<br /><br />
		
</form>

</div>

<div class="col-lg-5 col-md-5">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>