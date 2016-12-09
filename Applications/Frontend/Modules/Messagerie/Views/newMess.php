<div class="row">
<div class="col-lg-8 col-md-10">

<div class="row">
	<div class="col-md-6">
		<h2>Conversation</h2>
	</div>
	<div class="col-md-6">
		<h2>Avec :</h2>
		<?php					
		if (isset($others)) {
			foreach ($others as $other) {				
				echo '<div class="big-avatar-conv-with">',
					'<img src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/',
					(($other['mb_avatar'] != '') ? $other['mb_avatar'] : 'RANDAVATS/'.mt_rand(1,7).'.jpg'),
					'" class="" alt="" />',
					'</div>';
			}
		}		
		?>
		
	</div>
</div>
	
	<?php
		
	foreach($mess as $one_mess) { ?>
	
	
	<div class="<?php if ($one_mess->mess_from != $user_id) echo 'one_mess_1'; else echo 'one_mess_2'; ?>">
		<?php if ($one_mess->mess_from != $user_id) echo $one_mess->mess_from_pseudo; else echo 'Vous'; ?><?php echo ', le '.$one_mess->mess_date.' :'; ?>
		<div>
		<?php echo $one_mess->mess_text; ?>
		</div>
	</div>
	<?php } ?>
	
<div class="clear"></div>

<h2>Nouveau message</h2>

<form action="" method="post">
<p>
<?php echo $form; ?>
</p>
<p class="text-center">
<input class="btn btn-success" type="submit" value="Envoyer" /> <input class="btn btn-warning" type="reset" value="Effacer" /> <a href="/MON_APP/Web/zonemb/messagerie/" class="btn btn-default">Retour aux messages</a>
</p>
</form>

</div>
</div>