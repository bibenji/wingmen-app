<div class="row">
<div class="col-lg-8 col-md-8 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2><?php echo ($present ? 'Evénements à venir' : 'Evénements passés'); ?></h2>
<h4>Des players vous proposent de les rejoindre pour gamer...</h4>

<?php
	$date = new DateTime();
	$date = date_format($date, 'l d F');
	// echo $date.'<br /><br />';
	echo '<br />';
	
	foreach ($listeEvents as $event) {
		$new_date = $event['event_time']->getJustdate();
				
		if ($date != $new_date) {
			echo '<h5>Evénements du '.$event['event_time']->getStringdate().'</h5>';
			$date = $new_date;
		}			
?>

<div class="one-event">
	<div class="row">
		
		<div class="col-lg-2 col-md-12">
			<?php $type_event = ($event['event_type'] ? $event['event_type'] : 'NPU'); ?>
			<img class="type-event-img" src="/MON_APP/Web/img/event-<?php echo $type_event; ?>.png" alt="<?php echo $type_event; ?>" />
		</div>
		
		<div class="col-lg-6 col-md-12">
			<div class="row">
				<div class="col-md-12">
					<span class="titre-event"><?php echo $event['event_name']; ?></span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p>
					<br />
					<span class="description-event"><?php echo nl2br($event->event_shortDescription(200)); ?></span>
					</p>
					
					<?php
					$match = preg_match("/.*\d{5}\s(\w+),{0,1}.*/", $event['event_lieu'], $matches);
					if ($user->isConnected() OR !$match) { ?>
					<span><?php echo $event['event_lieu']; ?>.</span>
					<?php } else { ?>
					<span><?php echo $matches[1]; ?>.</span>
					<?php } ?>
					
				</div>			
			</div>						
		</div>
		
		<div class="col-lg-4 col-md-12">
			
			<div class="row">
			
				<div class="col-lg-12 col-md-12 text-center">
					
					<span class="label-event">
						<?php
							if ($event['inscrits'] == $event['event_max']) echo 'COMPLET';
							else { echo $event['inscrits']. ' / ' . $event['event_max'];}
						?>					
					</span>				
				
					<span class="label-event">
						<?php echo $event['event_time']->getHourtime(); ?>
					</span>				
					
					<span class="label-event">
						<?php echo $event['pseudo']; ?>
					</span>
				
				</div>
				<div class="col-lg-12 col-md-12 text-center">	
					
					<a href="../event-<?php echo $event['id']; ?>.html">
					<span class="label-event">						
						Voir les détails et s'inscrire						
					</span>
					</a>
					
					
				</div>			
			</div>
		</div>
		
	</div>
</div>

<?php } ?>

<div class="pagination-zone text-center">
	<ul class="pagination">
	<?php
	for ($i = 0; $i < $pages; $i++)	{
		$j = $i + 1;
		echo '<li><a href="/MON_APP/Web/';
		if (!$present) echo 'past-';
		echo 'events/'. $i .'">'. $j .'</a></li>';
	}
	 ?>
	</ul>
</div>

</div>

<div class="col-lg-4 col-md-4">
	<div class="right-module">
	<h3>Légende</h3>
	<div class="row">
		<div class="col-lg-4 col-md-12"><img src="/MON_APP/Web/img/event-spu.png" class="legende-img" /><br /><em>Street Pick Up</em></div>
		<div class="col-lg-4 col-md-12"><img src="/MON_APP/Web/img/event-npu.png" class="legende-img" /><br /><em>Night Pick Up</em></div>
		<div class="col-lg-4 col-md-12"><img src="/MON_APP/Web/img/event-ppu.png" class="legende-img" /><br /><em>Private Pick Up</em></div>
	</div>
	<h3>Rechercher un événement</h3>
	<div class="row">
		<div class="col-md-12">
		<form action="" method="post">
			<div class="input-group">
				<input type="text" class="form-control" disabled />
				<div class="input-group-btn">
					<button class="btn btn-default" type="submit">Rechercher<!--<i class="glyphicon glyphicon-search"></i>--></button>
				</div>
			</div>
		</form>
		</div>
	</div>
	<h3>Afficher les événements</h3>
	<div class="row">		
		<div class="col-md-12">
		<?php
		$presentBtn = '<a href="/MON_APP/Web/events/0" class="btn btn-primary btn-lg">Revenir aux événements à venir</a>';
		$pastBtn = '<a href="/MON_APP/Web/past-events/0" class="btn btn-primary btn-lg">Voir les événements passés</a>';
		$cancelBtn = '<a href="" class="btn btn-primary btn-lg">Voir les événements annulés</a>';
		
		$cancel = null;
		
		if ($present && !$cancel) {
			// événements présents affichés
			echo $pastBtn, '<br /><br />', $cancelBtn;
		}
		elseif (!$present && $cancel) {
			// événements annulés affichés
			echo $presentBtn, '<br /><br />', $pastBtn;
		}
		else {
			// événements passés affichés
			echo $presentBtn, '<br /><br />', $cancelBtn;
		}
		?>
		</div>
	</div>
	
	<?php if ($user->isConnected()) { ?>
	<h3>Proposer un événement</h3>
	<div class="row">
		<div class="col-md-12">
		<a href="/MON_APP/Web/zonemb/new-event.html" class="btn btn-primary btn-lg">Organiser</a>
		</div>
	</div>
	<?php } ?>
	<br />
	</div>
</div>

</div>