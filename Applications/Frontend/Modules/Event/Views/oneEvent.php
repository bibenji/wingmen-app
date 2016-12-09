<div class="row">
<div class="col-lg-7 col-md-7 one-module">
	
	<?php
	var_dump($event->isPast());
	?>
	
	<div class="row">
	<div class="col-md-12">
		<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

		<h2><?php echo $event['event_name']; ?></h2>
		<h4>Evénement prévu <mark><?php echo $event['event_time']->getStringtime(); ?></mark>.</h4>
		
		<?php
		$match = preg_match("/.*\d{5}\s(\w+),{0,1}.*/", $event['event_lieu'], $matches);
		if ($user->isConnected() OR !$match) { ?>
		<span><?php echo $event['event_lieu']; ?>.</span>
		<?php } else { ?>
		<span><?php echo $matches[1]; ?>.</span>
		<?php } ?>
		
		
		<input type="hidden" id="hidden_coordos" value="<?php echo $event['event_coordos']; ?>" />
		
		<table class="table">
		<tfoot>
			<tr class="text-center">
				<th width="25%">Un événement de type</th>
				<th width="25%">Heure du rendez-vous</th>
				<th width="25%">Inscrit(s) / Nombre max de participants</th>
				<th width="25%">Organisé par</th>
			</tr>	
		</tfoot>
		<tbody>
			<tr>
				<td colspan="3">
					<?php echo nl2br($event['event_description']); ?>
					<br />
					<?php if ($event['dateAjout'] != $event['dateModif']) { ?>
					<p class="modified"><em>Modifiée le <?php echo $event['dateModif']->format('d/m/Y à H\hi'); ?></em></p>
					<?php } ?>
				</td>
				<td>
					<p>Participant(s) :</p>
					<ul>
						<?php foreach ($inscrits as $inscrit) {
							echo '<li><a href="/MON_APP/Web/zonemb/'.$inscrit['id'].'/'.$inscrit['pseudo'].'/">'.$inscrit['pseudo'].'</a></li>';
						} ?>						
					</ul>
				</td>
			</tr>
			<tr class="text-center">
				<?php $type_event = ($event['event_type'] ? $event['event_type'] : 'NPU'); ?>
				<td><img class="show-event-em legende-img" src="/MON_APP/Web/img/event-<?php echo $type_event; ?>.png" alt="<?php echo $type_event; ?>" /></td>
				<td><div class="show-event-em alert alert-warning"><?php echo $event['event_time']->getHourtime(); ?></div></td>
				<td><div class="show-event-em alert alert-warning"><?php echo $nb_inscrits; ?> / <?php echo $event['event_max']; ?></div></td>
				<td>
					<?php if ($event['avatar'] != '') {
						echo '<img class="show-event-em legende-img" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/'.$event['avatar'].'" /></div>';
					}
					else {
						echo '<img class="show-event-em legende-img" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/RANDAVATS/'.mt_rand(1,7).'.jpg" /></div>';	
					}
					?><br />
					<?php echo $event['pseudo']; ?>
				</td>
			</tr>
		</tbody>
		</table>
		
		
			<?php
			if ($user->isConnected())
			{
				echo '<p>';				
				if ($user->id() == $event['creator'])
				{
					?>
					<a class="btn btn-success btn-lg" href="zonemb/event-<?php echo $event['id']; ?>/update.html">Modifier l'événement</a> &nbsp; <a class="btn btn-danger btn-lg <?php if ($event->isPast()) echo 'disabled'; ?>" href="zonemb/event-<?php echo $event['id']; ?>/delete.html">Supprimer l'événement</a>
					<?php
				}
				else
				{			
					if(!$estinscrit)
					{						
						if ( ( $nb_inscrits / $event['event_max'] ) < 1 )
						{
						?>
						<a class="btn btn-info btn-lg <?php if ($event->isPast()) echo 'disabled'; ?>" href="/MON_APP/Web/zonemb/event-<?php echo $event['id']; ?>/inscription.html">Je participe !</a>
						<?php
						}
						else
						{
							?>
							<span class="alert alert-warning">Désolé, cet événement est complet !</span>
							<?php
						}
					}
					else
					{
						?>
						<a class="btn btn-warning btn-lg <?php if ($event->isPast()) echo 'disabled'; ?>" href="/MON_APP/Web/zonemb/event-<?php echo $event['id']; ?>/desinscription.html">Me désinscrire</a>
						<?php
					}				
				}
				echo '</p>';
			?>
		
				<!--
				<button type="button" class="btn btn-info btn-lg" />Je participe !</button>
				<button type="button" class="btn btn-warning btn-lg" />Me désinscrire</button>
				<button type="button" class="btn btn-success btn-lg" />Modifier l'événement</button>
				<button type="button" class="btn btn-danger btn-lg" />Supprimer l'événement</button>
				-->
		
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-12 zone-commentaires">
			<h2>Commentaires</h2>
			<?php if (empty($comments))
			{ ?>
			<div class="row">
				<div class="col-md-12">
					<p>Aucun commentaire n'a encore été posté. Soyez le premier à engager la conversation !</p>
				</div>
			</div>
			<?php }	else { ?>
			<?php foreach ($comments as $comment) { ?>
			
			<div class="row">
				<div class="col-md-1"><img class="img-circle img-conv-com" src="<?php if ($comment['mb_avatar'] != '') {
					echo '/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/'.$comment['mb_avatar'];
					}
					else {
						echo '/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/RANDAVATS/'.mt_rand(1,7).'.jpg';	
					}
				?>" alt="<?php $comment['com_creator']; ?>" /></div>
				<div class="col-md-7">
					<p>Le <?php echo $comment['date']->format('d/m/Y à H\hi'); ?>, <?php echo htmlspecialchars($comment['com_creator']); ?> a écrit :</p>
					<p><?php echo nl2br(htmlspecialchars($comment['com_text'])); ?></p>
				</div>
				<div class="col-md-3">
					<?php if ($user->isConnected() AND $user->id() == $comment['com_creator_id']) { ?>
						<p>
							<a href="zonemb/comment-update-<?php echo $comment['id']; ?>.html">Modifier</a>
							&nbsp;
							<a href="zonemb/comment-delete-<?php echo $comment['id']; ?>.html">Supprimer</a>
						</p>
					<?php } ?>					
				</div>
			</div>
			<br />
			
			<?php } ?>
			<?php } ?>			
			
			<p class="text-center">
			<!--<button type="button" class="btn btn-primary btn-sm" />Ecrire un commentaire</button>-->
			<a href="zonemb/commenter-<?php echo $event['id']; ?>.html" class="btn btn-primary">Ecrire un commentaire</a>
			</p>
		</div>
	</div>

