<div class="row">
<div class="col-lg-6 col-md-6 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2><?php echo $membre->mb_name(); ?></h2>

<div class="row">
	<div class="col-lg-6 col-md-12">
		<div>
			<img class="legende-img" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/
			<?php echo ( ($membre->mb_avatar() != '') ? $membre->mb_avatar() : 'RANDAVATS/'.mt_rand(1,7).'.jpg' ); ?>
			" alt="', $membre->mb_name(), '" />
		</div>
	</div>
	<div class="col-lg-6 col-md-12">
		<table class="table">
			<tr>
				<td>Description:</td>
				<td><span><?php echo $membre->mb_descri(); ?></span></<td>
			</tr>
			<tr>
				<td>Âge:</td>
				<td>
					<div class="list-mb-age"><?php echo $membre->mb_year_age(); ?></div>
				</td>
			</tr>
			<tr>
				<td>Sexe:</td>
				<td>
					<img class="img-conv-com" src="/MON_APP/Web/img/
					<?php echo ( ($membre->mb_sexe() == 'F') ? 'rond-female.png' : 'rond-male.png' ); ?>
					" />
				</td>
			</tr>
			<tr>
				<td>Dernière connexion:</td>
				<td><?php echo $membre->mb_lastCon()->getPasttime(); ?></td>
			</tr>
			<?php if ($membre->mb_id() != $user->id()) { ?>
			<tr>
				<td>Contacter:</td>
				<td>
					<a href="/MON_APP/Web/zonemb/new-mess-<?php echo $membre->mb_id(); ?>.html">
						<img class="social-icon" src="/MON_APP/Web/img/talk.png" alt="Contacter" />
					</a>
				</td>
			</tr>
			
			<?php }	?>
			
		</table>
		
		
		
		
	</div>	
</div>

</div>

<div class="col-lg-6 col-md-6">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>