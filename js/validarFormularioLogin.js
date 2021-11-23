// modificar inputs por defecto
$(document).ready(function() {
	//asignar caracteres permitidos en cada campo
	$('.InUsuario input').numeric("positiveInteger");
    $('.InContraseña input').alphanum({
        allowSpace: false
    });
    $(".InContraseña input").on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

	//validacion en tiempo real documento
    $('.InUsuario input').on('change', function() {
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

    // validación tiempo real contraseña
    $('.InContraseña input').on('change', function() {
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
    //mostrar contraseña
    $(".mostrar-pass").on( 'change', function() {
        if( $(this).is(':checked') ) {
            $('#InContraseña').get(0).type = 'text';
        }
        else {
            $('#InContraseña').get(0).type = 'password';
        }
    });
});

function ValidarLogin(Regis) {
	let Documento = $('.InUsuario input').val();
	let Contraseña = $('.InContraseña input').val();
    let DocumentoExpReg = new RegExp(/^[0-9]{7,10}$/g);
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
    if (Documento == '' || Documento == undefined) {
        $('.InUsuario input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (!(DocumentoExpReg.test(Documento))) {
        $('.InUsuario input').removeClass("valid").addClass("invalid");
        let toastDocumento = '<span>Por favor revisa tú <strong>Número de identificación.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastDocumento, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (Contraseña == "" || Contraseña == undefined) {
        $('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (Contraseña.length < 8) {
        $('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (!bien) {
        $('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (espacio.test(Contraseña)) {
        $('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (/^([0-9])*$/.test(Contraseña)) {
        $('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
       	$('.InContraseña input').removeClass("valid").addClass("invalid");
        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
		M.toast({html: toastCotraseña, displayLength: 5000});
        $('.loginError').removeClass("hide");
        $('.loginSuccess').addClass("hide");
		return false;
    } else {
        $('.loginError').addClass("hide");
        $('.loginSuccess').removeClass("hide");
        $('.btn-login').addClass("hide");
        setTimeout(function() {
            return true;
        }, 6000);
    }
}
