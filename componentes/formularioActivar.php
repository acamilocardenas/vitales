<div class="col s12 white active">
	<div class="valign-wrapper">
        <div class="col s12 informacion">
            <p class="center">Todos los campos marcados con asterisco <b>(*) Son obligatorios.</b></p>
        </div>
    </div>
	<form action="activar-cuenta.php" method="post" autocomplete="off" onsubmit="return ValidarActivacion(this);">
<!-- Contraseña -->
        <blockquote class="card-panel hoverable">

            <div class=" valign-wrapper titulo-formulario">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">lock</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">SEGURIDAD DE LA CUENTA</h5>
                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">SEGURIDAD DE LA CUENTA</h5>
                </div>
                <div class="col s1"></div>
            </div>


            <div class="valign-wrapper">
                <div class="col s12 alerta">
                    <p class="center"><b>Protección de tu cuenta*</b><br>La contraseña con la que accediste es temporal y requiere ser cambiada de inmediato con el fin de mejorar la seguridad y privacidad de tu cuenta.<br>Usaras esta información cuando entres a tú cuenta y si alguna vez tienes que cambiar la contraseña.</p>
                </div>
            </div>

            <div class="row input-form hide">
               <div class="input-field col s12 AcDocumento">
                  <input id="Documento" autocomplete="off" type="text" value="<?= $documento ?>" name="Documento" id="disabled">
                  <label for="Documento">Usuario*</label>
               </div>
            </div>

            <div class="row input-form hide">
               <div class="input-field col s12 AcPass">
                  <input id="Documento" autocomplete="off" type="text" value="<?= $pass ?>" name="Pass" id="disabled">
                  <label for="Documento">pass*</label>
               </div>
            </div>

            <div class="row input-form hide">
               <div class="input-field col s12 AcHash">
                  <input id="Documento" autocomplete="off" type="text" value="<?= $hash ?>" name="Hash" id="disabled">
                  <label for="Documento">hash*</label>
               </div>
            </div>

            <div class="row input-form">
                <div class="input-field col s12 AcTelefono">
                    <input  id="Telefono" type="text" class="Telefono" name="Telefono">
                    <label for="Telefono">Número de celular*</label>
                    <span class="helper-text" data-error="Número de Contacto Incorrecto" data-success="Número de Contacto correcto"></span>
                </div>
            </div>

            <div class="valign-wrapper">
                <div class="col s12 informacion">
                    <p class="center"><b>*Ten encuenta que tu contraseña:</b><br>Solo puede tener números y letras, contener mínimo 8 carácteres, mínimo una letra, mínimo un número y no pueden haber espacios en blanco.</p>
                </div>
            </div>

            <div class="row input-form">
                <div class="input-field col s11 AcContraseña">
                    <input id="contraseña" type="password"  name="Contraseña">
                    <label for="contraseña">Establecer una contraseña*</label>
                    <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                </div>
                <div class="tippedpass col s1">
                    <a class="tooltipped" data-position="top" data-tooltip="<div style='width:250px; text-align: left!important; padding-left: 15px!important;'>Solo números y letras.<br>Mínimo 8 carácteres.<br>Mínimo una letra.<br>Mínimo un número.<br>No contener espacios en blanco.</div>"><i class="material-icons">feedback</i></a>
                </div>
            </div>

            <div class="row input-form">
                <div class="input-field col s12 ValContraseña">
                    <input id="valcontraseña" type="password">
                    <label for="valcontraseña">Repetir contraseña*</label>
                    <span class="helper-text" data-error="Las contraseñas no coinciden" data-success="Las contraseñas coinciden"></span>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s11"  style="margin-top: -20px;"> 
                    <label>
                        <input type="checkbox" class="filled-in AcMostrar-pass"/>
                        <span>Mostrar contraseñas</span>
                    </label>
                </div>
            </div>

        </blockquote>

        <!-- terminos y condiciones -->
        <blockquote class="card-panel hoverable">

            <div class=" valign-wrapper titulo-formulario">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">playlist_add_check</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">TÉRMINOS Y CONDICIONES</h5>
                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">TÉRMINOS Y CONDICIONES</h5>
                </div>
                <div class="col s1"></div>
            </div>

            <div class="valign-wrapper">
                <div class="col s12 informacion">
                    <p class="center">**Para finalizar tu registro debes <b>aceptar los términos y condiciones.</b></p>
                </div>
            </div>

            <div class="valign-wrapper">
                <div class="col s12 mensaje">
                    <p class="center">Doy fe de haber sido notificado e informado y acepto el nuevo modelo de seguridad vial adoptado por el grupo NORGAS S.A. enfocado a la reducción de accidentes de tránsito; mediante el cumplimento de los estándares de seguridad vial, establecidos en las políticas corporativas.<a class="modal-trigger" href="#politicas"> Consultar AQUÍ.</a></p>
                    <p class="center">Autorizo de forma libre, consciente, expresa e informada el tratamiento de mis datos personales de acuerdo a lo establecido en la política de tratamiento de datos personales y el aviso de privacidad.<a class="modal-trigger" href="#tratamiento"> Consultar AQUÍ.</a></p>
                </div>
            </div>

            <div class="row valign-wrapper">
                <div class="switch col s12 center-align">
                    <label>
                        No acepto
                        <input type="checkbox" name="terminos">
                        <span class="lever"></span>
                        Si acepto
                    </label>
                </div>
            </div>

        </blockquote>


        <!-- boton registro -->

            <!-- mensaje de formulario correcto al enviar -->
            <div class="valign-wrapper registroSucces hide">
                <div class="col s12 informacion">
                    <p class="center"><b>¡Procesando activación!</b><br>Tus datos fueros validados y enviados correctamente.<br>Espere un momento...</p>
                </div>
            </div>

            <!-- mensaje de formulario incorrecto al enviar -->
            <div class="valign-wrapper registroError hide">
                <div class="col s12 error">
                    <p class="center"><b>¡No podemos Activar tu cuenta!</b><br>Formulario incompleto o incorrecto.<br>Por favor revisa tus datos registrados.</p>
                </div>
            </div>

            <div class="input-field col s12 center-align btn-registrar" style="margin-bottom: 0px">
                <button class="modelica-bold btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit" name="ActivarCuenta">
                    <b>ACTIVAR CUENTA</b>
                    <i class="material-icons right">emoji_people</i>
                </button>
            </div>

    </form>
</div>
