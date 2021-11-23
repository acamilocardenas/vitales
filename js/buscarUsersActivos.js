let pagina = getParameterByName('page');
let consulta = getParameterByName('input');
let cambiarEstado;
let result;
let newurl;
$(document).ready(function() {
	var estadoUpdate = localStorage.getItem('updateEstado');
	if(estadoUpdate == 'yes') {
		let toastUpdate = '<span>La actualización del estado se ha realizado <strong>correctamente</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	  	M.toast({html: toastUpdate, displayLength: 5000});
	  	localStorage.removeItem('updateEstado');
	}
	
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
      	url: '../componentes/vista-delete-usuarios.php',
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
			let toastAdmin = '<span>No puedes <strong>autodesactivarte.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
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
function ConfirmarCambiarEstado(nombre, apellido, id, hash, estado) {
	cambiarEstado = false;
   if(estado == '1'){ 
   		$('#estados .info_estado').html('¿Deseas <b>desactivar</b> el usuario <b>'+nombre+' '+apellido+'</b> (CC: '+id+')?.<br><i>Este usuario NO podrá iniciar sección y tampoco podrá ser evaluado.</i>');
   		$('#estados .titulo').html('DESACTIVAR USUARIO');
   		$('#estados .btn').html('Si, desactivar');
   } else { 
   		$('#estados .info_estado').html('¿Deseas <b>activar</b> el <b>'+nombre+' '+apellido+'</b> (CC: '+id+')?.<br><i>Este usuario ya podrá iniciar sección y aparecera en la lista para ser evaluado.<br>Su historial sera restaurado.</i>');
   		$('#estados .titulo').html('ACTIVAR USUARIO');
   		$('#estados .btn').html('Si, activar');
   }
   $('#estados').modal(
   	{
   		onCloseEnd: function(trigger) { // Callback for Modal close
        console.log('cambiarEstado: '+cambiarEstado);
        if (cambiarEstado == true) {
        	if(estado == '1'){
        		CambiarEstado(id, hash, '0');
        	}
        	else {
        		CambiarEstado(id, hash, '1');
        	}
        }
      } 
   	});
   $('#estados').modal('open');
}
function CambiarEstado(id, hash, estadoChange) {
	$.ajax({
      	type: 'POST',
      	url: 'update.php',
		data: {
	        Form: 'UpdateEstado',
			Documento: id,
			Hash: hash,
	        Estado: estadoChange,
		},beforeSend: function() {
        	$('.while-update').removeClass('hide');
        	$('.datos').hide();
        },success: function(obj) {
			if(obj == 1){
				localStorage.setItem('updateEstado', 'yes');
				window.location.reload(); 
			} else {
				let toastUpdate = '<span><strong>Error.</strong> No se pudo actualizar el estado.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  				M.toast({html: toastUpdate, displayLength: 5000});
			}
        }, error: function(obj, error, objError) {
            if(navigator.onLine == true) {
            	let toastError = '<span>Algo salio mal intente de nuevo.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
				M.toast({html: toastError, displayLength: 5000});
            }
            else {
            	let toastError = '<span>Verifica tu conexion a internet.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
				M.toast({html: toastError, displayLength: 5000});
            }
        }
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