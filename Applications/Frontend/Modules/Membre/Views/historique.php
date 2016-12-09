<div class="row">
<div class="col-lg-8 col-md-8 one-module">
<div class="one-module-controls"><a href="index.php"><span class="">X</span></a></div>

<h2>Historique</h2>
<span>Retrouvez-ici les événements passés.</span>

<br /><br />

<div class="row">
	<div class="col-lg-10 col-md-12">
			
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Evénements auxquels j'étais inscrit</strong></div>
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
					<div class="panel-heading"><strong>Evénements que j'avais proposés</strong></div>
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
		
		<br />
		
		<div class="row">
			<div class="col-md-12">
				
				<a href="/MON_APP/Web/zonemb/" class="btn btn-primary">Retour</a>
				
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