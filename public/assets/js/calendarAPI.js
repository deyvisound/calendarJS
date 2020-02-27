
/*
Busca as informações no servidor
*/
function ajaxFunction(){

	$.ajax({
	  method: "POST",
	  url: "/app/servidor.php",
	  data: { hoje: ""}
	})
	.done(function( contentJson ) {
	    preencherCalendario(contentJson);
  	})
  	.fail(function( error ){
  		alert( "Erro de comunicacao com servidor" + error );
  	});

}


function preencherCalendario(contentJson){

	let month = JSON.parse(contentJson);

	$('.dateText').html(month.dateParamText);

	//preenche os dias
	for(let i in month){
		if(isNaN(i))
			continue;

		let diaMes = month[i]['daymonth'];
		let data = month[i]['date'].replace("-","").replace("-","");
		let outroMes = ( month[i]['mesmoMes'] ? '' : 'outroMes');

		$('#bodyCalendar').find('.col').append('<div id='+data+' class="day '+outroMes+'">'+diaMes+'</div>')
	}

	

}

ajaxFunction()