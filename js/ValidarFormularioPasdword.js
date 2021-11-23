// modificar inputs por defecto
$(document).ready(function() {
    localStorage.setItem("CancelarNewPassword", 1);
    //asignacion de caracteres
    $('.ValCaContraseña input, .CaContraseña input').alphanum({
        allowSpace: false
    });
    $(".ValCaContraseña input, .CaContraseña input").on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

	// validación tiempo real contraseña
    $('.CaContraseña input').on('change', function() {
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
    $('.ValCaContraseña input, .CaContraseña input').on('change', function() {
        var Contraseña = $('.CaContraseña input');
        var ValCaContraseña = $('.ValCaContraseña input').val();
        if (ValCaContraseña.length < 1) {
            $('.ValCaContraseña input').removeClass("valid").removeClass("invalid");
        } else if (Contraseña.val() == "" || Contraseña.val() == undefined) {
        	$('.ValCaContraseña input').removeClass("valid").addClass("invalid");
        	let toastValCotraseña = '<span>primero indique la <strong>contraseña principal.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastValCotraseña, displayLength: 5000});
        }else if (Contraseña.hasClass("invalid")) {
        	$('.ValCaContraseña input').removeClass("valid").addClass("invalid");
        	let toastValCotraseña = '<span>La contraseña principal aún <strong>presenta error.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  			M.toast({html: toastValCotraseña, displayLength: 5000});
        }else if (Contraseña.val() != ValCaContraseña) {
            $('.ValCaContraseña input').removeClass("valid").addClass("invalid");
            let toastValCotraseña = '<span><strong>Las contraseñas no coinciden.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastValCotraseña, displayLength: 5000});  
        }else {
            $('.ValCaContraseña input').removeClass("invalid").addClass("valid");
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
});
function ValidarPassword(Regis) {
	let Contraseña = $('.CaContraseña input').val();
    let ValCaContraseña = $('.ValCaContraseña input').val();
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
    if (Contraseña == "" || Contraseña == undefined) {
        $('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>la nueva Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (Contraseña.length < 8) {
        $('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (!bien) {
        $('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (espacio.test(Contraseña)) {
        $('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (/^([0-9])*$/.test(Contraseña)) {
        $('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
       	$('.CaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (ValCaContraseña == "" || ValCaContraseña == undefined) {
        $('.ValCaContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>Validar la contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false;
    } else if (Contraseña != ValCaContraseña) {
        $('.ValCaContraseña input').removeClass("valid").addClass("invalid");
        let toastValCotraseña = '<span><strong>Las contraseñas no coinciden.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastValCotraseña, displayLength: 5000}); 
        $('.cambioPassError').removeClass("hide");
        $('.cambioPassSuccess').addClass("hide");
		return false; 
    } else {
        $('.btn-password').addClass("hide");
        $('.cambioPassError').addClass("hide");
        $('.cambioPassSuccess').removeClass("hide");
        console.info('Cambio de contraseña validado correctamente');
        localStorage.setItem("CancelarNewPassword", 0);
        setTimeout(function() {
            return true;
        }, 6000);
    }
}