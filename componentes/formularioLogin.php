<div class="container formulario-login">
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

        <!-- inicio del formulario de login -->
        <div class="col s12 m9 l8 animate__animated animate__fadeIn animate__dalay-1s">
            <div class="row z-depth-2">
                <ul class="tabs tabs-formulario">
                    <li class="tab col s12">
                        <a class="active">
                            <b class="modelica-bold orange-text text-darken-4">
                                <i class="material-icons left waves-effect waves-light btn-atras" onclick="location.href='index.php'">keyboard_backspace</i>INICIAR SESIÓN
                            </b>
                        </a>
                    </li>
                </ul>
                <div class="col s12 white active">

                    <form action="acceder.php" method="post" autocomplete="off" onsubmit="return ValidarLogin(this);">

                        <!-- datos personales -->
                        <blockquote class="card-panel hoverable">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">account_box</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">BIENVENIDO</h5>
                                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">BIENVENIDO</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 InUsuario">
                                    <input id="InDocumento" type="text" name="Documento" style="text-transform:lowercase">
                                    <label for="InDocumento">Número de identificación*</label>
                                    <span class="helper-text" data-error="Documento incorrecto" data-success="Documento correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s11 InContraseña">                                      
                                    <input id="InContraseña" type="password"  name="Contraseña">
                                    <label for="InContraseña">Contraseña*</label>
                                    <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                                </div>
                                <div class="tippedpass col s1">
                                    <a class="tooltipped" data-position="top" data-tooltip="<div style='width:250px; text-align: left!important; padding-left: 15px!important;'><b>Recuerda:</b><br>Solo números y letras.<br>Mínimo 8 carácteres.<br>Mínimo una letra.<br>Mínimo un número.<br>No contener espacios en blanco.</div>"><i class="material-icons">feedback</i></a>
                                </div>
                            </div>

                            <div class="row">
                                 <div class="input-field col s11"  style="margin-top: -20px;"> 
                                    <label>
                                       <input type="checkbox" class="filled-in mostrar-pass"/>
                                       <span>Mostrar contraseña</span>
                                    </label>
                                 </div>
                              </div>

                            <div class="right-align show-on-medium-and-up hide-on-small-only">
                                <a href="verificar-cuenta.php" class="modelica-bold waves-effect btn-flat blue-text text-darken-3 btn-ir-forgot"><b>¿Olvidaste tu contraseña?</b></a>
                            </div>
                            <div class="right-align show-on-small hide-on-med-and-up">    
                                <a href="verificar-cuenta.php" class="modelica-bold waves-effect btn-flat blue-text text-darken-3 btn-ir-forgot "><b>¿Olvidaste tu clave?</b></a>
                            </div>

                        </blockquote>

                        <!-- boton logIn -->
                        <div class="row">

                            <!-- mensaje de formulario correcto al enviar -->
                            <div class="valign-wrapper loginSuccess hide">
                                <div class="col s12 informacion">
                                    <p class="center"><b>¡Procesando datos de inicio de sección!</b><br>Tus datos fueros validados y enviados correctamente.<br>Espere un momento...</p>
                                </div>
                            </div>

                            <!-- mensaje de formulario incorrecto al enviar -->
                            <div class="valign-wrapper loginError hide">
                                <div class="col s12 alertaError">
                                    <p class="center"><b>¡No podemos iniciar sección!</b><br>Formulario incompleto o incorrecto.<br>Por favor revisa tus datos para iniciar sección.</p>
                                </div>
                            </div>

                            <div class="input-field col s12 center-align btn-login">
                                <button class="modelica-bold btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit" name="Entrar">
                                    <b>ENTRAR</b>
                                    <i class="material-icons right">vpn_key</i>
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