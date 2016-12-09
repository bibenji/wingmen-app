$(document).ready(function(){
	
	
	
	$( document ).ready(function() {
		// $('#info-flash').fadeIn();
	});
	
	if ($('#info-flash')) {
		$('#info-flash').fadeIn(500, function() {
			setTimeout(function() {
				$('#info-flash').fadeOut(1000);
			}, 10000);
		});
		$('#info-flash').click(function() {
			$('#info-flash').fadeOut(1000);
		});
	}
	
	/*
    $("button").click(function(){
        $("#div1").fadeIn();
        $("#div2").fadeIn("slow");
        $("#div3").fadeIn(3000);
    });
	*/
});