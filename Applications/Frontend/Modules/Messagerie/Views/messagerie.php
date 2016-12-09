<div class="row">
<div class="col-lg-8 col-md-8 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>Messagerie</h2>
<span>Consultation des messages.</span>

<table class="table table-bordered table-hover table-striped">
<thead>
	<tr>
		<th width="30%">Conversation avec</th>
		<th>Dernier message</th>
		<th></th>
		<th width="15%">Actions</th>
	</tr>
</thead>
<tbody>
		
	<?php foreach ($mess as $num => $one_mess) { ?>
	
	<tr data-href="/MON_APP/Web/zonemb/new-mess-conv-<?php echo $one_mess->id_conv; ?>.html" <?php
		$datetime1 = $one_mess->mess_date;
		$datetime2 = $one_mess->lasttrack;
		if ($datetime1 > $datetime2) echo 'class="warning"'; ?>>		
		<td>
			<div class="avatar-conv-with">
				<?php
				$avatars = explode(',', $one_mess->avatars);
				foreach ($avatars as $avatar) {				
				echo '<img src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/',
						(($avatar != '') ? $avatar : 'RANDAVATS/'.mt_rand(1,7).'.jpg'),
						'" class="img-circle img-conv-com" alt="" />';
				} ?>
				<br />
				<?php
					// à revoir
					echo $one_mess->participants;					
				?>
			</div>
		</td>
		<td>
			<strong><?php echo $one_mess->mess_date; ?></strong>, <?php echo $one_mess->mess_from; ?> a écrit :<br />
			<em>"<?php echo $one_mess->mess_text; ?>"</em>
		</td>
		<td>
			<?php 				
				if ($datetime1 > $datetime2) {
					echo '<span class="glyphicon glyphicon-envelope"></span> Nouveau(x) message(s) !';
				}
				else {
					echo 'Lu le '.$datetime2;
				}					
			?>
			
		</td>
		<td>
			<div class="icon-mess">
				<a href="/MON_APP/Web/zonemb/new-mess-conv-<?php echo $one_mess->id_conv; ?>.html">
					<img src="/MON_APP/Web/img/reply.png" alt="Répondre" />
				</a>
				<a href="">
					<img src="/MON_APP/Web/img/leave.png" alt="Quitter" />
				</a>
			</div>
		</td>
	</tr>	
	
	<?php } ?>

</tbody>
</table>

</div>

<div class="col-lg-4 col-md-4">
	<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
</div>

</div>

<!-- script pour links tr -->
<script src="/MON_APP/Web/js/jq-messagerie.js"></script>