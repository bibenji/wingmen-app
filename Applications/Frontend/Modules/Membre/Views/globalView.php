<div class="row">
<div class="col-lg-8 col-md-8 one-module">
<div class="one-module-controls"><a href="index.php"><span class="">X</span></a></div>

<h2>Tour de Contrôle</h2>
<span>Vue générale du compte.</span>

<br /><br />

<div class="row">
	<div class="col-lg-4 col-md-12">
	
		<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><strong>Messagerie</strong></div>
				<div class="panel-body">
					<div class="alert alert-info text-center"><a href="/MON_APP/Web/zonemb/messagerie/" class="alert-link"><?php echo $new_mess; ?><br /><br />Nouveau(x) message(s) !</a></div>
				</div>
			</div>	
		</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Notifications</strong></div>
					<div class="panel-body">
						<div class="alert alert-success text-center"><a href="/MON_APP/Web/zonemb/notifs/" class="alert-link"><?php echo $new_notifs; ?><br /><br />Nouvelle(s) notification(s) !</a></div>
					</div>
				</div>	
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Prochain événement</strong></div>
					<div class="panel-body">
						<div class="alert alert-warning text-center">
							<?php if ($next_event['event_name'] != '') { ?>
								<a href="/MON_APP/Web/event-<?php echo $next_event['id']; ?>.html" class="alert-link">
									<?php echo $next_event['event_name']; ?>
									<br />
									<?php echo $next_event['event_date']->getStringdate(); ?>
									<br />
									<?php echo $next_event['event_lieu']; ?>
								</a>
							<?php } else { ?>
								<a href="/MON_APP/Web/events/0">Pas d'événements de prévus ?<br />Inscrivez-vous !</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info text-center"><a href="/MON_APP/Web/zonemb/new-event.html" class="alert-link">Proposer un nouvel événement</a></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info text-center"><a href="/MON_APP/Web/zonemb/historique/" class="alert-link">Afficher l'historique des événements</a></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info text-center"><a href="/MON_APP/Web/zonemb/params/" class="alert-link">Paramètres de mon compte</a></div>
			</div>
		</div>
		
	</div>
	
	<div class="col-lg-8 col-md-12">
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Evénements auxquels je participe</strong></div>
					<div class="panel-body">
									
						<table class="table">
							<?php
							foreach ($events as $event)
							{
							echo '<tr><td>'.$event['date']->getStringdate().'</td><td><a href="../event-'.$event['id'].'.html">'.$event['name'].'</a></td><td>'.$event['lieu'].'</td></tr>';
							}
							?>
						</table>
						
					</div>
				</div>	
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Evénements que j'ai proposés</strong></div>
					<div class="panel-body">
						
						<table class="table">
							<?php
							foreach ($created as $event) {
							echo '<tr><td>'.$event['date']->getStringdate().'</td><td><a href="../event-'.$event['id'].'.html">'.$event['name'].'</a></td><td>'.$event['lieu'].'</td></tr>';
							}
							?>				
						</table>
						
					</div>
				</div>	
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div><img class="legende-img" src="/MON_APP/Web/img/bandeau001.png" /></div>
			</div>
		</div>
		
	</div>
</div>

<br />

</div>

<div class="col-lg-4 col-md-4">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>