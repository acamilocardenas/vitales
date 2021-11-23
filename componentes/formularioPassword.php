<div class="container formulario-password">
    <div class="row">
        <div class="col s12 show-on-medium-and-up hide-on-small-only animate__animated animate__bounceIn">
            <h2 class="valign-wrapper white-text modelica-bold">
                <span><img class="bienvenido-img" src="img/logo.png" alt=""></span>LICENCIA VIAL
            </h2>
        </div>
        <div class="col s12 show-on-small hide-on-med-and-up animate__animated animate__bounceIn">
            <h4 class="fold valign-wrapper white-text modelica-bold">
                <span><img class="bienvenido-img" src="img/logo.png" alt=""></span>LICENCIA VIAL
            </h4>
        </div>

        <!-- inicio del formulario de password-->
        <div class="col s12 m9 l8 animate__animated animate__fadeIn animate__dalay-1s">
            <div class="row z-depth-2">
                <ul class="tabs tabs-forgot">
                    <li class="tab col s12">
                        <a class="active">
                            <b>
                                <i class="material-icons left waves-effect waves-light" onclick="CancelarCambio();">keyboard_backspace</i>CAMBIAR CONTRASEÑA
                            </b>
                        </a>
                    </li>
                </ul>
                <div class="col s12 white active">

                    <div class="valign-wrapper">
                        <div class="col s12 mensaje">
                            <p class="center"><b>¡Ya puedes elegir tu nueva contraseña!</b><br>Los datos suministrados fueron validados correctamente, al parecer demostraste que eres el propietario de la cuenta.</p>
                        </div>
                    </div>

                    <form action="password.php" method="post" autocomplete="off" onsubmit="return ValidarPassword(this);">

                        <!-- datos personales -->
                        <blockquote class="card-panel hoverable">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">fingerprint</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">ELIGE TU NUEVA CONTRASEÑA</h5>
                                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">ELIGE TU NUEVA CONTRASEÑA</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>

                            <div class="valign-wrapper">
                                <div class="col s12 informacion">
                                    <p class="center"><b>*Ten encuenta que tu nueva contraseña:</b><br>Solo puede tener números y letras, contener mínimo 8 carácteres, mínimo una letra, mínimo un número y no pueden haber espacios en blanco.<br>Todos los campos <b>son obligatorios.</b></p>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s11 CaContraseña">
                                    <input id="contraseña" type="password"  name="NewContraseña">
                                    <label for="contraseña">Nueva contraseña*</label>
                                    <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                                </div>
                                <div class="tippedpass col s1">
                                    <a class="tooltipped" data-position="top" data-tooltip="<div style='width:250px; text-align: left!important; padding-left: 15px!important;'>Solo números y letras.<br>Mínimo 8 carácteres.<br>Mínimo una letra.<br>Mínimo un número.<br>No contener espacios en blanco.</div>"><i class="material-icons">feedback</i></a>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 ValCaContraseña">
                                    <input id="valcontraseña" type="password">
                                    <label for="valcontraseña">Confirmar nueva contraseña*</label>
                                    <span class="helper-text" data-error="Las contraseñas no coinciden" data-success="Las contraseñas coinciden"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s11"  style="margin-top: -20px;"> 
                                    <label>
                                        <input type="checkbox" class="filled-in mostrar-pass"/>
                                        <span>Mostrar contraseñas</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row input-form hide">
                               <div class="input-field col s12 CaDocumento ">
                                  <input id="Documento" autocomplete="off" type="text" value="<?= $Documento ?>" name="CedulaV" id="disabled">
                                  <label for="Documento">Usuario*</label>
                               </div>
                            </div>
                        
                            <div class="row input-form hide">
                               <div class="input-field col s12 CAHash ">
                                  <input id="Hash" autocomplete="off" type="text" value="<?= $Hash ?>" name="HashV" id="disabled">
                                  <label for="Hash">Hash*</label>
                               </div>
                            </div>

                        </blockquote>

                        <!-- boton logIn -->
                        <div class="row">

                            <!-- mensaje de formulario correcto al enviar -->
                            <div class="valign-wrapper cambioPassSuccess hide">
                                <div class="col s12 informacion">
                                    <p class="center"><b>¡Procesando nueva contraseña!</b><br>Tus datos fueros validados y enviados correctamente.<br>Espere un momento...</p>
                                </div>
                            </div>

                            <!-- mensaje de formulario incorrecto al enviar -->
                            <div class="valign-wrapper cambioPassError hide">
                                <div class="col s12 alertaError">
                                    <p class="center"><b>¡No podemos procesar la nueva contraseña!</b><br>Formulario incompleto o incorrecto.<br>Por favor que las dos contraseñas coincidan.</p>
                                </div>
                            </div>

                            <div class="input-field col s12 center-align btn-password">
                                <button class="btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit" name="Reset">
                                    <b>RESTABLECER</b>
                                    <i class="material-icons right">lock_outline</i>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <?php 
                    include 'footer.php'; // Incluir footer
                ?>

            </div>
        </div>
    </div>
</div>