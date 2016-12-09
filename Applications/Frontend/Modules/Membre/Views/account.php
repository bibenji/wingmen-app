<div class="row">
<div class="col-lg-7 col-md-6 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<?php if (isset($title) AND $title == "Inscription") { ?>
	<h2><?php echo $title; ?></h2>
	<h4>Inscrivez-vous pour pouvoir profiter de toutes les fonctionnalités du site !</h4>
<?php } else { ?>
	<h2>Modification de compte</h2>
	<h4>Modifiez-ici les paramètres de votre compte.</h4>
<?php } ?>

<div class="row">
<div class="col-lg-8 col-md-12">
<form action="" method="post" enctype="multipart/form-data">

	<?php echo $form; ?>
	
	<input type="submit" value="<?php 
		echo ( $title == "Inscription" ? "S'inscrire" : "Enregistrer les modifications" );
	?>" class="btn btn-success" /> <input type="reset" value="Recommencer" class="btn btn-warning" />
	
	<br /><br />
		
</form>
</div>
</div>

</div>

<div class="col-lg-5 col-md-6">

<?php if (isset($title) AND $title == "Inscription") { ?>
<img style="margin: 0px auto; display: block;" src="/MON_APP/Web/img/target.png" /><br /><br />
<?php } else { ?>
<div class="right-module">

	<h3>Visualisez votre localisation :</h3>

	<div id="map" style="width: 100%; height: 400px;"></div>

	<script type="text/javascript">

	// init inputs
	var one = document.getElementById('entered_adr');	
	var two = document.getElementById('true_adr');
	var three = document.getElementById('true_coordos');
	
	var coordos = three.value;
	if (coordos) {
		coordos = three.value.replace("(", "");
		coordos = coordos.replace(")", "");
	}
	else {
		coordos = '48.856614, 2.3522219000000177';
	}
	
	coordos = coordos.split(", ");
	
	console.log(coordos);
		
	var keyspressed = 0;

	// init map	
	var geocoder;
	var map;
	var marker;
	
	function initMap() { 		
		geocoder = new google.maps.Geocoder();		
		var latlng = new google.maps.LatLng(coordos[0], coordos[1]);
		var mapOptions = {
		  zoom: 15,
		  center: latlng
		}
		map = new google.maps.Map(document.getElementById("map"), mapOptions);
		
		var myLatLng = {lat: Number(coordos[0]), lng: Number(coordos[1])};

		
		marker = new google.maps.Marker({
			map: map,
			position: myLatLng
		});
	}

	// fonction codage adresse
	function codeAddress(adr) {			
		var address = adr;		
		geocoder.geocode( { 'address': address}, function(results, status) {
			
			if (status == google.maps.GeocoderStatus.OK) {
				var got = results[0].formatted_address;
				// var got = results[0].geometry.location;			
				two.value = results[0].formatted_address;
				three.value = results[0].geometry.location;
			
				map.setCenter(results[0].geometry.location);
				// marker.setMap(null);
				
				marker.setPosition(results[0].geometry.location);
				/*
				marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
				*/
				
			}
			else if (status == "OVER_QUERY_LIMIT") {
				setTimeout(function() {
					console.log('try again');
					codeAddress(address);
				}, 3000);
			}
			else {
				two.innerHTML = "Adresse introuvable";				
			}
		});
	}

	// event handler
	one.addEventListener("keyup", function() {	
		var nb_keyspressed = ++keyspressed;
		// console.log(nb_keyspressed + ' et ' + keyspressed);
		setTimeout(function() {
			if (nb_keyspressed == keyspressed) {
				codeAddress(one.value);
			}
		}, 1000);
		
		// codeAddress(this.value);
		
	});

	// init la map sur valeur du input
	// codeAddress(one.value);

	</script>

	<script async defer
	  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTVggkKKJlMXmfErWlQmTfIi0imcigcdc&callback=initMap">
	</script>
	
	<br />
	
</div>

<?php } ?>

</div>

</div>