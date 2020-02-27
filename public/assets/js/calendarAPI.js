
/*
Busca as informações no servidor
*/
function ajaxFunction(form, event){

	event.preventDefault();

	let data = $(form).serialize();

	$.ajax({
	  method: "POST",
	  url: "/app/servidor.php",
	  data: {data}
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
	$('#proximoMes').val(month.proximoMes);
	$('#mesAnterior').val(month.mesAnterior);

	cleanCalendar();

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

function cleanCalendar(){
	$('#bodyCalendar').find('.col').html('');
}

function initCalendar(){
	$.ajax({
	  method: "POST",
	  url: "/app/servidor.php",	 
	})
	.done(function( contentJson ) {
	    preencherCalendario(contentJson);
  	})
  	.fail(function( error ){
  		alert( "Erro de comunicacao com servidor" + error );
  	});
}


initCalendar();