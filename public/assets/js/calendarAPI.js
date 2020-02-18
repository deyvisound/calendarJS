

function ajaxFunction(){

	$.ajax({
	  method: "POST",
	  url: "/app/servidor.php",
	  data: { hoje: ""}
	})
	.done(function( msg ) {
	   // alert( msg );
  	})
  	.fail(function(){
  		alert( "fail" );
  	});

}

ajaxFunction()