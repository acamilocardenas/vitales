// modificar inputs por defecto
$(document).ready(function() {
    
    let maxDateForm = new Date();
    let maxDate = maxDateForm.setFullYear(new Date().getFullYear() - 16 );
    let minDate = maxDateForm.setFullYear(new Date().getFullYear() - 80 );
    $('.FoNacimiento').datepicker({
        defaultDate: new Date(maxDate),
        format: 'dd mmm, yyyy',
        minDate: new Date(minDate),
        maxDate: new Date(maxDate),
        minYear: new Date(minDate).getFullYear()+1,
        maxYear: new Date(maxDate).getFullYear()
    });

	//asignar caracteres permitidos en cada campo
	$('.FoDocumento input, .FoTelefono input').numeric("positiveInteger");

	//validacion en tiempo real documento
    $('.FoDocumento input').on('change', function() {
        let Documento = this.value;
        let DocumentoExpReg = new RegExp(/^[0-9]{8,10}$/g);
        if (!(DocumentoExpReg.test(Documento))) {
            $(this).removeClass("valid").addClass("invalid");
            let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastDocumento, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validación tiempo real fecha nacimiento
    $('.FoNacimiento').on('change', function() {
        let Nacimiento = this.value;
        let array_fecha = Nacimiento.split(' ');
        let año = parseInt(array_fecha[2]);
        if (Nacimiento.length < 1 || Nacimiento == '' || Nacimiento == undefined) {
            $(this).removeClass("valid").addClass("invalid");
            let toastFecha = '<span>Por favor indica tu <strong>fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastFecha, displayLength: 5000});
        } else if (año > ((new Date).getFullYear() - 15)) {
            $(this).removeClass("valid").addClass("invalid");
            let toastFecha = '<span>Debes tener mínimo <strong>16 años de edad</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastFecha, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validacion en tiempo real RH
    $('.FoRH select').on('change', function() {
        let RH = this.value;
        if (RH === 0 || RH === "" || RH == null) {
            $(this).removeClass("valid").addClass("invalid");
            let toastRH = '<span>Por favor selecciona tú <strong>grupo sanguíneo y RH.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastRH, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validación tiempo real telefono
    $('.FoTelefono input').on('change', function() {
        let Telefono = this.value;
        let TelefonoExpReg = new RegExp(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/g);
        if (!(TelefonoExpReg.test(Telefono))) {
            $(this).removeClass("valid").addClass("invalid");
            let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastTelefono, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

});

function Validarforgot(Regis) {
	let Documento = $('.FoDocumento input').val();
    let Nacimiento = $('.FoNacimiento').val();
    let RH = $('.FoRH select').val();
    let DocumentoExpReg = new RegExp(/^[0-9]{8,10}$/g);
    let Nacimiento_fecha = Nacimiento.split(' ');
    let año = parseInt(Nacimiento_fecha[2]);
    let Telefono = $('.FoTelefono input').val();
    let TelefonoExpReg = new RegExp(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/g);
    
    if (Documento == '' || Documento == undefined) {
        $('.FoDocumento input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSuccess').addClass("hide");
		return false;
    } else if (!(DocumentoExpReg.test(Documento))) {
        $('.FoDocumento input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSuccess').addClass("hide");
		return false;
    } else if (Nacimiento == '' || Nacimiento == undefined) {
        $('.FoNacimiento').removeClass("valid").addClass("invalid");
        let toastApellidos = '<span>Por favor indica tu <strong>fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastApellidos, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSucces').addClass("hide");
        return false;
    } else if (año > ((new Date).getFullYear() - 15)) {
        $('.FoNacimiento').removeClass("valid").addClass("invalid");
        let toastFecha = '<span>Debes tener mínimo <strong>16 años de edad</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastFecha, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSucces').addClass("hide");
        return false;
    } else if (RH == 0 || RH == "" || RH == null) {
        let toastRH = '<span>Por favor selecciona tú <strong>grupo sanguíneo y RH.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastRH, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSucces').addClass("hide");
        return false;
    } else if (Telefono == "" || Telefono == undefined) {
        $('.FoTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSucces').addClass("hide");
        return false;
    } else if (!(TelefonoExpReg.test(Telefono))) {
        $('.FoTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.forgotError').removeClass("hide");
        $('.forgotSucces').addClass("hide");
        return false;
    } else {
        $('.forgotError').addClass("hide");
        $('.forgotSuccess').removeClass("hide");
        $('.btn-forgot').addClass("hide");
        console.info('Forgot validado correctamente');
        setTimeout(function() {
            return true;
        }, 6000);
    }
}
