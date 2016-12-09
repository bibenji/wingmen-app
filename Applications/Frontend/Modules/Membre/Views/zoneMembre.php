<div class="row">
<div class="col-lg-8 col-md-8 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>Contacter un player</h2>
<span>Voici la liste des membres inscrits sur le site :</span>

		<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr><th>Membre</th><th width="70px">Age</th><th width="70px">Sexe</th><th width="40%">Ici pour</th><th>Dernière connexion</th><th>Action</th></tr>
		</thead>
		
		<tbody>
		
		<?php foreach ($lesmembres as $mb) { ?>
		
		<tr data-href="/MON_APP/Web/zonemb/<?php echo $mb->mb_id(); ?>/<?php echo $mb->mb_name(); ?>/">
			
			<td class="text-center"><img class="img-circle img-conv-com" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/
				<?php echo ( ($mb->mb_avatar() != '') ? $mb->mb_avatar() : 'RANDAVATS/'.mt_rand(1,7).'.jpg' ); ?>" alt="', $mb->mb_name(), '" />
				<br />
				<?php echo $mb->mb_name(); ?>
			</td>
			
			<td class="text-center"><div class="list-mb-age"><?php echo $mb->mb_year_age(); ?></div></td>
			
			<td class="text-center"><img class="img-conv-com" src="/MON_APP/Web/img/
			<?php echo ( ($mb->mb_sexe() == 'F') ? 'rond-female.png' : 'rond-male.png' ); ?>" />
			</td>
			
			<td><?php echo $mb->mb_descri(); ?></td>
			
			<td><?php echo $mb->mb_lastCon()->getPasttime(); ?></td>
			
			<td class="text-center">
				<a href="/MON_APP/Web/zonemb/new-mess-<?php echo $mb->mb_id(); ?>.html">
					<img class="social-icon" src="/MON_APP/Web/img/talk.png" alt="Contacter" />
				</a>
				<!--
				<a href="#">
					<img class="social-icon" src="/MON_APP/Web/img/block.png" alt="Bloquer" />
				</a>
				-->
			</td>
			
		</tr>
		<?php } ?>
		
		</tbody>
		
		</table>
	
	<?php
	
	// echo $datedecon->getStringtime().'<br />';
	// echo $datedecon->getPasttime().'<br />';
	?>

</div>
	
<div class="col-lg-4 col-md-4">
	<div class="right-module">
		
		<h3>Filtrer les membres</h3>
		<form method="post" action="">
		
			<div class="form-group">
				<label>Pseudo</label>
				<input type="text" class="form-control" name="search_pseudo" />
			</div>
						
			<div class="form-group">
				<label>Âge Min</label>
				<select class="form-control" name="age_min" />
					<option>-</option>
					<?php
					$mois_jour = date('-m-d');
					$an = date('Y');
					
					for ($i = 15; $i < 50; $i += 5) {
					echo '<option value="', $an-$i, $mois_jour, '">', $i, '</option>';
					} ?>
				</select>
			</div>
			
			<div class="form-group">
				<label>Âge Max</label>
				<select class="form-control" name="age_max" />
					<option>-</option>
					<?php for ($i = 20; $i < 55; $i += 5) {
					echo '<option value="', $an-$i, $mois_jour, '">', $i, '</option>';
					}
					echo '<option value="', $an-100, $mois_jour, '">+50</option>';
					?>
					
				</select>
			</div>
			
			<div class="form-group">
				<label>Distance Max</label>
				<select class="form-control" disabled /><option>-</option></select>
			</div>
			
			<div class="form-group">
				<label>Dernière connexion</label>
				<select class="form-control" disabled /><option>-</option></select>
			</div>
				
		
			<p>
				<input type="submit" class="btn btn-primary" value="Recharger la page" />
				&nbsp;
				<input type="reset" class="btn btn-outline-primary" value="Réinitialiser" />
			</p>
	
		</form>

	</div>
</div>	
	
</div>

<!-- script pour links tr -->
<script src="/MON_APP/Web/js/jq-messagerie.js"></script>