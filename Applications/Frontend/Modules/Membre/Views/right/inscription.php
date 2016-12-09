<h5>Visualisez votre localisation :</h5>

<div id="map" style="width: 100%; height: 200px;"></div>

<script type="text/javascript">

// init inputs
var one = document.getElementById('entered_adr');	
var two = document.getElementById('true_adr');
var three = document.getElementById('true_coordos');
var keyspressed = 0;

// init map	
var geocoder;
var map;
function initMap() { 		
	geocoder = new google.maps.Geocoder();		
	var latlng = new google.maps.LatLng(48.856614, 2.3522219000000177);
	var mapOptions = {
	  zoom: 15,
	  center: latlng
	}
	map = new google.maps.Map(document.getElementById("map"), mapOptions);
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
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
			
		}
		else if (status == "OVER_QUERY_LIMIT") {
			setTimeout(function() {
				console.log('try again');
				codeAddress();
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