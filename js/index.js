let htmlancho;
let htmlalto;
let bodyancho;
let bodyalto;
let id;
let licencia2 = false;
let licencia3 = false;
let CancelarNewPassword = localStorage.getItem("CancelarNewPassword");


$(document).ready(function() {

	$('.container').scrollTop(0);

	// Inicializar componentes de materialize
	$('.tabs').tabs();
    let maxDateForm = new Date();
    let maxDate = maxDateForm.setFullYear(new Date().getFullYear() - 16 );
    let minDate = maxDateForm.setFullYear(new Date().getFullYear() - 80 );
	$('.ReNacimiento').datepicker({
        defaultDate: new Date(maxDate),
        format: 'dd mmm, yyyy',
        minDate: new Date(minDate),
        maxDate: new Date(maxDate),
        minYear: new Date(minDate).getFullYear()+1,
        maxYear: new Date(maxDate).getFullYear()
    });
	$('select').formSelect();
	$('.tooltipped').tooltip();
    $('.modal').modal();

    $('.btn-remover-licencia-dos').on('click', function(){
    	$(this).parent().parent().addClass('hide');
    	licencia2 = false;
    	$('.ReExpedicion2').val('').removeClass("valid invalid");
    	M.updateTextFields();
    	let Licencia = $('.ReLicencia select').val() + 0;
    	desableOpcionLicencias(Licencia);
    	if(licencia2 && licencia3) {
    		$('.btn-nueva-licencia').addClass('hide');
    	}
    	else {
    		$('.btn-nueva-licencia').removeClass('hide');
    		CambioVentana();
    	}
    });
    $('.btn-remover-licencia-tres').on('click', function(){
    	$(this).parent().parent().addClass('hide');
    	licencia3 = false;
    	$('.ReExpedicion3').val('').removeClass("valid invalid");
    	M.updateTextFields();
    	if(licencia2 && licencia3) {
    		$('.btn-nueva-licencia').addClass('hide');
    	}
    	else {
    		$('.btn-nueva-licencia').removeClass('hide');
    		CambioVentana();
    	}
    });
    $('.btn-nueva-licencia').on('click', function(){
    	if(!(licencia2)) {
    		licencia2 = true;
    		$('.nueva-licencia.dos').removeClass('hide');
    		let Licencia = $('.ReLicencia select').val();
    		desableOpcionLicencias(Licencia);
    	}else if(!(licencia3)) {
    		licencia3 = true;

    		$('.nueva-licencia.tres').removeClass('hide');
    		let Licencia = $('.ReLicencia select').val() + $('.ReLicencia2 select').val();
    		desableOpcionLicencias(Licencia);
    	}
    	if(licencia2 && licencia3) {
    		$('.btn-nueva-licencia').addClass('hide');
    	}
    	else {
    		$('.btn-nueva-licencia').removeClass('hide');
    		CambioVentana();
    	}
    });
    
	if(CancelarNewPassword == 1) {
		let mensajeLoguin = '<span>Cancelaste la petición para<strong><br>Restablecer tu contraseña.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
    	M.toast({html: mensajeLoguin, displayLength: 5000})
		localStorage.setItem("CancelarNewPassword", 0);
	}
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		$('.licencia .btn-small.btn-nueva-licencia').removeClass('hide');
		$('.licencia .btn-floating.btn-nueva-licencia').addClass('hide');
	}
	else {
		$('.licencia .btn-floating.btn-nueva-licencia').removeClass('hide');
		$('.licencia .btn-small.btn-nueva-licencia').addClass('hide');
	}

});


