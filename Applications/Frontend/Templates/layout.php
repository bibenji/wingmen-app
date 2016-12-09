<!doctype html>
<html lang="fr">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php if(isset($title)) echo $title; else echo 'Wingmen App'; ?></title>
	
	<link rel="stylesheet" type="text/css" href="/MON_APP/Web/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/MON_APP/Web/css/added_styles.css" />
	
	<!--
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	-->
	
	<script src="/MON_APP/Web/js/jquery.min.js"></script>
	<script src="/MON_APP/Web/js/bootstrap.min.js"></script>
	
	<script src="/MON_APP/Web/js/alert.js" /></script>
		
</head>

<body>
	
	<div id="wrapper">
	
	<div id="info-flash">
		<?php if ($user->hasFlash()) { ?>
		<div id="mess-error">
		<p>Info Flash !</p>
		 <p style="text-align: center;"><?php echo $user->getFlash(); ?></p>
		</div>
		<?php } ?>
	</div>
	
	<!-- navbar -->
	<nav class="navbar navbar-light bg-faded" id="barre-nav">
		<a class="navbar-brand" href="/MON_APP/Web/"><img src="/MON_APP/Web/img/logo.png" id="img-logo" /></a>
		<ul class="nav navbar-nav pull-right">  
			<li class="nav-item active">
				<a class="nav-link" href="/MON_APP/Web/">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/MON_APP/Web/tipoftheday/">Tip Of The Day</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/MON_APP/Web/events/0">Events</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/MON_APP/Web/todo/">To Do</a>
			</li>
		</ul>
	</nav>
	

	
	<div class="row" id="main-row">
		<!-- colonne de gauche -->
		<div class="col-lg-2 col-md-3">
			
			<div class="left-menu">
				
				<?php
				if (isset($_SESSION['is_connected']) and $_SESSION['is_connected'] == true) {
				?>						
				
					<a href="/MON_APP/Web/zonemb/"><div class="btn-left"><?php echo $_SESSION['mb_connected']->mb_name(); ?></div></a>
					<div class="frame-col-left">
						<ul class="list-group connected-nav">
							<a href="/MON_APP/Web/zonemb/"><li class="list-group-item">
								<?php if (!is_null($_SESSION['mb_connected']->mb_avatar())) { ?>
								<img class="img-rounded connected-avatar" src="/MON_APP/Applications/Frontend/Modules/Membre/Ressources/Avatars/<?php echo $_SESSION['mb_connected']->mb_avatar(); ?>" />
								<?php } else { ?>
								<img class="img-rounded connected-avatar" src="/MON_APP/Web/img/avatar.png" />
								<?php } ?>
							</li></a>
							<a href="/MON_APP/Web/events/0"><li class="list-group-item"><span class="glyphicon glyphicon-screenshot"></span> Events </li></a>
							<a href="/MON_APP/Web/zonemb/membres/"><li class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span> Membres </li></a>
							<a href="/MON_APP/Web/zonemb/messagerie/"><li class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> Messagerie <span class="badge" id="badge-mess">E</span></li></a>
							<a href="/MON_APP/Web/zonemb/notifs/"><li class="list-group-item"><span class="glyphicon glyphicon-warning-sign"></span> Notifications <span class="badge" id="badge-notifs">E</span></li></a>
							<a href="/MON_APP/Web/zonemb/"><li class="list-group-item"><span class="glyphicon glyphicon-eye-open"></span> Vue générale</li></a>
							<a href="/MON_APP/Web/zonemb/params/"><li class="list-group-item"><span class="glyphicon glyphicon-wrench"></span> Paramètres</li></a>	
						</ul>		
					</div>
					<a href="/MON_APP/Web/events/0?deconnexion=1"><div class="btn-left">Déconnexion</div></a>
				
				<?php } else { ?>
				<button type="button" class="btn-left" data-toggle="collapse" data-target="#demo">Connexion</button>
				<div id="demo" class="collapse">
					<div class="frame-col-left">
						<div class="login">
							<form method="post" action="/MON_APP/Web/connexion/">
								<div class="form-group">	
									<input type="text" class="form-control" placeholder="PSEUDO" name="pseudo" />
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="PASSWORD" name="mdp" />
								</div>
								<input type="submit" value="Se connecter" class="btn btn-block btn-default" />
							</form>
							<br />
							<a href="/MON_APP/Web/forgot/">Forgot password?</a>							
						</div>
					</div>
				</div>
				<a href="/MON_APP/Web/inscription/"><div class="btn-left">Inscription</div></a>
				
				<?php } ?>
				
			</div>
			
		</div>
		
		<div class="col-lg-10 col-md-9" id="main">
			
			<?php echo $content; ?>
			
			<!--
		
			-->
			
		</div>
		
	</div>
	
	<footer class="row">
		<div class="col-md-6">
			<div class="text-center">
				<h3>Wingmen-App</h3>
				<p>Un site réalisé par bibenji</p>
				<p>Contact</p>
				<p>Admin</p>
				<p>To Do</p>				
			</div>
		</div>
		<div class="col-md-6">
			<img src="/MON_APP/Web/img/bad-girl-2.png" style="width: 75%;" />
		</div>
	</footer>
	
	</div>

<?php if (isset($_SESSION['is_connected']) and $_SESSION['is_connected'] == true) { ?>
<input type="hidden" id="user_id" value="<?php echo $_SESSION['mb_connected']->mb_id(); ?>" />
<script src="/MON_APP/Web/js/jq.js"></script>
<?php } ?>

</body>
</html>

