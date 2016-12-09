<div class="row">
<div class="col-lg-7 col-md-6 one-module">
<div class="one-module-controls"><a href="/MON_APP/Web/"><span class="">X</span></a></div>

<h2>Proposer un événement</h2>
<h4>Organisez ici votre propre événement !</h4>

<div class="row">
	<div class="col-lg-7 col-md-8">
	
		<?php require '_form.php'; ?>
	
	</div>
	<div class="col-lg-5 col-md-4">
		<img src="/MON_APP/Web/img/secretary.png" style="margin-top: 75px;" />
	</div>
</div>

</div>

<div class="col-lg-5 col-md-6">

<div class="right-module">

	<h3>Visualisez le lieu de rendez-vous :</h3>

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

</div>

</div>