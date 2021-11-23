let whileSendDelete;
let whileSendAdd;
$(document).ready(function() {
	let btnDelete;
    let btnAdd;
    const actualBrithday = FechaNacEvaJs.concat(' ', 'T00:00:00');
    let array_fecha = actualBrithday.split(' ');
    let dia = array_fecha[0];
    let mes = ConvertMes(array_fecha[1]);
    let año = array_fecha[2];
    let zonaHora = array_fecha[3];
    let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);
    let fechaActual = new Date(formatoDate);

    let minDate = new Date(fechaActual);
        minDate.setFullYear(minDate.getFullYear() + 16);

    $('.tabs').tabs();
    $('.datepicker').datepicker({
        defaultDate: new Date(),
        format: 'dd mmm, yyyy',
        minDate: new Date(minDate),
        maxDate: new Date(),
        minYear: new Date(minDate).getFullYear(),
        maxYear: new Date().getFullYear()
    });

    $('.add-sancion').hide();
    //validación tiempo real fecha nacimiento
    $('.datepicker').on('change', function() {
        let Nacimiento = this.value;
        let array_fecha = Nacimiento.split(' ');
        let año = parseInt(array_fecha[2]);
        if (Nacimiento.length < 1 || Nacimiento == '' || Nacimiento == undefined) {
            $(this).removeClass("valid").addClass("invalid");
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    setTimeout(function() {
        $('.before-update').fadeOut('slow', 'swing');
    }, 3500);

	$('.delete-sancion-btn').hover(
		function() {
	    	$(this).removeClass('grey').addClass('red');
	  	}, function() {
	    	$(this).removeClass('red').addClass('grey');
  	});
    $('.add-sancion-btn').hover(
        function() {
            $(this).removeClass('grey').addClass('green');
        }, function() {
            $(this).removeClass('green').addClass('grey');
    });

  	$('.delete-sancion-btn').on('click', function () {
  		btnDelete = $(this);
  		$(this).hide();
  		$(this).parent().parent().children('.delete-sancion').removeClass('hide');
  	});

    $('.add-sancion-btn').on('click', function () {
        $('.datepicker').removeClass("valid invalid");
        $('.datepicker').val('');
        M.updateTextFields();
        $('.add-sancion-btn').show();
        $('.add-sancion').hide();
        btnAdd = $(this);
        $(this).hide();
        $(this).parent().parent().parent().children('li:nth-child(2)').show();
    });

  	$('.cancel-delete-btn').on('click', function (){
  		$(this).parent().parent().parent().parent().addClass('hide');
  		btnDelete.show();
  	});
    $('.close-add-sancion-btn').on('click', function () {
        $('.datepicker').removeClass("valid invalid");
        $('.datepicker').val('');
        M.updateTextFields();
        $('.add-sancion-btn').show();
        $(this).parent().parent().parent().parent().children('li:nth-child(2)').hide();
    });
    $('.confir-add-sancion-btn').on('click', function() {
        let dateDocumento =  $(this).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').children('.input-form').children('.HInfractor').children('input').get(0).value;
        let dateNorma =  $(this).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').children('.input-form').children('.HNorma').children('input').get(0).value;
        let dateEvaluador =  $(this).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').children('.input-form').children('.HEvaluador').children('input').get(0).value;
        let dateInfraccion =  $(this).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').children('.input-form').children('.HInfraccion').children('input').get(0).value;
        if (dateInfraccion == '' || dateInfraccion == undefined) {
            $(this).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').children('.input-form').children('.HInfraccion').children('input').removeClass("valid").addClass("invalid");
            let toastApellidos = '<span>Por favor indica la <strong>Fecha</strong> en que se cometió la infracción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastApellidos, displayLength: 5000});
        }
        else {
            whileSendAdd = $(this);
            dateInfraccion = dateInfraccion.concat(' ', 'T00:00:00');
            let array_fecha = dateInfraccion.split(' ');
            let dia = array_fecha[0];
            let mes = ConvertMes(array_fecha[1]);
            let año = array_fecha[2];
            let zonaHora = array_fecha[3];
            let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);
            let fechaInfraccion = new Date(formatoDate).format("yyyy-mm-dd");
            var datosAddSancion =
            {
                Documento: dateDocumento,
                Form: 'AddSancion',
                Norma: dateNorma,
                Evaluador: dateEvaluador,
                Infraccion: fechaInfraccion

            };
            update(datosAddSancion, 'AddSancion');
        }
    });

});
function eliminarSancion(e, idUsuario, idNorma, fechaInfraccion, registro, idEvaluador) {
 	whileSendDelete = e;
 	let dateInfraccion = new Date(fechaInfraccion.concat('', 'T00:00:00')).format("yyyy-mm-dd");
 	let dateRegistro = new Date(registro.concat('', 'T00:00:00')).format("yyyy-mm-dd");
 	let datosSanDelete =
    {
    	Documento: idUsuario,
    	Form: 'DeleteSancion',
    	Norma: idNorma,
    	Evaluador: idEvaluador,
    	Infraccion: dateInfraccion,
    	Registro: dateRegistro
    };
    console.log(datosSanDelete);
    update(datosSanDelete, 'DeleteSancion');
}

function update(datos, tipo) {
	$.ajax ({
        type: "POST",
        url: "update.php",
        data: datos, 
        beforeSend: function() {
        	if(tipo == 'DeleteSancion') {
        		$(whileSendDelete).parent().parent().parent().parent().addClass('hide');
 				$(whileSendDelete).parent().parent().parent().parent().parent().children('p').addClass('hide');
 				$(whileSendDelete).parent().parent().parent().parent().parent().children('.while-delete-sancion').removeClass('hide');
        	} else if(tipo == 'AddSancion') {
                $(whileSendAdd).parent().parent().parent().parent().children('li:nth-child(2)').children('.while-add-sancion').removeClass('hide');
                $(whileSendAdd).parent().parent().parent().parent().children('li:nth-child(2)').children('.form-add-sancion').hide();
            }
        	$('body').addClass('block');
        }, success: function(obj) {
			let result = window.location;
        	setTimeout(function() {
                if (obj == 1) {
					let newurl = result + '&evaluacion=OK';
					window.location = newurl;
                }  else {
					let newurl = result + '&evaluacion=ERROR';
					window.location = newurl;
                }
            }, 900);
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
    }).fail( function( jqXHR, textStatus, errorThrown ) {
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
    });
}
function ConvertMes(Mes) {
    switch (Mes) {
        case 'Enero,':
            return '01';
            break;       

        case 'Febrero,':
            return '02';
            break;  

        case 'Marzo,':
            return '03';
            break; 

        case 'Abril,':
            return '04';
            break;

        case 'Mayo,':
            return '05';
            break;    

        case 'Junio,':
            return '06';
            break;  

        case 'Julio,':
            return '07';
            break;

        case 'Agosto,':
            return '08';
            break;

        case 'Septiembre,':
            return '09';
            break;    

        case 'Octubre,':
            return '10';
            break;  

        case 'Noviembre,':
            return '11';
            break;     

        case 'Diciembre,':
            return '12';
            break;   

        default:
            break;
        }
   }