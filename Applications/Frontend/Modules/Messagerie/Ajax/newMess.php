<?php

$db = new \PDO('mysql:host=localhost;dbname=wingmen', 'root', '');
$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$q = $db->query('
	SELECT COUNT(*)
	FROM (
	SELECT MAX(mess_date) last_mess_date, id_conv FROM messages
	WHERE id_conv IN
	(
		SELECT id_conv FROM participe WHERE id_membre = '.$_GET['id_mb'].'
	)
	GROUP BY id_conv
	) q, participe p
	WHERE id_membre = '.$_GET['id_mb'].'
	AND q.id_conv = p.id_conv
	AND q.last_mess_date > p.tracking
	');
echo $q->fetchColumn();

?>