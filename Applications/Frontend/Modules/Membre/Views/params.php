<div class="row">
<div class="col-lg-6 col-md-8 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>Mon compte</h2>
<span>Mes informations personnelles.</span>

	<ul class="list-group">		
		<li class="list-group-item">Mon identifiant / pseudo : <?php echo $membre['mb_name']; ?></li>
		<li class="list-group-item">Mon adresse mail : <?php echo $membre['mb_email']; ?></li>
		<li class="list-group-item">Mon sexe : <?php echo $membre['mb_sexe']; ?></li>
		<li class="list-group-item">Ma date de naissance : <?php echo $membre['mb_age']; ?></li>
		<li class="list-group-item">Mon adresse : <?php echo $membre['mb_adresse']; ?></li>
		<li class="list-group-item">Ma présentation : <?php echo $membre['mb_descri']; ?></li>
	</ul>
		
	<ul class="list-group">
		<li class="list-group-item">
			<a href="/MON_APP/Web/account/">Modifier les informations me conçernant</a> - Notifications - <a href="/MON_APP/Web/zonemb/supprimer/">Supprimer mon compte</a>
		</li>		
	</ul>

	<ul class="list-group">
		<li class="list-group-item">Mon avatar :<br /><br /><div><img class="legende-img" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/<?php echo $membre['mb_avatar']; ?>" /></div></li>
	</ul>	
	
</div>

<div class="col-lg-6 col-md-4">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>