// modificar inputs por defecto
$(document).ready(function() {
    //asignar caracteres permitidos en cada campo
	$('.ReNombres input, .ReApellidos input').alpha();
	$('.ReDocumento input, .ReTelefono input').numeric("positiveInteger");
    $('.ReContraseña input, .ValContraseña input').alphanum({
        allowSpace: false
    });
    $('.ReNombres input, .ReApellidos input').on('keyup', function () {
        $(this).capitalize();
    }).capitalize();
    $('.ReContraseña input, .ValContraseña input').on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });
    //desabilitar campos licencencia
	$('.ReExpedicion, .ReExpedicion2, .ReExpedicion3').prop( "disabled", true );

	//validación tiempo real nombre
	$('.ReNombres input').on('change', function() {
        let Nombres = this.value;
        if (Nombres.length < 3 || Nombres === '' ) {
            $(this).removeClass("valid").addClass("invalid");
        	let toastNombre = '<span>Por favor verifica tu <strong>Nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastNombre, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid")
        }
    });

    //validación tiempo real apellido
	$('.ReApellidos input').on('change', function() {
        let Apellidos = this.value;
        if (Apellidos.length < 3 || Apellidos === '')  {
            $(this).removeClass("valid").addClass("invalid");
            let toastApellidos = '<span>Por favor indica tus dos <strong>Apellidos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastApellidos, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validación tiempo real fecha nacimiento
    $('.ReNacimiento').on('change', function() {
        let Nacimiento = this.value;
        let array_fecha = Nacimiento.split(' ');
        let año = parseInt(array_fecha[2]);
        if (Nacimiento.length < 1 || Nacimiento == '' || Nacimiento == undefined) {
            $(this).removeClass("valid").addClass("invalid");
            $('.ReExpedicion, .ReExpedicion2, .ReExpedicion3').val('').prop( "disabled", true ).removeClass("valid invalid");;
            let toastFecha = '<span>Por favor indica tu <strong>fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastFecha, displayLength: 5000});
        } else if (año > ((new Date).getFullYear() - 15)) {
            $(this).removeClass("valid").addClass("invalid");
            $('.ReExpedicion, .ReExpedicion2, .ReExpedicion3').val('').prop( "disabled", true ).removeClass("valid invalid");;
            let toastFecha = '<span>Debes tener mínimo <strong>16 años de edad</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastFecha, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
            $('.ReExpedicion, .ReExpedicion2, .ReExpedicion3').prop( "disabled", false );
            let dia = array_fecha[0];
            let mes = ConvertMes(array_fecha[1]);
            let formatoDate = (año+'-'+mes+'-'+dia+'T00:00:00');
            let fechaActual = new Date(formatoDate);

            let minDate = new Date(fechaActual);
                minDate.setFullYear(minDate.getFullYear() + 16);
            $('.ReExpedicion, .ReExpedicion2, .ReExpedicion3').datepicker({
                format: 'dd mmm, yyyy',
                minDate: new Date(minDate),
                maxDate: new Date(),
                minYear: new Date(minDate).getFullYear(),
                maxYear: new Date().getFullYear()
            });
        }
        M.updateTextFields();

    });

    //validacion en tiempo real documento
    $('.ReDocumento input').on('change', function() {
        let Documento = this.value;
        let DocumentoExpReg = new RegExp(/^[0-9]{7,10}$/g);
        if (!(DocumentoExpReg.test(Documento))) {
            $(this).removeClass("valid").addClass("invalid");
            let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastDocumento, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validacion en tiempo real RH
    $('.ReRH select').on('change', function() {
    	let RH = this.value;
    	if (RH === 0 || RH === "" || RH == null) {
    		$(this).removeClass("valid").addClass("invalid");
            let toastRH = '<span>Por favor selecciona tú <strong>grupo sanguíneo y RH.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastRH, displayLength: 5000});
    	} else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validacion en tiempo real foto
    $('.ReFoto input').on('change', function() {
    	let foto = this.value;
    	const editorPrew = $('.editorPrew');
    	if(foto === '') {
    		editor.innerHTML = '';
    		fotoBase64.value = '';
            M.textareaAutoResize(fotoBase64);
    		editorPrew.addClass("hide");
    		$(this).removeClass("valid").addClass("invalid");
    	} else {
    		editorPrew.removeClass("hide");
    		$(this).removeClass("invalid").addClass("valid");
    	}
    });
    $('.expedicion').on('click', function() {
        let input = $(this).children();
        if ($(input).prop("disabled") == true)
        {
            let toastLicencia = '<span>Por favor indica tú <strong>fecha de nacimiento</strong> primero</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia, displayLength: 5000});
        }
    });

    //validacion en tiempo real licencia de conduccion
    $('.ReLicencia select').on('change', function() {
    	let Licencia = this.value;
    	if (Licencia  == '0' ) {
            $('.ReLicencia2 select').prop('disabled', true);
    		$(this).removeClass("valid").addClass("invalid");
            let toastLicencia = '<span>Por favor selecciona tú <strong>categoria de licencia de conducción</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastLicencia, displayLength: 5000});
    	} else {
            $(this).removeClass("invalid").addClass("valid");
        }
        //desabilitar elementos de la licencia 2
        if($('.nueva-licencia.dos').hasClass("hide")){
            desableOpcionLicencias(Licencia + 0);
        }
        else
        {
            desableOpcionLicencias(Licencia);  
        }
    });

    //validación tiempo real fecha expedicion licencia
    $('.ReExpedicion').on('change', function() {
        let Expedicion = this.value;
        if (Expedicion.length < 1 || Expedicion == '' || Expedicion == undefined) {
            $(this).removeClass("valid").addClass("invalid");
            let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong><br>de tú licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastFecha, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

     $('.ReLicencia2').on('click', function(){
        if ($('.ReLicencia2 select').prop("disabled") == true) {
            let toastLicencia2 = '<span>Seleccione una <strong>categoría arriba </strong>primero.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia2, displayLength: 5000});
        }
    });   

    $('.ReLicencia2 select').on('change', function(){
        let Licencia = $('.ReLicencia select').val();
        let Licencia2 = this.value;
        let Licencia3 = Licencia + Licencia2;
        if (Licencia2  == '0' ) {
            $('.ReLicencia3 select').prop('disabled', true);
            $(this).removeClass("valid").addClass("invalid");
            let toastLicencia = '<span>Por favor selecciona la <strong>categoria</strong> de tú segunda licencia de conducción</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
        //desabilitar elementos de la licencia 3
        desableOpcionLicencias(Licencia3);
    });

    //validación tiempo real fecha expedicion segunda licencia
    $('.ReExpedicion2').on('change', function() {
        let Expedicion = this.value;
        if (Expedicion.length < 1 || Expedicion == '' || Expedicion == undefined) {
            $(this).removeClass("valid").addClass("invalid");
            let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong><br>de tú segunda licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastFecha, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    $('.ReLicencia3').on('click', function(){
        if ($('.ReLicencia3 select').prop("disabled") == true) {
            let toastLicencia3 = '<span>Seleccione una <strong>categoría arriba </strong>primero.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia3, displayLength: 5000});
        }    
    });

    $('.ReLicencia3 select').on('change', function(){
        if ($(this).prop("disabled") == true) {
            let toastLicencia2 = '<span>Seleccione una <strong>categoría arriba </strong>primero.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia2, displayLength: 5000});
        }
        let Licencia3 = this.value;
        if (Licencia3  == '0' ) {
            $(this).removeClass("valid").addClass("invalid");
            let toastLicencia= '<span>Por favor selecciona la <strong>categoria</strong><br>de tú tercera licencia de conducción</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastLicencia, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
        
    });

     //validación tiempo real fecha expedicion tercera licencia
    $('.ReExpedicion3').on('change', function() {
        let Expedicion = this.value;
        if (Expedicion.length < 1 || Expedicion == '' || Expedicion == undefined) {
            $(this).removeClass("valid").addClass("invalid");
            let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong><br>de tú tercera licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
            M.toast({html: toastFecha, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    //validación tiempo real telefono
    $('.ReTelefono input').on('change', function() {
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

    // validación tiempo real contraseña
    $('.ReContraseña input').on('change', function() {
        let Contraseña = this.value;
        let validos = " abcdefghijklmnñopqrstuvwxyz0123456789";
        let letra;
        let bien = true;
        let espacio = new RegExp(/\s/);
        for(let i = 0; i < Contraseña.length; i++) {
            letra = Contraseña.charAt(i).toLowerCase()
            if (validos.indexOf(letra) == -1) {
                bien = false;
            };
        }
        if (Contraseña.length < 8) {
            $(this).removeClass("valid").addClass("invalid");
            let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastCotraseña, displayLength: 5000});
        } else if (!bien) {
            $(this).removeClass("valid").addClass("invalid");
            let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastCotraseña, displayLength: 5000});
        } else if (espacio.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
            let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastCotraseña, displayLength: 5000});
        } else if (/^([0-9])*$/.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
            let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastCotraseña, displayLength: 5000});
        } else if (/^([A-Za-z])*$/.test(Contraseña)) {
           	$(this).removeClass("valid").addClass("invalid");
            let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastCotraseña, displayLength: 5000});
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    // validación tiempo real repetir contraseña
    $('.ValContraseña input, .ReContraseña input').on('change', function() {
        var Contraseña = $('.ReContraseña input');
        var ValContraseña = $('.ValContraseña input').val();
        if (ValContraseña.length < 1) {
            $('.ValContraseña input').removeClass("valid").removeClass("invalid");
        } else if (Contraseña.val() == "" || Contraseña.val() == undefined) {
        	$('.ValContraseña input').removeClass("valid").addClass("invalid");
        	let toastValCotraseña = '<span>primero indique la <strong>contraseña principal.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastValCotraseña, displayLength: 5000});
        }else if (Contraseña.hasClass("invalid")) {
        	$('.ValContraseña input').removeClass("valid").addClass("invalid");
        	let toastValCotraseña = '<span>La contraseña principal aún <strong>presenta error.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastValCotraseña, displayLength: 5000});
        }else if (Contraseña.val() != ValContraseña) {
            $('.ValContraseña input').removeClass("valid").addClass("invalid");
            let toastValCotraseña = '<span><strong>Las contraseñas no coinciden.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastValCotraseña, displayLength: 5000});  
        }else {
            $('.ValContraseña input').removeClass("invalid").addClass("valid");
        }
    });

    //MOSTRAR CONTRASEÑA
    $(".mostrar-pass").on( 'change', function() {
        if( $(this).is(':checked') ) {
            $('#contraseña').get(0).type = 'text';
            $('#valcontraseña').get(0).type = 'text';
        }
        else {
            $('#contraseña').get(0).type = 'password';
            $('#valcontraseña').get(0).type = 'password';
        }
    });

    // validación tiempo real terminos
    $('input:checkbox[name=terminos]').on('change', function() {
    	let Terminos = $('input:checkbox[name=terminos]:checked').val();
    	if (Terminos != 'on') {
        	let toastTerminos = '<span>Porfavor <strong>Acepte los terminos y condiciones.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastTerminos, displayLength: 5000});
            return false;
        }
    });
});

function ValidarRegistro(Regis) {
	//valores de panel datos usuario
	let Nombres = $('.ReNombres input').val();
    let Apellidos = $('.ReApellidos input').val();
    let Nacimiento = $('.ReNacimiento').val();
    let Documento = $('.ReDocumento input').val();
    let RH = $('.ReRH select').val();
    let DocumentoExpReg = new RegExp(/^[0-9]{7,10}$/g);
    let Nacimiento_fecha = Nacimiento.split(' ');
    let año = parseInt(Nacimiento_fecha[2]);

    //valores de panel datos foto
    let foto = $('.fotoBase64 textarea').val();

    //valores de panel licencia1
    let Licencia = $('.ReLicencia select').val();
    let Expedicion = $('.ReExpedicion').val();

    //valores de panel licencia2
    let Licencia2 = $('.ReLicencia2 select').val();
    let Expedicion2 = $('.ReExpedicion2').val();

    //valores de panel licencia3
    let Licencia3 = $('.ReLicencia3 select').val();
    let Expedicion3 = $('.ReExpedicion3').val();
    

    //valores de panel contraseña
    let Telefono = $('.ReTelefono input').val();
    let TelefonoExpReg = new RegExp(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/g);
    let Contraseña = $('.ReContraseña input').val();
    let ValContraseña = $('.ValContraseña input').val();
    let validos = " abcdefghijklmnñopqrstuvwxyz0123456789";
    let letra;
    let bien = true;
    let espacio = new RegExp(/\s/);
    for (let i = 0; i < Contraseña.length; i++) {
        letra = Contraseña.charAt(i).toLowerCase()
        if (validos.indexOf(letra) == -1) {
            bien = false;
        };
    }

    //valores de panel terminos
    let Terminos = $('input:checkbox[name=terminos]:checked').val();


    // validación formulario completo antes de enviar al servidor
    if (Nombres == "" || Nombres == undefined) {
        $('.ReNombres input').removeClass("valid").addClass("invalid");
        let toastNombre = '<span>Falta su <strong>Nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  		M.toast({html: toastNombre, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Nombres.length < 3 || Nombres === '' ) {
        $('.ReNombres input').removeClass("valid").addClass("invalid");
    	let toastNombre = '<span>Por favor verifica tu <strong>Nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastNombre, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Apellidos == "" || Apellidos == undefined) {
        $('.ReApellidos input').removeClass("valid").addClass("invalid")
        let toastNombre = '<span>Faltan sus <strong>dos Apellidos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  		M.toast({html: toastNombre, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Apellidos.length < 3 || Apellidos === '')  {
        $('.ReApellidos input').removeClass("valid").addClass("invalid")
        let toastApellidos = '<span>Por favor indica tus dos <strong>Apellidos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastApellidos, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Nacimiento == '' || Nacimiento == undefined) {
        $('.ReNacimiento').removeClass("valid").addClass("invalid");
        let toastApellidos = '<span>Por favor indica tu <strong>fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastApellidos, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (año > ((new Date).getFullYear() - 15)) {
        $('.ReNacimiento').removeClass("valid").addClass("invalid");
        let toastFecha = '<span>Debes tener mínimo <strong>16 años de edad</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastFecha, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Documento == '' || Documento == undefined) {
        $('.ReDocumento input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (!(DocumentoExpReg.test(Documento))) {
        $('.ReDocumento input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (RH == 0 || RH == "" || RH == null) {
        let toastRH = '<span>Por favor selecciona tú <strong>grupo sanguíneo y RH.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastRH, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
	} else if (foto == "" || foto == undefined) {
		$('.ReFoto input').removeClass("valid").addClass("invalid");
        let toastNombre = '<span>Seleccione una <strong>imagen para su Perfil.</strong><br>Verifique que pueda ver los cambios en la vista previa.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  		M.toast({html: toastNombre, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Licencia == '0' || Licencia == null) {
        let toastLicencia = '<span>Por favor selecciona tú <strong>categoria de licencia de conducción</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  		M.toast({html: toastLicencia, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
	} else if (Expedicion == '' || Expedicion == undefined) {
        $('.ReExpedicion').removeClass("valid").addClass("invalid");
        let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong>de tú licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastFecha, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (licencia2 && (Licencia2 == '0' || Licencia2 == null)) {
        let toastLicencia = '<span>Por favor selecciona la <strong>categoria</strong><br> de tú <b>segunda</b> licencia de conducción.<br>O remueve la licencia</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastLicencia, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (licencia2 && (Expedicion2 == '' || Expedicion2 == undefined)) {
        $('.ReExpedicion2').removeClass("valid").addClass("invalid");
        let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong><br>de tú <b>segunda</b> licencia de conducción.<br>O remueve la licencia</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastFecha, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (licencia3 && (Licencia3 == '0' || Licencia3 == null)) {
        let toastLicencia = '<span>Por favor selecciona la <strong>categoria</strong><br> de tú <b>tercera</b> licencia de conducción.<br>O remueve la licencia</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastLicencia, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (licencia3 && (Expedicion3 == '' || Expedicion3 == undefined)) {
        $('.ReExpedicion3').removeClass("valid").addClass("invalid");
        let toastFecha = '<span>Por favor indica la <strong>fecha de expedición </strong><br>de tú <b>tercera</b> licencia de conducción.<br>O remueve la licencia</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastFecha, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Telefono == "" || Telefono == undefined) {
        $('.ReTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (!(TelefonoExpReg.test(Telefono))) {
        $('.ReTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Contraseña == "" || Contraseña == undefined) {
        $('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Contraseña.length < 8) {
        $('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (!bien) {
        $('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (espacio.test(Contraseña)) {
        $('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (/^([0-9])*$/.test(Contraseña)) {
        $('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
       	$('.ReContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (ValContraseña == "" || ValContraseña == undefined) {
        $('.ValContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>Validar la contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Contraseña != ValContraseña) {
        $('.ValContraseña input').removeClass("valid").addClass("invalid");
        let toastValCotraseña = '<span><strong>Las contraseñas no coinciden.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastValCotraseña, displayLength: 5000}); 
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false; 
    } else if (Terminos != 'on') {
        let toastTerminos = '<span>Porfavor <strong>Acepte los terminos y condiciones.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  		M.toast({html: toastTerminos, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else {
        $('.btn-registrar').addClass("hide");
        $('.registroError').addClass("hide");
        $('.registroSucces').removeClass("hide");
        console.info('Registro validado correctamente');
        setTimeout(function() {
            return true;
        }, 6000);
    }

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