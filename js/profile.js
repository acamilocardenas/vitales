let id;
$(document).ready(function() {

	CambioVentana();  

	$('.sidenav').sidenav();
	$(".dropdown-trigger").dropdown();
	$('.collapsible').collapsible();
	$('.modal').modal();
	$('.tooltipped').tooltip();

	$('.generarReporte a').on('click', function() {
		$('.seccion-pdf').removeClass('hide');
		var element = document.getElementById('element-to-print');
		html2pdf()
            .set({
                margin: 1.27,
                filename: 'ProgramaVitalesReporte.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                enableLinks: false,
                pagebreak: { 
                	before: '.newpage', // saltos de pagina obligatorios
                	after: '', 
                	avoid: '.collection' // saltos de pagina para no cortar elemento
                },
                html2canvas: {
                    scale: 3, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "cm",
                    format: "letter",
                    orientation: 'portrait' // landscape o portrait
                }
            })
            .from(element)
            .save()
            .get(true)
            .then((pdf) => {
  				let toastPdf = '<span>Reporte generado <strong>correctamente</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
  				M.toast({html: toastPdf, displayLength: 5000});
			})
            .catch(err => console.log('error: ' + err));

        $('.seccion-pdf').addClass('hide');
	});

	// validación tiempo real contraseña
	$('.InContraseña input').alphanum({
        allowSpace: false
    });
    
    $('.InContraseña input').on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

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

    $('.btn-login button').on('click', function() {
    	let Contraseña = $('.InContraseña input').val();
    	let Documento = $('.InDocumento input').val();
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
        if (Contraseña == "" || Contraseña == undefined) {
	        $('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else if (Contraseña.length < 8) {
	        $('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else if (!bien) {
	        $('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else if (espacio.test(Contraseña)) {
	        $('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else if (/^([0-9])*$/.test(Contraseña)) {
	        $('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
	       	$('.InContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	        $('.loginError').removeClass("hide");
	        $('.loginSuccess').addClass("hide");
	    } else {

	        var datos =
	        {
	            Documento: Documento,
	            Contrasena: Contraseña
	        };
	        $.ajax ({
	            type: "POST",
	            url: "confirmarLoguin.php",
	            data: datos,
	            beforeSend: function() {
	                $('.loginError').addClass("hide");
	        		$('.loginSuccess').removeClass("hide");
	        		$('.btn-login').addClass("hide");
	            },
	            success: function(obj) {
	            	setTimeout(function() {
		                if (obj == 1) {
		                    let toastCotraseña = '<span><strong>Contraseña verificada.</strong><br>Correctamante gracias.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
							M.toast({html: toastCotraseña, displayLength: 5000});
							let result = window.location;
							let newurl = result + '?admin='+Documento+'&password='+Contraseña;
							window.location = newurl;
		                }
		                else{
		            		$('.loginError').removeClass("hide");
		        			$('.loginSuccess').addClass("hide");
		        			$('.btn-login').removeClass("hide");
		                }
		            }, 1200);
	            },
	            error: function(obj, error, objError) {
	            	$('.loginError').removeClass("hide");
        			$('.loginSuccess').addClass("hide");
        			$('.btn-login').removeClass("hide");

	                if(navigator.onLine == true) {
	                	let toastCotraseña = '<span>Algo salio mal intente de nuevo.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                }
	                else {
	                	let toastCotraseña = '<span>Verifica tu conexion a internet.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                }
	            }
	        }).fail( function( jqXHR, textStatus, errorThrown ) {
	                if (jqXHR.status === 0) {
	                	let toastCotraseña = '<span>Verifica tu conexion a internet.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else if (jqXHR.status == 404) {
	                	let toastCotraseña = '<span>Página solicitada no encontrada [400].</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else if (jqXHR.status == 500) {
	                	let toastCotraseña = '<span>Error interno del servidor [500].</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else if (textStatus === 'parsererror') {
	                	let toastCotraseña = '<span>Error al analizar el archivo solicitado.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else if (textStatus === 'timeout') {
	                	let toastCotraseña = '<span>Tiempo de espera exedido.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else if (textStatus === 'abort') {
	                	let toastCotraseña = '<span>Petición Abortada.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                } 
	                else {
	                	let toastCotraseña = '<span>Error desconocido.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
						M.toast({html: toastCotraseña, displayLength: 5000});
	                }
	            });
	    }
    });
	
	$('.loginAdminOk i').on('click', function(){
		$('.loginAdminOk').fadeOut(1000);
	});

	$(".mostrar-pass").on( 'change', function() {
	    if( $(this).is(':checked') ) {
	        $('#InContraseña').get(0).type = 'text';
	    }
	    else {
	        $('#InContraseña').get(0).type = 'password';
	    }
	});
});

function scrollTopModal() {
	$('.modal-content').scrollTop(0);
}

$(window).resize(function() {
   clearTimeout(id);
   id = setTimeout(CambioVentana(), 1000);
});

function CambioVentana() {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('.admin-mobile').removeClass('hide');
    }
    else {
        $('.admin-mobile').addClass('hide');
    }
}