function desableOpcionLicencias(licencia) {
	switch (licencia) {
        case '1':
        case '2':
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
            $('.ReLicencia2 select').removeAttr('disabled');
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
            $('.ReLicencia3 select').prop('disabled', true);
            $('.ReLicencia2 select, .ReLicencia3 select').formSelect();
            break;
        case '3':
        case '4':
        case '5':
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
            $('.ReLicencia2 select').removeAttr('disabled');
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
            $('.ReLicencia3 select').prop('disabled', true);
            $('.ReLicencia2 select, .ReLicencia3 select').formSelect();
            break;
        case '6':
        case '7':
        case '8':
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
            $('.ReLicencia2 select').removeAttr('disabled');
		    $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
		    $('.ReLicencia3 select').prop('disabled', true);
		    $('.ReLicencia2 select, .ReLicencia3 select').formSelect();
            break;
        case '10':
        case '20':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
		    $('.ReLicencia2 select').prop('disabled', true);
		    $('.ReLicencia2 select, .ReLicencia3 select').formSelect();


            break;
        case '30':
        case '40':
        case '50':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
		    $('.ReLicencia2 select').prop('disabled', true);
		    $('.ReLicencia2 select, .ReLicencia3 select').formSelect();
            break;
        case '60':
        case '70':
        case '80':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia2 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option>');
		    $('.ReLicencia2 select').prop('disabled', true);
		    $('.ReLicencia2 select, .ReLicencia3 select').formSelect();
            break;
        case '36': case '37': case '38':
        case '46': case '47': case '48':
        case '56': case '57': case '58':
        case '63': case '64': case '65':
        case '73': case '74': case '75':
        case '83': case '84': case '85':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia3 select').formSelect();
            break;
        case '16': case '17': case '18':
        case '26': case '27': case '28':
        case '61': case '62':
        case '71': case '72':
        case '81': case '82':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia3 select').formSelect();
            break;
        case '13': case '14': case '15':
        case '23': case '24': case '25':
        case '31': case '32':
        case '41': case '42':
        case '51': case '52':
            $('.ReLicencia3 select').children().remove().end().append('<option value="0" disabled selected>Categoria de licencia</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
            $('.ReLicencia3 select').removeAttr('disabled');
            $('.ReLicencia3 select').formSelect();
            break;
        default:
            break;
    }
}


function CancelarCambio() {
	window.location='acceder.php'
	
}

// --------------------------------------------------------
// funcion para mantener ratio del bus
$(window).resize(function() {
   clearTimeout(id);
   id = setTimeout(CambioVentana(), 500);
});

function CambioVentana() {
    htmlancho = $('html').width();
    htmlalto = $('html').height();
    bodyancho = $('.camion').width();
    bodyalto = $('.camion').height();
    if($('.camion').hasClass('alto') && bodyancho > htmlancho)
    {
        $('.camion').removeClass('alto').addClass('ancho');
    }
    if($('.camion').hasClass('ancho') && bodyalto > htmlalto)
    {
        $('.camion').removeClass('ancho').addClass('alto');
    }
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('.licencia .btn-small.btn-nueva-licencia').removeClass('hide');
        $('.licencia .btn-floating.btn-nueva-licencia').addClass('hide');
    }
    else {
        $('.licencia .btn-floating.btn-nueva-licencia').removeClass('hide');
        $('.licencia .btn-small.btn-nueva-licencia').addClass('hide');
    }
}
// --------------------------------------------------------
//animar header al realizar scroll
    window.onscroll = scroll;
    var sc = window.pageYOffset;
    if (sc > 10) {
        $('.header').removeClass('navOff').addClass('navOn');
    } else if (sc < 10) {
        $('.header').removeClass('navOn').addClass('navOff');
    }

    function scroll() {
        var sc = window.pageYOffset;
        if (sc > 10) {
            $('.header').removeClass('navOff').addClass('navOn');
        } else if (sc < 10) {
            $('.header').removeClass('navOn').addClass('navOff');
        }
    }
// --------------------------------------------------------
// funcion para devolver scroll en los pop-up al cerrar
function scrollTopModal() {
    $('.modal-content').scrollTop(0);
}
// --------------------------------------------------------