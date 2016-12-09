$(function () {
		
	console.log('jQuery ready !');
	
	// $('#badge-mess').html('17');
	// $('#badge-notifs').html('18');
	
	var user_id = $('#user_id').val();
	
	console.log(user_id);
	
	function getNewMess() {
		$.ajax({
			method: "GET",
			url: "/MON_APP/Applications/Frontend/Modules/Messagerie/Ajax/newMess.php",
			data: { id_mb: user_id },
			//context: document.body
			statusCode: {
				404: function() {
					console.log( "newMess page not found" );
				}
			}
		}).done(function( rep ) {
			
			$('#badge-mess').html( rep );			
			console.log( this );			
			setTimeout(getNewMess, 60000); // req toutes les 30 secondes
		});
	}
	
	function getNewNotifs() {
		$.ajax({
			method: "GET",
			url: "/MON_APP/Applications/Frontend/Modules/Membre/Ajax/newNotifs.php",
			data: { id_mb: user_id },
			//context: document.body
			statusCode: {
				404: function() {
					console.log( "newNotifs page not found" );
				}
			}
		}).done(function( rep ) {
			
			$('#badge-notifs').html( rep );			
			console.log( this );
			console.log( rep );
			setTimeout(getNewNotifs, 60000); // req toutes les 30 secondes
		});
	}
	
	getNewMess();
	setTimeout(getNewNotifs, 1000);
	

	
});