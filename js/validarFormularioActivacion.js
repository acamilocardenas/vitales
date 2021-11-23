$(document).ready(function() {
    //asignacion de caracteres
	$('.AcTelefono input').numeric("positiveInteger");
    $('.ValContraseña input, .AcContraseña input').alphanum({
        allowSpace: false
    });
    $(".ValContraseña input, .AcContraseña input").on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });


	//validación tiempo real telefono
    $('.AcTelefono input').on('change', function() {
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
    $('.AcContraseña input').on('change', function() {
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
    $('.ValContraseña input, .AcContraseña input').on('change', function() {
        var Contraseña = $('.AcContraseña input');
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
    $(".AcMostrar-pass").on( 'change', function() {
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


function ValidarActivacion(Regis) {
	//valores de panel contraseña
    let Telefono = $('.AcTelefono input').val();
    let TelefonoExpReg = new RegExp(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/g);
    let Contraseña = $('.AcContraseña input').val();
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
    if (Telefono == "" || Telefono == undefined) {
        $('.AcTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (!(TelefonoExpReg.test(Telefono))) {
        $('.AcTelefono input').removeClass("valid").addClass("invalid");
        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
        M.toast({html: toastTelefono, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
        return false;
    } else if (Contraseña == "" || Contraseña == undefined) {
        $('.AcContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (Contraseña.length < 8) {
        $('.AcContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (!bien) {
        $('.AcContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (espacio.test(Contraseña)) {
        $('.AcContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (/^([0-9])*$/.test(Contraseña)) {
        $('.AcContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.registroError').removeClass("hide");
        $('.registroSucces').addClass("hide");
		return false;
    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
       	$('.AcContraseña input').removeClass("valid").addClass("invalid");
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
        console.info('Activacion validada correctamente');
        setTimeout(function() {
            return true;
        }, 6000);
    }
};