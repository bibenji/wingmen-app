<div class="row">
<div class="col-lg-7 col-md-7 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>To do</h2>
<span>Listing des améliorations à venir.</span>

<table class="table">
	<thead>
		<tr>
			<th>Amélioration</th>
			<th>Faite</th>
		</tr>
	</thead>
	<tbody>
		<tr class="info">
			<td>Avatar enregistré avec id membre pour simplifier la gestion (revient à mettre l'id pour l'enregistrement de l'avatar)</td>
			<td>Déjà fait</td>
		</tr>
		<tr class="info">
			<td>Champ âge dans les paramètres du compte -> date de naissance</td>
			<td>05/12/2016</td>
		</tr>
		<tr class="info">
			<td>Limiter les inscriptions au maximum de participants</td>
			<td>05/12/2016</td>
		</tr>
		<tr class="info">
			<td>Rechargement du compte après modifications (prise en compte nouvel avatar)</td>
			<td>05/12/2016</td>
		</tr>
		<tr class="info">
			<td>Vider le texte de l'input lors de l'enregistrement d'un nouveau commentaire lors de la création d'une nouvelle conversation qui ne se met pas à jour d'ailleurs !</td>
			<td>06/12/2016</td>
		</tr>
		<tr class="info">
			<td>Afficher l'avatar dans la vue avec tous les messages d'une conversation</td>
			<td>05/12/2016</td>
		</tr>
		<tr class="info">
			<td>Notifications uniquement après la date d'inscription à un événement</td>
			<td>03/12/2016</td>
		</tr>
		<tr class="info">
			<td>Affichage dans la liste des membres de la présentation plutôt que l'adresse</td>
			<td>03/12/2016</td>
		</tr>		
		<tr class="info">
			<td>Relire les entités 1</td>
			<td>03/12/2016</td>
		</tr>
		
		<tr class="warning">
			<td>affichage des avatars des inscrits à un événement</td>
			<td>à voir en fait  car public ?</td>
		</tr>
		<tr class="warning">
			<td>Meilleur affichage des dates</td>
			<td>commencé</td>
		</tr>
				
		<tr class="info">
			<td>API Google Map à programmer aussi pour les adresses des événements</td>
			<td>06/12/2016</td>
		</tr>		
		<tr class="warning">
			<td>Créer une page de présentation pour chaque membre</td>
			<td>commencé</td>
		</tr>
		<tr class="warning">
			<td>Améliorer les fonctionnalités de recherche (adresse notamment) et âge et distance</td>
			<td>commencé</td>
		</tr>
		<tr>
			<td>affichage des events à venir et des events passés</td>
			<td>commencé, reste à faire la sécurité pour les modifs/suppressions impossibles si passés et aussi l'affichage des événements annulés</td>
		</tr>
		<tr>
			<td>Intégrer les données de distance entre membre (fonction d'un membre pour calculer si il est loin d'un autre ou pas</td>
			<td></td>
		</tr>
		<tr class="warning">
			<td>dans la page d'affichage d'un événement mettre un lien vers la page des membres inscrits) et dans les notifs aussi (reste les notifs à faire) (intégrer le message dans le manager de notifs et non pas dans le controlleur)</td>
			<td>commencé</td>
		</tr>
		<tr class="danger">
			<td>meilleur affichage des avatars</td>
			<td></td>
		</tr>
		<tr class="warning">
			<td>modification et suppression que de ses commentaires et attention à la sécu !</td>
			<td>commencé</td>
		</tr>
		<tr>
			<td>Ajouter des membres dans une conversation</td>
			<td></td>
		</tr>
		<tr class="warning">
			<td>Mieux gérer les cas d'un événement annulé -> mettre événement annulé, faire une liste...</td>
			<td>commencé</td>
		</tr>
		<tr class="warning">
			<td>Gérer notifications et supprimer son compte</td>
			<td>commencé</td>
		</tr>
		<tr>
			<td>Retrouver son mot de passe (envoi mail avec new mdp)</td>
			<td></td>
		</tr>
		<tr>
			<td>bloquer des membres</td>
			<td></td>
		</tr>
		<tr>
			<td>Affichage des distances à un événement</td>
			<td></td>
		</tr>
		<tr>
			<td>adresse mail unique</td>
			<td></td>
		</tr>
		<tr>
			<td>faire le tri dans les modules</td>
			<td></td>
		</tr>
		<tr warning="danger">
			<td>bug au moment de changer la photo de style > voir si pas problème avec les noms d'avatar</td>
			<td>urgent</td>
		</tr>
		<tr class="info">
			<td>mieux gérer l'affichage des adresses pour les membres et les visiteurs et le reste</td>
			<td>07/12/2016</td>
		</tr>
		<tr>
			<td>Mettre au propre la bdd avec meilleurs intitulés</td>
			<td></td>
		</tr>
		<tr>
			<td>Mieux gérer l'enregistrement des avatars</td>
			<td></td>
		</tr>
		
	</tbody>
</table>

Fonctionnalités :

EN CLAIR :
<ul>
<li>- modifier son compte</li>
<li>- finir la mise en place de l'avatar</li>
<li>- mettre en place le système de fichiers lus/non-lus par conversations + la table conv pour discuter à plusieurs</li>
</ul>

MESSAGERIE :
<ul>
<li>- mettre en place le système de fichiers lus/non-lus par conversations + la table conv pour discuter à plusieurs</li>
<li>- créer un module qui gère les notifications</li>
<li>- supprimer les messages</li>
<li>- bloquer des utilisateurs</li>
</ul>

EVENEMENT :
<ul>
<li>- modifier un événement</li>
<li>- finir la gestion des formats d'heure car galère franchement</li>
<li>- rechercher des sorties précises</li>
<li>- limitation du nombres d'inscrits</li>
</ul>

MEMBRES :
<ul>
<li>- modifier son compte</li>
<li>- finir la mise en place de l'avatar</li>
<li>- rechercher selon des critères des membres</li>
</ul>

API GOOGLE MAP :
<ul>
<li>- enregistrer sa localisation où la zone de recherche</li>
<li>- afficher la carte</li>
<li>- au moment de la saisie de l'adresse</li>
</ul>


<?php
$date = date_create_from_format('Y-m-d H:i:s', '2016-10-12 18:10:12');
echo date_format($date, 'd/m/Y à H\hi');
?>

</div>
</div>




				<hr />


				<div class="row">
                    <div class="col-md-12">
                        <h2>Admin Dashboard</h2>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <h5>Widget Box One</h5>
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                            <div class="panel-body">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                                <h3>120 GB </h3>
                            </div>
                            <div class="panel-footer back-footer-blue">
                                Disk Space Available
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <h5>Widget Box Two</h5>
                        <div class="alert alert-info text-center">
                            <i class="fa fa-desktop fa-5x"></i>
                            <h3>100$ </h3>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Buttons Samples</h5>
                        <a href="#" class="btn btn-default">default</a>
                        <a href="#" class="btn btn-primary">primary</a>
                        <a href="#" class="btn btn-danger">danger</a>
                        <a href="#" class="btn btn-success">success</a>
                        <a href="#" class="btn btn-info">info</a>
                        <a href="#" class="btn btn-warning">warning</a>
                        <br />
                        <br />
                        <h5>Progressbar Samples</h5>
                        <div class="progress progress-striped">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                        <div class="progress progress-striped active">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- /. ROW  -->
                <hr />
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Text Input Example</label>
                            <input class="form-control" />
                            <p class="help-block">Help text here.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Click to see blank page</label>
                        <a href="blank.html" target="_blank" class="btn btn-danger btn-lg btn-block">BLANK PAGE</a>
                    </div>
                    <div class="col-md-4">
                        For More Examples Please visit official bootstrap website <a href="http://getbootstrap.com" target="_blank">getbootstrap.com</a>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-6">
                        <h5>Table  Sample One</h5>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-6">
                        <h5>Table  Sample Two</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="success">
                                        <td>1</td>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                    <tr class="info">
                                        <td>2</td>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                    </tr>
                                    <tr class="warning">
                                        <td>3</td>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                    <tr class="danger">
                                        <td>4</td>
                                        <td>John</td>
                                        <td>Smith</td>
                                        <td>@jsmith</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />


                <div class="row">
                    <div class="col-md-4">
                        <h5>Panel Sample</h5>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Default Panel
                            </div>
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                            </div>
                            <div class="panel-footer">
                                Panel Footer
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Accordion Sample</h5>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed">Collapsible Group Item #1</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Collapsible Group Item #2</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                                    <div class="panel-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">Collapsible Group Item #3</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                  

                                        <div class="panel-body">
                                             Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Tabs Sample</h5>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab">Home</a>
                            </li>
                            <li class=""><a href="#profile" data-toggle="tab">Profile</a>
                            </li>
                            <li class=""><a href="#messages" data-toggle="tab">Messages</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="home">
                                <h4>Home Tab</h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <h4>Profile Tab</h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                </p>

                            </div>
                            <div class="tab-pane fade" id="messages">
                                <h4>Messages Tab</h4>
                                <p >
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit eserunt mollit anim id est laborum.
                                </p>

                            </div>

                        </div>
                    </div>
					
					
					          </div>
                <!-- /. ROW  -->
                <hr />
                  <div class="row">
                    <div class="col-md-12">
                        <h5>Information</h5>
                            This is a type of bare admin that means you can customize your own admin using this admin structured  template . For More Examples of bootstrap elements or components please visit official bootstrap website <a href="http://getbootstrap.com" target="_blank">getbootstrap.com</a>
                        . And if you want full template please download <a href="http://www.binarytheme.com/bootstrap-free-admin-dashboard-template/" target="_blank" >FREE BCORE ADMIN </a>&nbsp;,&nbsp;  <a href="http://www.binarytheme.com/free-bootstrap-admin-template-siminta/" target="_blank" >FREE SIMINTA ADMIN</a> and <a href="http://binarycart.com/" target="_blank" >FREE BINARY ADMIN</a>.

                    </div>
                </div>
                <!-- /. ROW  -->