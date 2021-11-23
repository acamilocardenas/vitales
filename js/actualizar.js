$(document).ready(function() {
	
	let newDateNac  = FechaNacJs.concat('', 'T00:00:00');

	if (LicenciasJS.length == 1) {
		LicenciasJS.push("U", "U");
		FechaLicenciasJS.push("U", "U");
	}
	else if(LicenciasJS.length == 2) {
		LicenciasJS.push("U");
		FechaLicenciasJS.push("U");
	}

	setTimeout(function() {
		$('.before-update').fadeOut('slow', 'swing');
	}, 3500);

	//asignar caracteres permitidos en cada campo
	$('.ReNombres input, .ReApellidos input').alpha();
	$('.ReTelefono input').numeric("positiveInteger");
    $('.AntContraseña input, .ReContraseña input, .ValContraseña input').alphanum({
        allowSpace: false
    });
    $('.ReNombres input, .ReApellidos input').on('keyup', function () {
        $(this).capitalize();
    }).capitalize();

    $('.AntContraseña input, .ReContraseña input, .ValContraseña input').on('input', function(evt) {
        var input = $(this);
        var start = input[0].selectionStart;
        $(this).val(function (_, val) {
            return val.toLowerCase();
        });
        input[0].selectionStart = input[0].selectionEnd = start;
    });

	//validación tiempo real nombre
	$('.ReNombres input').on('change', function() {
        let Nombres = this.value;
        if (Nombres.length < 3 || Nombres === '' ) {
            $(this).removeClass("valid").addClass("invalid");
        } else {
            $(this).removeClass("invalid").addClass("valid")
        }
    });

    //validación tiempo real apellido
	$('.ReApellidos input').on('change', function() {
        let Apellidos = this.value;
        if (Apellidos.length < 3 || Apellidos === '')  {
            $(this).removeClass("valid").addClass("invalid");
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
        } else if (año > ((new Date).getFullYear() - 15)) {
            $(this).removeClass("valid").addClass("invalid");
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
    //validación tiempo real fecha expedicion licencias
    $('.Expedicion-uno, .Expedicion-dos, .Expedicion-tres').on('change', function() {
        let ExpedicionLic = this.value;
        ExpedicionLic = ExpedicionLic.concat('', ' T00:00:00');
        let array_fecha = ExpedicionLic.split(' ');
        let dia = array_fecha[0];
        let mes = ConvertMes(array_fecha[1]);
        let año = array_fecha[2];
        let zonaHora = array_fecha[3];
        let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);

        let fecha = new Date(formatoDate);
        let hoy = new Date();

        if (ExpedicionLic.length < 1 || ExpedicionLic == '' || ExpedicionLic == undefined ) {
            $(this).removeClass("valid").addClass("invalid");
        } else if ( fecha >  hoy ) {
            $(this).removeClass("valid").addClass("invalid");
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });

    // validación tiempo real contraseña anterior
    $('.AntContraseña input').on('change', function() {
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
        } else if (!bien) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (espacio.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (/^([0-9])*$/.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (/^([A-Za-z])*$/.test(Contraseña)) {
           	$(this).removeClass("valid").addClass("invalid");
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
        } else if (!bien) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (espacio.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (/^([0-9])*$/.test(Contraseña)) {
            $(this).removeClass("valid").addClass("invalid");
        } else if (/^([A-Za-z])*$/.test(Contraseña)) {
           	$(this).removeClass("valid").addClass("invalid");
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
        }else if (Contraseña.hasClass("invalid")) {
        	$('.ValContraseña input').removeClass("valid").addClass("invalid");
        }else if (Contraseña.val() != ValContraseña) {
            $('.ValContraseña input').removeClass("valid").addClass("invalid"); 
        }else {
            $('.ValContraseña input').removeClass("invalid").addClass("valid");
        }
    });


	//Edit Nombre y apellido
	$(".edit-nombre").hide();

	$(".edit-nombre-btn").on('click', function() {
		$('.ReNombres input').val(NombreJS).removeClass("valid invalid");
		$('.ReApellidos input').val(ApellidoJS).removeClass("valid invalid");
		M.updateTextFields();
		closetoggle();
		$(".edit-nombre-btn").hide();
		$(".edit-nombre").show();
	});


	$(".close-nombre-btn").on('click', function() {
		$(".edit-nombre").hide();
		$(".edit-nombre-btn").show();
	});

	$(".update-nombre-btn").on('click', function() {
		let Nombres = $('.ReNombres input').val();
    	let Apellidos = $('.ReApellidos input').val();
        if (Nombres == "" || Nombres == undefined) {
	        $('.ReNombres input').removeClass("valid").addClass("invalid");
	        let toastNombre = '<span>Falta su <strong>Nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	  		M.toast({html: toastNombre, displayLength: 5000});
	    } else if (Nombres.length < 3 || Nombres === '' ) {
	        $('.ReNombres input').removeClass("valid").addClass("invalid");
	    	let toastNombre = '<span>Por favor verifica tu <strong>Nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastNombre, displayLength: 5000});
	    } else if (Apellidos == "" || Apellidos == undefined) {
	        $('.ReApellidos input').removeClass("valid").addClass("invalid")
	        let toastNombre = '<span>Faltan sus <strong>dos Apellidos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	  		M.toast({html: toastNombre, displayLength: 5000});
	    } else if (Apellidos.length < 3 || Apellidos === '')  {
	        $('.ReApellidos input').removeClass("valid").addClass("invalid")
	        let toastApellidos = '<span>Por favor indica tus dos <strong>Apellidos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastApellidos, displayLength: 5000});
	    } else if (Nombres == NombreJS && Apellidos == ApellidoJS) {
	    	$(".edit-nombre").hide();
			$(".edit-nombre-btn").show();
	    	let toastApellidos = '<span>No se encontró ningún <strong>cambio en tu nombre.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastApellidos, displayLength: 5000});
	    } else {
	        var datosNombre =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'Nombre',
	            Nombre: Nombres,
	            Apellido: Apellidos
	        };
	        update(datosNombre, 'Nombre');
	    }
	});

	//Edit fecha nacimiento
	$(".edit-brithday").hide();

	$(".edit-brithday-btn").on('click', function() {
		const actualBrithday = FechaNacJs.concat(' ', 'T00:00:00');
		let array_fecha = actualBrithday.split(' ');
        let dia = array_fecha[0];
        let mes = ConvertMes(array_fecha[1]);
        let año = array_fecha[2];
        let zonaHora = array_fecha[3];
        let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);
        let fechaActual = new Date(formatoDate);

		let maxDateForm = new Date('12 31 1991 00:00:00');

		let maxDate = maxDateForm.setFullYear(new Date().getFullYear() - 16 );
		let minDate = maxDateForm.setFullYear(new Date().getFullYear() - 80 );


		$('.ReNacimiento').datepicker({
			defaultDate: new Date(fechaActual),
        	setDefaultDate: true,
			format: 'dd mmm, yyyy',
			minDate: new Date(minDate),
			maxDate: new Date(maxDate),
			minYear: new Date(minDate).getFullYear()+1,
			maxYear: new Date(maxDate).getFullYear()
		});
		closetoggle();
		$('.ReNacimiento').removeClass("valid invalid");
		$(".edit-brithday-btn").hide();
		$(".edit-brithday").show();
	});


	$(".close-brithday-btn").on('click', function() {
		$(".edit-brithday").hide();
		$(".edit-brithday-btn").show();
	});

	$(".update-brithday-btn").on('click', function() {
		let Nacimiento = $('.ReNacimiento').val();
		let Nacimiento_fecha = Nacimiento.split(' ');
    	let año = parseInt(Nacimiento_fecha[2]);
		if (Nacimiento == '' || Nacimiento == undefined) {
	        $('.ReNacimiento').removeClass("valid").addClass("invalid");
	        let toastApellidos = '<span>Por favor indica tu <strong>fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastApellidos, displayLength: 5000});
	    } else if (año > ((new Date).getFullYear() - 15)) {
	        $('.ReNacimiento').removeClass("valid").addClass("invalid");
	        let toastFecha = '<span>Debes tener mínimo <strong>16 años de edad</strong>.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastFecha, displayLength: 5000});
	    } else if (Nacimiento == FechaNacJs) {
	    	$(".edit-brithday").hide();
			$(".edit-brithday-btn").show();
	    	let toastApellidos = '<span>No se encontró ningún <strong>cambio en tu fecha de nacimiento.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastApellidos, displayLength: 5000});
	    } else {
	        var datosBrithday =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'FechaNacimiento',
	            Nacimiento: Nacimiento
	        };
	        update(datosBrithday, 'FechaNacimiento');
	    }
	});

	//Edit RH
	$(".edit-rh").hide();

	$(".edit-rh-btn").on('click', function() {
		resetRH(RHJS);
		closetoggle();
		$(".edit-rh-btn").hide();
		$(".edit-rh").show();
	});


	$(".close-rh-btn").on('click', function() {
		$(".edit-rh").hide();
		$(".edit-rh-btn").show();
	});

	$(".update-rh-btn").on('click', function() {
		let rh = document.getElementsByName('rh');
		let rhValue;
		let rhCompare;
		for (let i = rh.length - 1; i >= 0; i--) {
			if (rh[i].checked) {
				rhValue = parseInt(rh[i].value);
				rhCompare = resetRH(rhValue);
				break;
			}
		}
		if (rhCompare == RHJS) {
	    	$(".edit-rh").hide();
			$(".edit-rh-btn").show();
	    	let toastApellidos = '<span>No se encontró ningún <strong>cambio en tu grupo sanguíneo y RH.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastApellidos, displayLength: 5000});
	    } else {
	        var datosRH =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'RH',
	            RH: rhValue
	        };
	        update(datosRH, 'RH');
	    }

	});

	//Edit foto
	$(".edit-foto").hide();

	$(".edit-foto-btn").on('click', function() {
		let foto = $('.ReFoto input');
    	$('.editorPrew').addClass("hide");
		editor.innerHTML = '';
		fotoBase64.value = '';
		$('#foto, .file-path').val('');
		$('.ReFoto input').removeClass("valid invalid");
		closetoggle();
		$(".edit-foto-btn").hide();
		$(".edit-foto").show();
	});


	$(".close-foto-btn").on('click', function() {
		$(".edit-foto").hide();
		$(".edit-foto-btn").show();
	});
	$(".update-foto-btn").on('click', function() {
		let foto = $('.fotoBase64 textarea').val();
		if (foto == "" || foto == undefined) {
			$('.ReFoto input').removeClass("valid").addClass("invalid");
	        let toastNombre = '<span>Seleccione una <strong>imagen para su Perfil.</strong><br>Verifique que pueda ver los cambios en la vista previa.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	  		M.toast({html: toastNombre, displayLength: 5000});
	    } else {
	        var datosFoto =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'Foto',
	            Foto: foto
	        };
	        update(datosFoto, 'Foto');
	    }
	});

	//Edit Licencia
	$(".edit-lic-uno, .edit-lic-dos, .edit-lic-tres").hide();

	$(".edit-lic-uno-btn, .edit-lic-dos-btn, .edit-lic-tres-btn").on('click', function() {
		$('.Expedicion-uno, .Expedicion-dos, .Expedicion-tres').val('');
		M.updateTextFields();
		closetoggle();
		$(this).hide();
		resetLic();
		$('.Licencia-uno, .Licencia-dos, .Licencia-tres').removeClass("valid invalid");
		$('.Expedicion-uno, .Expedicion-dos, .Expedicion-tres').removeClass("valid invalid");
		if ($(this).hasClass("edit-lic-uno-btn")) {
			$('.delete-lic-uno').addClass('hide');
			$('.form-lic-uno').removeClass('hide');
			$(".edit-lic-uno").show();
		}else if ($(this).hasClass("edit-lic-dos-btn")){
			$('.delete-lic-dos').addClass('hide');
			$('.form-lic-dos').removeClass('hide');
			$(".edit-lic-dos").show();
		}else if ($(this).hasClass("edit-lic-tres-btn")){
			$('.delete-lic-tres').addClass('hide');
			$('.form-lic-tres').removeClass('hide');
			$(".edit-lic-tres").show();
		}

	});


	$(".close-lic-uno-btn, .close-lic-dos-btn, .close-lic-tres-btn").on('click', function() {
		$(".edit-lic-uno, .edit-lic-dos, .edit-lic-tres").hide();
		$(".edit-lic-uno-btn, .edit-lic-dos-btn, .edit-lic-tres-btn").show();
	});

	$(".update-lic-uno-btn, .update-lic-dos-btn, .update-lic-tres-btn, .add-lic-dos-btn, .add-lic-tres-btn").on('click', function() {
		let btn = $(this);
		let Licencias = ['U', 'A1', 'A2', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3'];
		let licenciaOld;
		let expedicionOld;
		let licenciaNew;
		let expedicionNew;
		let Form;
		if(btn.hasClass("update-lic-uno-btn"))
		{
			licenciaOld = Licencias.indexOf(LicenciasJS[0]);
			licenciaNew = $(".Licencia-uno").val();

			expedicionOld = new Date(FechaLicenciasJS[0].concat('', 'T00:00:00'));
			expedicionNew = $(".Expedicion-uno").val();
			inputPiker = $(".Expedicion-uno");
			Form = 'LicenciaUpdate';
		}
		else if(btn.hasClass("update-lic-dos-btn"))
		{
			licenciaOld = Licencias.indexOf(LicenciasJS[1]);
			licenciaNew = $(".Licencia-dos").val();

			expedicionOld = new Date(FechaLicenciasJS[1].concat('', 'T00:00:00'));
			expedicionNew = $(".Expedicion-dos").val();
			inputPiker = $(".Expedicion-dos");
			Form = 'LicenciaUpdate';
		}
		else if(btn.hasClass("update-lic-tres-btn"))
		{
			licenciaOld = Licencias.indexOf(LicenciasJS[2]);
			licenciaNew = $(".Licencia-tres").val();

			expedicionOld = new Date(FechaLicenciasJS[2].concat('', 'T00:00:00'));
			expedicionNew = $(".Expedicion-tres").val();
			inputPiker = $(".Expedicion-tres");
			Form = 'LicenciaUpdate';
		}
		else if(btn.hasClass("add-lic-dos-btn"))
		{
			licenciaNew = $(".Licencia-dos").val();
			expedicionNew = $(".Expedicion-dos").val();
			inputPiker = $(".Expedicion-dos");
			Form = 'LicenciaAdd';
		}
		else if(btn.hasClass("add-lic-tres-btn"))
		{
			licenciaNew = $(".Licencia-tres").val();
			expedicionNew = $(".Expedicion-tres").val();
			inputPiker = $(".Expedicion-tres");
			Form = 'LicenciaAdd';
		}


		if (licenciaNew == '0' || licenciaNew == null) {
	        let toastLicencia = '<span>Por favor selecciona la <strong>categoria</strong><br> de tú licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	        M.toast({html: toastLicencia, displayLength: 5000});
    	}
        else if (expedicionNew.length < 1 || expedicionNew == '' || licenciaNew == undefined ) {
            $(inputPiker).removeClass("valid").addClass("invalid");
	        let toastExpedicion = '<span>Por favor indica la <strong>fecha de expedición </strong>de tú licencia de conducción.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastExpedicion, displayLength: 5000});
        }else {
			expedicionNew = expedicionNew.concat('', ' T00:00:00');
	        let array_fecha = expedicionNew.split(' ');
	        let dia = array_fecha[0];
	        let mes = ConvertMes(array_fecha[1]);
	        let año = array_fecha[2];
	        let zonaHora = array_fecha[3];
	        let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);
	        expedicionNew = new Date(formatoDate);
	        let hoy = new Date();
	        
	        if(expedicionNew >  hoy) {
	        	let toastExpedicion = '<span>La <strong>fecha de expedición </strong>de tú licencia,<br>No puede ser mayor a la fecha de hoy.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
				M.toast({html: toastExpedicion, displayLength: 5000});
	        }else if( licenciaOld == licenciaNew && expedicionOld.getTime() == expedicionNew.getTime()) {
				let toastLicencia = '<span>No se encontró ningún <strong>cambio en tu Licencia.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
				M.toast({html: toastLicencia, displayLength: 5000});
				$(".edit-lic-uno, .edit-lic-dos, .edit-lic-tres").hide();
				$(".edit-lic-uno-btn, .edit-lic-dos-btn, .edit-lic-tres-btn").show();
			}else {
				if (Form == 'LicenciaUpdate') {
					var datosLic =
			        {
			        	Documento: DocumentoJS,
			        	Form: Form,
			        	LicenciaOld: licenciaOld,
			            ExpedicionOld: expedicionOld.format("yyyy-mm-dd"),
			            LicenciaNew: parseInt(licenciaNew),
			            ExpedicionNew: expedicionNew.format("yyyy-mm-dd")
			        };
				} else if(Form == 'LicenciaAdd') {
					var datosLic =
			        {
			        	Documento: DocumentoJS,
			        	Form: Form,
			            Licencia: parseInt(licenciaNew),
			            Expedicion: expedicionNew.format("yyyy-mm-dd")
			        };
				}
				
	        	update(datosLic, Form);
			}

        }
	});

	$(".delete-lic-uno-btn, .delete-lic-dos-btn, .delete-lic-tres-btn").on('click', function() {
		let btn = $(this);
		if(btn.hasClass("delete-lic-uno-btn")) {
			$('.form-lic-uno').addClass('hide');
			$('.delete-lic-uno').removeClass('hide');
		} else if(btn.hasClass("delete-lic-dos-btn")) {
			$('.form-lic-dos').addClass('hide');
			$('.delete-lic-dos').removeClass('hide');
		} else if(btn.hasClass("delete-lic-tres-btn")) {
			$('.form-lic-tres').addClass('hide');
			$('.delete-lic-tres').removeClass('hide');
		}
	});

	$(".cancel-delete-lic-uno-btn, .cancel-delete-lic-dos-btn, .cancel-delete-lic-tres-btn").on('click', function() {
		let btn = $(this);
		if(btn.hasClass("cancel-delete-lic-uno-btn")) {
			$('.delete-lic-uno').addClass('hide');
			$('.form-lic-uno').removeClass('hide');
		} else if(btn.hasClass("cancel-delete-lic-dos-btn")) {
			$('.delete-lic-dos').addClass('hide');
			$('.form-lic-dos').removeClass('hide');
		} else if(btn.hasClass("cancel-delete-lic-tres-btn")) {
			$('.delete-lic-tres').addClass('hide');
			$('.form-lic-tres').removeClass('hide');
		}
	});

	$(".confirm-delete-lic-uno-btn, .confirm-delete-lic-dos-btn, .confirm-delete-lic-tres-btn").on('click', function() {
		let btn = $(this);
		let Licencias = ['U', 'A1', 'A2', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3'];
		let licenciaOld;
		let expedicionOld;
		if(btn.hasClass("confirm-delete-lic-uno-btn")) {
			licenciaOld = Licencias.indexOf(LicenciasJS[0]);
			expedicionOld = new Date(FechaLicenciasJS[0].concat('', 'T00:00:00'));
			$('.delete-lic-uno').addClass('hide');
			$('.while-delete-lic-uno').removeClass('hide');
		} else if(btn.hasClass("confirm-delete-lic-dos-btn")) {
			licenciaOld = Licencias.indexOf(LicenciasJS[1]);
			expedicionOld = new Date(FechaLicenciasJS[1].concat('', 'T00:00:00'));
			$('.delete-lic-dos').addClass('hide');
			$('.while-delete-lic-dos').removeClass('hide');
		} else if(btn.hasClass("confirm-delete-lic-tres-btn")) {
			licenciaOld = Licencias.indexOf(LicenciasJS[2]);
			expedicionOld = new Date(FechaLicenciasJS[2].concat('', 'T00:00:00'));
			$('.delete-lic-tres').addClass('hide');
			$('.while-delete-lic-tres').removeClass('hide');
		}
		var datosLicDelete =
        {
        	Documento: DocumentoJS,
        	Form: 'LicenciaDelete',
            Licencia: parseInt(licenciaOld),
            Expedicion: expedicionOld.format("yyyy-mm-dd")
        };
    	update(datosLicDelete, 'LicenciaDelete');
	});

	//Edit Telefono
	$(".edit-tel").hide();

	$(".edit-tel-btn").on('click', function() {
		$('.ReTelefono input').val(TelefonoJS).removeClass("valid invalid");
		M.updateTextFields();
		closetoggle();
		$(".edit-tel-btn").hide();
		$(".edit-tel").show();
	});


	$(".close-tel-btn").on('click', function() {
		$(".edit-tel").hide();
		$(".edit-tel-btn").show();
	});

	$(".update-tel-btn").on('click', function() {
		let Telefono = $('.ReTelefono input').val();
    	let TelefonoExpReg = new RegExp(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/g);
	    if (Telefono == "" || Telefono == undefined) {
	        $('.ReTelefono input').removeClass("valid").addClass("invalid");
	        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	        M.toast({html: toastTelefono, displayLength: 5000});
	    } else if (!(TelefonoExpReg.test(Telefono))) {
	        $('.ReTelefono input').removeClass("valid").addClass("invalid");
	        let toastTelefono = '<span>Por favor revisa tú <strong>Número telefónico de Contacto.<br>10 Dígitos.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
	        M.toast({html: toastTelefono, displayLength: 5000});
	    } else if (TelefonoJS == Telefono) {
	    	$(".edit-tel").hide();
			$(".edit-tel-btn").show();
	    	let toastTelefono = '<span>No se encontró ningún <strong>cambio en tu Número de celular.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastTelefono, displayLength: 5000});
	    } else {
	        var datosTel =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'Telefono',
	            Telefono: Telefono
	        };
	        update(datosTel, 'Telefono');
	    }
	});

	//Edit Pass
	$(".edit-pass, .actualizar-pass").hide();
	$(".verificar-pass").show();
	$(".actualizar-pass").hide();
	

	$(".edit-pass-btn").on('click', function() {
		$('.error-verificar-pass').addClass("hide");
		$('.AntContraseña input').val('').removeClass("valid invalid");
		M.updateTextFields();
		closetoggle();
		$(".edit-pass-btn").hide();
		$(".edit-pass").show();
	});


	$(".close-pass-btn").on('click', function() {
		closetoggle();
		$(".edit-pass").hide();
		$(".edit-pass-btn").show();
	});

	$(".verificar-pass-btn").on('click', function() {
		let Contraseña = $('.AntContraseña input').val();
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
        if (Contraseña == "" || Contraseña == undefined) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (Contraseña.length < 8) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (!bien) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (espacio.test(Contraseña)) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (/^([0-9])*$/.test(Contraseña)) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
	       	$('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else {
	        var datosVerificar =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'Verificar',
	            Contraseña: Contraseña
	        };
	        update(datosVerificar, 'Verificar');
	    }
	});

	$(".update-pass-btn").on('click', function() {
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
	    if (Contraseña == "" || Contraseña == undefined) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Falta <strong>Contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (Contraseña.length < 8) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña muy corta.<br><strong>Almenos 8 carácteres.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (!bien) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña contiene<br><strong>caracteres no validos</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (espacio.test(Contraseña)) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>La contraseña no puede contener <br><strong>espacios en blanco.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (/^([0-9])*$/.test(Contraseña)) {
	        $('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos una letra</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (/^([A-Za-z])*$/.test(Contraseña)) {
	       	$('.ReContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Contraseña no valida.<br><strong>Introduzca almenos un número</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (ValContraseña == "" || ValContraseña == undefined) {
	        $('.ValContraseña input').removeClass("valid").addClass("invalid");
	        let toastCotraseña = '<span>Falta <strong>Validar la contraseña de la cuenta.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastCotraseña, displayLength: 5000});
	    } else if (Contraseña != ValContraseña) {
	        $('.ValContraseña input').removeClass("valid").addClass("invalid");
	        let toastValCotraseña = '<span><strong>Las contraseñas no coinciden.</strong></span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
			M.toast({html: toastValCotraseña, displayLength: 5000}); 
	    } else {
	        var datosContraseña =
	        {
	        	Documento: DocumentoJS,
	        	Form: 'Contraseña',
	            Contraseña: Contraseña
	        };
	        update(datosContraseña, 'Contraseña');
	    }
	});
	


	//mostrar contraseña anterior
    $(".mostrar-pass-ante").on( 'change', function() {
        if( $(this).is(':checked') ) {
            $('#Antcontraseña').get(0).type = 'text';
        }
        else {
            $('#Antcontraseña').get(0).type = 'password';
        }
    });
    //mostrar contraseña anterior
    $(".mostrar-pass-new").on( 'change', function() {
        if( $(this).is(':checked') ) {
            $('#contraseña').get(0).type = 'text';
            $('#valcontraseña').get(0).type = 'text';
        }
        else {
            $('#contraseña').get(0).type = 'password';
            $('#valcontraseña').get(0).type = 'password';
        }
    });
	// $(window).on('beforeunload', function() {
	//     $("html,body").animate({scrollTop: 0}, 100); 
	// });

});

function closetoggle() {
	$(".edit-nombre").hide();
	$(".edit-nombre-btn").show();
	$(".edit-brithday").hide();
	$(".edit-brithday-btn").show();
	$(".edit-rh").hide();
	$(".edit-rh-btn").show();
	$(".edit-foto").hide();
	$(".edit-foto-btn").show();
	$(".edit-tel").hide();
	$(".edit-tel-btn").show();
	$(".verificar-pass").show();
	$(".actualizar-pass").hide();
	$(".edit-pass").hide();
	$(".edit-pass-btn").show();
	$(".edit-lic-uno, .edit-lic-dos, .edit-lic-tres").hide();
	$(".edit-lic-uno-btn, .edit-lic-dos-btn, .edit-lic-tres-btn").show();
}
function resetRH(dato) {
	switch (dato) {
		case 'A+':
			$("#RH1").prop("checked", true);
			break;
		case 'A-':
			$("#RH2").prop("checked", true);
			break;
		case 'B+':
			$("#RH3").prop("checked", true);
			break;
		case 'B-':
			$("#RH4").prop("checked", true);
			break;
		case 'O+':
			$("#RH5").prop("checked", true);
			break;
		case 'O-':
			$("#RH6").prop("checked", true);
			break;
		case 'AB+':
			$("#RH7").prop("checked", true);
			break;
		case 'AB-':
			$("#RH8").prop("checked", true);
			break;
		case 1:
			return 'A+';
			break;
		case 2:
			return 'A-';
			break;
		case 3:
			return 'B+';
			break;
		case 4:
			return 'B-';
			break;
		case 5:
			return 'O+';
			break;
		case 6:
			return 'O-';
			break;
		case 7:
			return 'AB+';
			break;
		case 8:
			return 'AB-';
			break;
		default:
		break;
	}
}
function documento() {
	let toastDocumento = '<span><strong>¿Deseass modificar el documento?</strong><br>Comuníquese con un administrador.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
    M.toast({html: toastDocumento, displayLength: 5000});
}

function resetLic() {
	let NumLicencia = ['uno', 'dos', 'tres'];
	let Licencias = ['U', 'A1', 'A2', 'B1', 'B2', 'B3', 'C1', 'C2', 'C3'];

	LicenciasJS.forEach( function(valor, indice) {
		let tipoLicencia = Licencias.indexOf(valor);
		let option = '.Licencia-' + NumLicencia[indice];
		let optionSelected = option + ' option[value="'+tipoLicencia+'"]';
		let updateSelect = (LicenciasJS[0].substr(0,1) + LicenciasJS[1].substr(0,1) + LicenciasJS[2].substr(0,1));

		if (indice == 0) {
			OpcionesLicenciaUno(updateSelect);
		} else if (indice == 1) {
			OpcionesLicenciaDos(updateSelect);
		}else {
			OpcionesLicenciaTres(updateSelect);
		}
		$(optionSelected).prop('selected', true);
		$(option).formSelect();
		
	});

	FechaLicenciasJS.forEach( function(valor, indice) {
		let fechaInput = '.Expedicion-' + NumLicencia[indice];
		let newDateLic  = valor.concat('', 'T00:00:00');

		const actualBrithday = FechaNacJs.concat(' ', 'T00:00:00');
		let array_fecha = actualBrithday.split(' ');
        let dia = array_fecha[0];
        let mes = ConvertMes(array_fecha[1]);
        let año = array_fecha[2];
        let zonaHora = array_fecha[3];
        let formatoDate = (año+'-'+mes+'-'+dia+zonaHora);
        let fechaActual = new Date(formatoDate);

		let minDate = new Date(fechaActual);
			minDate.setFullYear(minDate.getFullYear() + 16);

		if( valor == "U") {
			$(fechaInput).datepicker({
				format: 'dd mmm, yyyy',
				minDate: new Date(minDate),
				maxDate: new Date(),
				minYear: new Date(minDate).getFullYear(),
    			maxYear: new Date().getFullYear()
			});
		}else {
	    	$(fechaInput).datepicker({
				defaultDate: new Date(newDateLic),
		        setDefaultDate: true,
				format: 'dd mmm, yyyy',
				minDate: new Date(minDate),
				maxDate: new Date(),
				minYear: new Date(minDate).getFullYear(),
    			maxYear: new Date().getFullYear()
			});
		}
	});
}

function update(datos, tipo) {
	$.ajax ({
        type: "POST",
        url: "update.php",
        data: datos, 
        beforeSend: function() {
        	if(tipo == 'Nombre') {
        		$('.form-nombre').addClass("hide");
    			$('.while-update-nombre').removeClass("hide");
        	} else if(tipo == 'FechaNacimiento') {
        		$('.form-brithday').addClass("hide");
    			$('.while-update-brithday').removeClass("hide");
        	} else if(tipo == 'RH') {
        		$('.form-rh').addClass("hide");
    			$('.while-update-rh').removeClass("hide");
        	} else if(tipo == 'Telefono') {
        		$('.form-tel').addClass("hide");
    			$('.while-update-tel').removeClass("hide");
        	} else if(tipo == 'Verificar') {
        		$('.form-pass').addClass("hide");
    			$('.while-verificar-pass').removeClass("hide");
    			$('.error-verificar-pass').addClass("hide");
        	} else if (tipo == 'Contraseña') {
        		$('.form-pass').addClass("hide");
    			$('.while-update-pass').removeClass("hide");
        	} else if (tipo == 'Foto') {
        		$('.form-foto').addClass("hide");
    			$('.while-update-foto').removeClass("hide");
        	} else if (tipo == 'LicenciaUpdate') {
				$(".form-lic-uno, .form-lic-dos, .form-lic-tres").hide();
				$(".while-update-lic-uno, .while-update-lic-dos, .while-update-lic-tres").removeClass('hide');
			} else if(tipo == 'LicenciaAdd') {
				$(".form-lic-uno, .form-lic-dos, .form-lic-tres").hide();
				$(".while-add-lic-dos, .while-add-lic-tres").removeClass('hide');
			}
        	$('body').addClass('block');
        }, success: function(obj) {
				let result = window.location;
        	setTimeout(function() {
                if (obj == 1) {
					let newurl = result + '?update=1';
					window.location = newurl;
                } else if (obj == 2) {
    				$(".verificar-pass").hide();
    				$('.while-verificar-pass').addClass("hide");
					$('.form-pass').removeClass("hide");
    				$(".actualizar-pass").show();
    				$('body').removeClass('block');
    				let toastSuccess = '<span><strong>Sé verífico correctamente su contraseña</strong><br>Ya puedes elegir tu nueva contraseña.</span><button onclick="$(this).parent().fadeOut()" class="btn-flat toast-action"><i class="material-icons">close</i></button>';
					M.toast({html: toastSuccess, displayLength: 5000});
                } else if (obj == 3) {
    				$(".actualizar-pass").hide();
					$('.form-pass').removeClass("hide");
    				$('.while-verificar-pass').addClass("hide");
    				$('.error-verificar-pass').removeClass("hide");
    				$(".verificar-pass").show();
    				$('body').removeClass('block');
                } else if (obj == 4) {
    				$(".verificar-pass").hide();
    				$('.while-update-pass').addClass("hide");
    				$('.error-verificar-pass').addClass("hide");
    				$('.error-update-pass').removeClass("hide");
					$('.form-pass').removeClass("hide");
    				$(".actualizar-pass").show();
    				$('body').removeClass('block');
                } else {
					let newurl = result + '?update=0';
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

function OpcionesLicenciaUno(licencia) {
	switch (licencia) {
		//A
		case 'ABC':
		case 'ACB':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option>');
			break;
		//AB	
		case 'BCU':
		case 'ACU':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//AC	
		case 'CBU':
		case 'ABU':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//B
		case 'BAC':
		case 'BCA':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//BC
		case 'CAU':
		case 'BAU':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//C
		case 'CAB':
		case 'CBA':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//ABC
		case 'AUU':
		case 'BUU':
		case 'CUU':
			$('.Licencia-uno').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;

        default:
            break;
    }
}
function OpcionesLicenciaDos(licencia) {
	switch (licencia) {
		//A
		case 'BAC':
		case 'CAB':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option>');
			break;
		//AB	
		case 'CUU':
		case 'CAU':
		case 'CBU':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//AC	
		case 'BAU':
		case 'BCU':
		case 'BUU':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//B
		case 'ABC':
		case 'CBA':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//BC
		case 'ABU':
		case 'ACU':
		case 'AUU':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//C
		case 'ACB':
		case 'BCA':
			$('.Licencia-dos').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
        default:
            break;
    }
}
function OpcionesLicenciaTres(licencia) {
	switch (licencia) {
		//A
		case 'BCA':
		case 'BCU':
		case 'CBA':
		case 'CBU':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option>');
			break;
		//AB	
		case 'CUU':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//AC	
		case 'BUU':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="1">A1</option><option value="2">A2</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//B
		case 'CAB':
		case 'CAU':
		case 'ACU':
		case 'ACB':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option>');
			break;
		//BC
		case 'AUU':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="3">B1</option><option value="4">B2</option><option value="5">B3</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
		//C
		case 'ABC':
		case 'ABU':
		case 'BAC':
		case 'BAU':
			$('.Licencia-tres').children().remove().end().append('<option value="0" disabled>Categoria de licencia</option><option value="6">C1</option><option value="7">C2</option><option value="8">C3</option>');
			break;
        default:
            break;
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