<?php

$db = new \PDO('mysql:host=localhost;dbname=wingmen', 'root', '');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$q = $db->query('
	SELECT COUNT(n.id_notif)
	FROM notifs_liste n, membres m, inscriptions i
	WHERE n.id_event = i.id_event
	AND i.id_inscrit = '.(int)$_GET['id_mb'].'
	AND m.id = '.(int)$_GET['id_mb'].'
	AND m.saw_notifs < n.date_notif
	AND i.date_inscription < n.date_notif
	AND (n.id_membre <> '.(int)$_GET['id_mb'].' OR n.id_membre <> m.id OR n.id_membre IS NULL)
	');
echo $q->fetchColumn();

?>