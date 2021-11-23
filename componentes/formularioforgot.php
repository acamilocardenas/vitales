<div class="container formulario-forgot">
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

        <!-- inicio del formulario de forgot -->
        <div class="col s12 m9 l8 animate__animated animate__fadeIn animate__dalay-1s">
            <div class="row z-depth-2">
                <ul class="tabs tabs-forgot">
                    <li class="tab col s12">
                        <a class="active modelica-bold">
                            <b>
                                <i class="material-icons left waves-effect waves-light btn-atras" onclick="location.href='acceder.php'">keyboard_backspace</i>¿OLVIDASTE TU CONTRASEÑA?
                            </b>
                        </a>
                    </li>
                </ul>
                <div class="col s12 white active">

                    <div class="valign-wrapper">
                        <div class="col s12 alerta">
                            <p class="center"><b>Para poder restablecer tu contraseña:</b><br>Es necesario que proporciones los siguientes datos, para validar que tú eres el auténtico dueño de la cuenta.</p>
                        </div>
                    </div>

                    <form action="verificar-cuenta.php" method="post" autocomplete="off" onsubmit="return Validarforgot(this);">

                        <!-- datos personales -->
                        <blockquote class="card-panel hoverable">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">how_to_reg</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">VALIDACIÓN DE USUARIO</h5>
                                    <h5 class="modelica-bold center show-on-small hide-on-med-and-up">VALIDACIÓN DE USUARIO</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>


                            <div class="valign-wrapper">
                                <div class="col s12 informacion">
                                    <p class="center">Todos los campos marcados con asterisco <b>(*) Son obligatorios.</b></p>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 FoDocumento">
                                    <input id="FoDocumento" type="text" name="Documento" style="text-transform:lowercase">
                                    <label for="FoDocumento">Número de identificación*</label>
                                    <span class="helper-text" data-error="Documento incorrecto" data-success="Documento correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12">
                                    <input id="FoNacimiento" type="text" class="datepicker FoNacimiento" name="Nacimiento">
                                    <label for="FoNacimiento">Fecha de nacimiento*</label>
                                    <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 FoRH">
                                    <select id="FoRh" name="Rh">
                                        <option value="" disabled selected>Grupo sanguíneo y RH</option>
                                        <?php
                                            $opcionesRH = $mysqli -> query ("SELECT * FROM RH") or die($mysqli->error());
                                            while ( $valores = mysqli_fetch_array( $opcionesRH ) ) {
                                                echo '<option value="'.$valores['nombreRH'].'">'.$valores['nombreRH'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="FoRh">Grupo sanguíneo y RH*</label>
                                    <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 FoTelefono">
                                    <input  id="FoTelefono" type="text" class="Telefono" name="Telefono">
                                    <label for="FoTelefono">Número de celular registrado*</label>
                                    <span class="helper-text" data-error="Número de Contacto Incorrecto" data-success="Número de Contacto correcto"></span>
                                </div>
                            </div>

                        </blockquote>

                        <!-- boton logIn -->
                        <div class="row">

                            <!-- mensaje de formulario correcto al enviar -->
                            <div class="valign-wrapper forgotSuccess hide">
                                <div class="col s12 informacion">
                                    <p class="center"><b>¡Validando todos los datos proporcionados!</b><br>Espere un momento...</p>
                                </div>
                            </div>

                            <!-- mensaje de formulario incorrecto al enviar -->
                            <div class="valign-wrapper forgotError hide">
                                <div class="col s12 alertaError">
                                    <p class="center"><b>¡No podemos validar los datos proporcionados!</b><br>Formulario incompleto o incorrecto.<br>Por favor revisa tus datos para iniciar sección.</p>
                                </div>
                            </div>

                            <div class="input-field col s12 center-align btn-forgot">
                                <button class="modelica-bold btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit" name="Forgot">
                                    <b>RESTABLECER</b>
                                    <i class="material-icons right">lock_open</i>
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