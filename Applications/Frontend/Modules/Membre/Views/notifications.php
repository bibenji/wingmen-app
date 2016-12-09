<div class="row">
<div class="col-lg-6 col-md-8 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>Notifications</h2>
<span>Affichage des 20 dernières notifications reçues.</span>

<br /><br />

<table class="table table-condensed table-striped" style="font-size: 90%">
<thead>
	<tr>
		<th>Date</th>
		<th>Type</th>
		<th>Concerne</th>
		<th width="50%">Notification</th>		
		<th></th>		
	</tr>
</thead>
<tbody>

	<?php foreach ($lesnotifs as $notif) {	
		// $saw_notifs = date_create_from_format('Y-m-d H:i:s', $notif['saw_notifs']);
		// $date_notif = date_create_from_format('Y-m-d H:i:s', $notif['date_notif']);
		$date_notif = $notif->date_notif()->getDatetime()->add(new DateInterval('PT20S'));
		$new_or_not = ($notif->saw_notifs()->getDatetime() <= $date_notif);
	?>	
	
	<tr class="<?php if ($new_or_not) echo 'warning'; ?>">
		<td><?php echo $notif->date_notif()->getStringtime(); ?></td>
		<td><?php
			echo ($notif['type_notif'] ? $notif['type_notif'] : 'Non-défini');
		?></td>
		<td>		
			<?php echo $notif['event_name']; ?>
		</td>
		<td><?php echo $notif['content_notif']; ?></td>
		<td><?php if ($new_or_not) echo 'Nouvelle notification !'; ?></td>
	</tr>
	
	<?php } ?>
	
</tbody>
</table>

</div>

<div class="col-lg-6 col-md-4">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>