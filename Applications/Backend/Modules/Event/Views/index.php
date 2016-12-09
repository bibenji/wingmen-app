<p style="text-align: center">Il y a actuellement <?php echo $nombreEvents; ?> news. En voici la liste :</p>

<table>
<tr><th>Creator</th><th>Event_name</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr>

<?php
foreach ($listeEvents as $event)
{
	echo '<tr><td>', $event['creator'], '</td><td>', $event['event_name'],
		'</td><td>le ', $event['dateAjout']->format('d/m/Y à H\hi'),
		'</td><td>', ($event['dateAjout'] == $event['dateModif'] ? '-' : 'le
		'.$event['dateModif']->format('d/m/Y à H\hi')), '</td><td><a	href="event-update-', $event['id'], '.html">
		<img src="../images/update.png" alt="Modifier" /></a> <a href="event-delete-',
		$event['id'], '.html"><img src="../images/delete.png" alt="Supprimer" /></a></td></tr>', "\n";
}
?>
</table>