</div>


<div class="col-lg-5 col-md-5">

<div class="right-module">

	<h3>Visualisez le lieu de rendez-vous :</h3>

	<div id="map" style="width: 100%; height: 400px;"></div>

	<script type="text/javascript">

	// init
	var three = document.getElementById('hidden_coordos');
		
	var coordos = three.value;
	if (coordos) {
		coordos = three.value.replace("(", "");
		coordos = coordos.replace(")", "");
	}
	else {
		coordos = '48.856614, 2.3522219000000177';
	}
	
	// var coordos = '48.856614, 2.3522219000000177';
	
	coordos = coordos.split(", ");
	
	console.log(coordos);

	// init map	
	var geocoder;
	var map;
	var marker;
	
	function initMap() { 		
		geocoder = new google.maps.Geocoder();		
		var latlng = new google.maps.LatLng(coordos[0], coordos[1]);
		var mapOptions = {
		  zoom: 15,
		  center: latlng
		}
		map = new google.maps.Map(document.getElementById("map"), mapOptions);
		
		var myLatLng = {lat: Number(coordos[0]), lng: Number(coordos[1])};

		
		marker = new google.maps.Marker({
			map: map,
			position: myLatLng
		});
	}	

	</script>

	<script async defer
	  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTVggkKKJlMXmfErWlQmTfIi0imcigcdc&callback=initMap">
	</script>
	
	<br />
	
	<?php
	if (!$event['event_coordos']) { ?>		
		<p class="alert alert-info text-center"><?php echo 'Erreur lors de l\'enregistrement du lieu !'; ?></p>
	<?php } ?>
	
</div>

</div>

			<?php
			}
			else
			{
			?>
			<p class="alert alert-warning text-center">Vous devez être connecté pour accéder à cet événement, vous inscrire et pouvoir lire les commentaires...</p>
			</div>
			</div>
			</div>
			
			
			
			<?php			
			}
			?>
			

</div>