<div class="container formulario-registro">
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

        <!-- inicio del formulario de registro -->
        <div class="col s12 m9 l8 animate__animated animate__fadeIn animate__dalay-1s">
            <div class="row z-depth-2">
                <ul class="tabs tabs-formulario">
                    <li class="tab col s12">
                        <a class="active">
                            <b class="orange-text text-darken-4 modelica-bold">
                                <i class="material-icons left waves-effect waves-light btn-atras " onclick="location.href='index.php'">keyboard_backspace</i>FORMULARIO DE REGÍSTRO
                            </b>
                        </a>
                    </li>
                </ul>
                <div class="col s12 white active">

                    <div class="valign-wrapper">
                        <div class="col s12 informacion">
                            <p class="center">Todos los campos marcados con asterisco <b>(*) Son obligatorios.</b></p>
                        </div>
                    </div>

                    <div class="valign-wrapper">
                        <div class="col s12 alerta">
                            <p class="center">El <b>Programa Vitales</b> es solo para <b>personal autorizado de NORGAS y COTRANSCOL.</b></p>
                        </div>
                    </div>

                    <form action="registrate.php" method="post" autocomplete="off" onsubmit="return ValidarRegistro(this);">

                        <!-- datos personales -->
                        <blockquote class="card-panel hoverable">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">how_to_reg</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">DATOS PERSONALES</h5>
                                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">DATOS PERSONALES</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>
                            

                            <div class="row input-form">
                                <div class="input-field col s12 ReNombres">
                                    <input id="Nombre" type="text" name="Nombre">
                                    <label for="Nombre" >Nombre*</label>
                                    <span class="helper-text" data-error="Nombre incorrecto" data-success="Nombre correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 ReApellidos">
                                    <input id="Apellido" type="text" name="Apellido">
                                    <label for="Apellido">Apellidos*</label>
                                    <span class="helper-text" data-error="Apellidos incorrecto" data-success="Apellidos correcto"></span>
                                </div>
                            </div>

                            <div class="valign-wrapper">
                                <div class="col s12 informacion">
                                    <p class="center"><b>*Ten encuenta que:</b><br>Para poder ser parte del programa Vitales debes tener mínimo 16 años, contar con al menos una licencia de condición y ser empleado de NORGAS o COTRANSCOL.</p>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12">
                                    <input id="Nacimiento" type="text" class="datepicker ReNacimiento" name="Nacimiento">
                                    <label for="Nacimiento">Fecha de nacimiento*</label>
                                    <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                                </div>
                            </div>
                            
                            <div class="row input-form">
                                <div class="valign-wrapper">
                                    <div class="col s12 alerta">
                                        <p class="center"><b>¡Importante!</b><br>Tu número de identificación será tu usuario para ingresar al sitio.</p>
                                    </div>
                                </div>
                                <div class="input-field col s12 ReDocumento">
                                    <input  id="Documento" type="text" class="Documento" name="Documento">
                                    <label for="Documento">Número de identificación*</label>
                                    <span class="helper-text" data-error="Documento incorrecto" data-success="Documento correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 ReRH">
                                    <select id="Rh" name="Rh">
                                        <option value="" disabled selected>Grupo sanguíneo y RH</option>
                                        <?php
                                            $opcionesRH = $mysqli -> query ("SELECT * FROM RH") or die($mysqli->error());
                                            while ( $valores = mysqli_fetch_array( $opcionesRH ) ) {
                                                echo '<option value="'.$valores['idRH'].'">'.$valores['nombreRH'].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="Rh">Grupo sanguíneo y RH*</label>
                                    <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                </div>
                            </div>
                        </blockquote>

                        <!-- foto perfil -->    
                        <blockquote class="card-panel hoverable">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">account_circle</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">FOTO DEL PERFIL</h5>
                                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">FOTO DEL PERFIL</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>

                            <div class="valign-wrapper">
                                <div class="col s12 alerta">
                                    <p class="center"><b>Instrucciones:</b><br>Cargue al sistema una <b>imagen sin trasparencias</b>.<br>Utilice el editor para ajustar la posición y tamaño de la imagen.<br>Observe los resultados <b>en la vista previa</b>.</p>
                                </div>
                            </div>

                            <div>
                                <div class="file-field input-field">
                                    <div class="btn blue darken-3">
                                        <span><b>Subir foto</b></span>
                                        <input id="foto" type="file" accept="image/x-png,image/gif,image/jpeg" class="foto" name="foto">
                                    </div>
                                    <div class="file-path-wrapper ReFoto">
                                        <input class="file-path" type="text" placeholder="Foto de perfil*">
                                        <span class="helper-text" data-error="Imagen no cargada o eliminada" data-success="Imagen cargada correctamente"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row editorPrew hide">
                                
                                <div class="valign-wrapper">
                                    <div class="col s12 informacion">
                                        <p><i class="material-icons left">photo_size_select_large</i><b>Editor</b></p>
                                        <div id="editor"></div>
                                        <p><b>Como funciona*</b><br>Deslice el rectángulo delimitador desde el centro para ajustar la posición del área deseada.<br>Arrastre los manejadores de las esquinas y los lados para ajustar el tamaño del área seleccionada.</p>
                                    </div>
                                </div>

                                <div class="valign-wrapper">
                                    <div class="col s12 mensaje">
                                        <p><i class="material-icons left">visibility</i><b>Vista Previa</b></p>
                                        <canvas class="fotoPerfil" id="preview"></canvas>
                                        <p style="text-align: center;">Aquí puede observar los resultados.<br>La foto de perfil será publicada conforme se muestra en esta vista previa.</p>
                                    </div>
                                </div>

                            </div>

                            <div class="row hide">
                                <div class="input-field col s12 fotoBase64">
                                    <textarea id="fotoBase64" class="materialize-textarea" name="fotoBase64" value=""></textarea>
                                    <label for="fotoBase64" class="active">Foto Base64</label>
                                </div>
                            </div>  

                        </blockquote>

                        <!-- datos de la licencia de conduccion -->
                        <blockquote class="card card-panel hoverable licencia">

                            <div class=" valign-wrapper titulo-formulario">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">local_shipping</i></h4></div>
                                <div class="col s10">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">DATOS DE LA LICENCIA</h5>
                                    <h5 class="modelica-bold show-on-small hide-on-med-and-up">DATOS DE LA LICENCIA</h5>
                                </div>
                                <div class="col s1"></div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 ReLicencia">
                                    <select id="Licencia" name="LicenciaUno">
                                        <option value="0" disabled selected>Categoria de licencia</option>
                                        <option value="1">A1</option>
                                        <option value="2">A2</option>
                                        <option value="3">B1</option>
                                        <option value="4">B2</option>
                                        <option value="5">B3</option>
                                        <option value="6">C1</option>
                                        <option value="7">C2</option>
                                        <option value="8">C3</option>
                                    </select>
                                    <label for="Licencia">Licencia de conducción*</label>
                                    <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 expedicion">
                                    <input id="Expedicion" type="text" class="datepicker ReExpedicion" name="ExpedicionUno">
                                    <label for="Expedicion">Fecha Expedición*</label>
                                    <span class="helper-text" data-error="Fecha expedicion incorrecta" data-success="Fecha Expedicion correcta"></span>
                                </div>
                                <a class="tooltipped btn-floating halfway-fab waves-effect waves-light hoverable btn-nueva-licencia pulse" data-position="left" data-tooltip="<div style='max-width:250px; text-align: center!important; padding: 0px 15px!important;'>Agregar otra<br><b>Licencia de conducción</b></div>"><i class="material-icons">add</i></a>
                            </div>

                            <blockquote class="card-panel hoverable nueva-licencia dos hide">

                                <div class=" valign-wrapper titulo">
                                    <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">local_shipping</i></h4></div>
                                    <div class="col s10">
                                        <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">NUEVA LICENCIA</h5>
                                        <h5 class="modelica-bold show-on-small hide-on-med-and-up">NUEVA LICENCIA</h5>
                                    </div>
                                    <div class="col s1"></div>
                                </div>

                                <div class="row input-form">
                                    <div class="input-field col s12 ReLicencia2">
                                        <select id="Licencia2" name="LicenciaDos" disabled>
                                            <option value="0" disabled selected>Categoria de licencia</option>
                                        </select>
                                        <label for="Licencia2">Nueva licencia de conducción*</label>
                                        <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                    </div>
                                </div>

                                <div class="row input-form">
                                    <div class="input-field col s12 expedicion">
                                        <input id="Expedicion2" type="text" class="datepicker ReExpedicion2" name="ExpedicionDos">
                                        <label for="Expedicion2">Fecha Expedición*</label>
                                        <span class="helper-text" data-error="Fecha expedicion incorrecta" data-success="Fecha Expedicion correcta"></span>
                                    </div>
                                </div>

                                <div class="right-align">    
                                    <a class="modelica-bold waves-effect waves-light btn-small red lighten-1 hoverable btn-remover-licencia-dos"><i class="material-icons left">remove_circle_outline</i>Remover licencia</a>
                                </div>

                            </blockquote>

                            <blockquote class="card-panel hoverable nueva-licencia tres hide">

                                <div class=" valign-wrapper titulo">
                                    <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">local_shipping</i></h4></div>
                                    <div class="col s10">
                                        <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">NUEVA LICENCIA</h5>
                                        <h5 class="modelica-bold show-on-small hide-on-med-and-up">NUEVA LICENCIA</h5>
                                    </div>
                                    <div class="col s1"></div>
                                </div>

                                <div class="row input-form">
                                    <div class="input-field col s12 ReLicencia3">
                                        <select id="Licencia3" name="LicenciaTres" disabled>
                                            <option value="0" disabled selected>Categoria de licencia</option>
                                        </select>
                                        <label for="Licencia3">Nueva licencia de conducción*</label>
                                        <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                    </div>
                                </div>

                                <div class="row input-form">
                                    <div class="input-field col s12 expedicion">
                                        <input id="Expedicion3" type="text" class="datepicker ReExpedicion3" name="ExpedicionTres">
                                        <label for="Expedicion3">Fecha Expedición*</label>
                                        <span class="helper-text" data-error="Fecha expedicion incorrecta" data-success="Fecha Expedicion correcta"></span>
                                    </div>
                                </div>

                                <div class="right-align">    
                                    <a class="modelica-bold waves-effect waves-light btn-small red lighten-1 hoverable btn-remover-licencia-tres"><i class="material-icons left">remove_circle_outline</i>Remover licencia</a>
                                </div>

                            </blockquote>

                            <div class="right-align">    
                                <a class="modelica-bold waves-effect waves-light btn-small hoverable btn-nueva-licencia"><i class="material-icons left">add_circle_outline</i>Agregar Licencia de conducción</a>
                            </div>
                        </blockquote>


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
                                    <p class="center"><b>Protección de tu cuenta*</b><br>Usarás esta información cuando entres a tú cuenta y si alguna vez tienes que cambiar la contraseña.</p>
                                </div>
                            </div>

                            <div class="row input-form">
                                <div class="input-field col s12 ReTelefono">
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
                                <div class="input-field col s11 ReContraseña">
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
                                        <input type="checkbox" class="filled-in mostrar-pass"/>
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
                                <p class="center"><b>¡Procesando Registro!</b><br>Tus datos fueros validados y enviados correctamente.<br>Espere un momento...</p>
                            </div>
                        </div>

                        <!-- mensaje de formulario incorrecto al enviar -->
                        <div class="valign-wrapper registroError hide">
                            <div class="col s12 alertaError">
                                <p class="center"><b>¡No podemos registrarlo!</b><br>Formulario incompleto o incorrecto.<br>Por favor revisa tus datos registrados.</p>
                            </div>
                        </div>

                        <div class="input-field col s12 center-align btn-registrar">
                            <button class="modelica-bold btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit" name="Registrarse">
                                <b>REGÍSTRARME</b>
                                <i class="material-icons right">assignment</i>
                            </button>
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