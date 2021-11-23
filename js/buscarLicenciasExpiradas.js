let pagina = getParameterByName('page');
let consulta = getParameterByName('input');
$(document).ready(function() {
	$('.busqueda input').on('keyup', function(){
		var codigo = event.which || event.keyCode;
	    if(codigo == 13) {
			var valor = $(this).val();		
    		result = window.location;
    		newurl = result.pathname + '?input='+valor;
	    	console.log(newurl);
			window.location = newurl;
	    }
	});
	$('.while-search').removeClass('hide');
	document.getElementById("search").value = consulta;
	$(buscar_datos(consulta));
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function buscar_datos(consulta) {
	$.ajax({
      	type: 'POST',
      	url: '../componentes/vista-licencias-expiradas.php',
      	dataType: 'html',
		data: {
			documento: DocumentoJS,
			pagina: pagina,
			consulta: consulta
		},
		beforeSend: function() {
        	$('.while-search').removeClass('hide');
        },
	})
    .done(function(respuesta) {
		$('.while-search').addClass('hide');
		$('.datos').html(respuesta);
		
		$('.toasts-admin').on('click', function() {
			let toastAdmin = '<span>No puedes <strong>autoevaluarte.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		  	M.toast({html: toastAdmin, displayLength: 5000});
		});
	})
	.fail( function( jqXHR, textStatus, errorThrown ) {
        if (jqXHR.status === 0) {
        	let toastFail = '<span>Verifica tu conexion a internet.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else if (jqXHR.status == 404) {
        	let toastFail = '<span>Página solicitada no encontrada [400].</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else if (jqXHR.status == 500) {
        	let toastFail = '<span>Error interno del servidor [500].</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else if (textStatus === 'parsererror') {
        	let toastFail = '<span>Error al analizar el archivo solicitado.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else if (textStatus === 'timeout') {
        	let toastFail = '<span>Tiempo de espera exedido.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else if (textStatus === 'abort') {
        	let toastFail = '<span>Petición Abortada.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        } 
        else {
        	let toastFail = '<span>Error desconocido.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFail, displayLength: 5000});
        }
    })
}