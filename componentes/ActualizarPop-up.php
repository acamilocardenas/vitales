<!-- Pop-Up actualizar nombre -->
<div id="actualizar-nombre" class="modal bottom-sheet">
    <div class="modal-content">
        <article class="">
            <!-- <img src="img/actualizar.png" class="politicas center"> -->
            <div class="valign-wrapper blue-text text-darken-3">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4 style="margin: 0px 10px 0px 0px;"><i class="material-icons">face</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold" style="margin: 0px">Nombre</h5>
                </div>
                <div class="col s1"></div>
            </div>
            <p class="center">Los cambios aplicados a tu nombre se reflejarán en tu cuenta, por favor indique su nombre/s y apellidos completos.</p>
            <ul class="collection" style="margin-bottom: 0px">
                <li class="collection-item">
                    <div class="row input-form col s12">
                        <div class="input-field col m6 s12 ReNombres">
                            <input id="Nombre" type="text" name="Nombre" value="<?= $nombre ?>">
                            <label for="Nombre" >Nombre*</label>
                            <span class="helper-text" data-error="Nombre incorrecto" data-success="Nombre correcto"></span>
                        </div>
                        <div class="input-field col m6 s12 ReApellidos">
                            <input id="Apellido" type="text" name="Apellido" value="<?= $apellido ?>">
                            <label for="Apellido">Apellidos*</label>
                            <span class="helper-text" data-error="Apellidos incorrecto" data-success="Apellidos correcto"></span>
                        </div>
                    </div>
                </li>
            </ul>

        </article>
    </div>
    <div class="modal-footer actualizar">
        <a class="modelica-bold modal-close waves-effect btn-flat red-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">close</i> Cancelar</b></a>
        <a class="modelica-bold modal-close waves-effect btn-flat green-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">done</i> Actualizar</b></a>
    </div>
</div>

<!-- Pop-Up actualizar fecha -->
<div id="actualizar-fecha" class="modal bottom-sheet">
    <div class="modal-content">
        <article class="">
            <!-- <img src="img/actualizar.png" class="politicas center"> -->
            <div class="valign-wrapper blue-text text-darken-3">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4 style="margin: 0px 10px 0px 0px;"><i class="material-icons">cake</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold" style="margin: 0px">Fecha de nacimiento</h5>
                </div>
                <div class="col s1"></div>
            </div>
            <p class="center">Tu fecha de nacimiento se puede usar para reforzar la seguridad de la cuenta.</p>
            <ul class="collection" style="margin-bottom: 0px">
                <li class="collection-item">
                    <div class="row input-form">
                        <div class="input-field col s12">
                            <input id="Nacimiento" type="text" class="datepicker ReNacimiento" name="Nacimiento">
                            <label for="Nacimiento">Fecha de nacimiento*</label>
                            <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                        </div>
                    </div>
                </li>
            </ul>

        </article>
    </div>
    <div class="modal-footer actualizar">
        <a class="modelica-bold modal-close waves-effect btn-flat red-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">close</i> Cancelar</b></a>
        <a class="modelica-bold modal-close waves-effect btn-flat green-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">done</i> Actualizar</b></a>
    </div>
</div>

<!-- Pop-Up actualizar RH -->
<div id="actualizar-rh" class="modal bottom-sheet">
    <div class="modal-content">
        <article class="">
            <!-- <img src="img/actualizar.png" class="politicas center"> -->
            <div class="valign-wrapper blue-text text-darken-3">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4 style="margin: 0px 10px 0px 0px;"><i class="material-icons">favorite</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold" style="margin: 0px">Grupo Sanguíneo y RH</h5>
                </div>
                <div class="col s1"></div>
            </div>
            <!-- <p class="center">Tu fecha de nacimiento se puede usar para reforzar la seguridad de la cuenta.</p> -->
            <ul class="collection" style="margin-bottom: 0px">
                <li class="collection-item">
                    <div class="row input-form">
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH1" name="rh" type="radio" value="1" />
                                <span>A+</span>
                            </label>
                        </div>
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH2" name="rh" type="radio" value="2" />
                                <span>A-</span>
                            </label>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row input-form"> -->
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH3" name="rh" type="radio" value="3" />
                                <span>B+</span>
                            </label>
                        </div>
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH4" name="rh" type="radio" value="4" />
                                <span>B-</span>
                            </label>
                        </div>
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH5" name="rh" type="radio" value="5" />
                                <span>O+</span>
                            </label>
                        </div>
                        <div class="col l3 m4 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH6" name="rh" type="radio" value="6" />
                                <span>O-</span>
                            </label>
                        </div>
                        <div class="col l3 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH7" name="rh" type="radio" value="7" />
                                <span>AB+</span>
                            </label>
                        </div>
                        <div class="col l3 s6 center-align" style="margin: 1rem 0px">
                            <label>
                                <input id="RH8" name="rh" type="radio" value="8" />
                                <span>AB-</span>
                            </label>
                        </div>
                    </div>
                </li>
            </ul>

        </article>
    </div>
    <div class="modal-footer actualizar">
        <a class="modelica-bold modal-close waves-effect btn-flat red-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">close</i> Cancelar</b></a>
        <a class="modelica-bold modal-close waves-effect btn-flat green-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">done</i> Actualizar</b></a>
    </div>
</div>


<!-- Pop-Up actualizar foto -->
<div id="actualizar-foto" class="modal bottom-sheet">
    <div class="modal-content">
        <article class="">
            <!-- <img src="img/actualizar.png" class="politicas center"> -->
            <div class="valign-wrapper blue-text text-darken-3">
                <div class="col s1" style="margin: 0px; padding: 0px;"><h4 style="margin: 0px 10px 0px 0px;"><i class="material-icons">account_circle</i></h4></div>
                <div class="col s10">
                    <h5 class="modelica-bold" style="margin: 0px">Foto del perfil</h5>
                </div>
                <div class="col s1"></div>
            </div>
            <div class="valign-wrapper">
                <div class="col s12 alerta">
                    <p class="center"><b>Instrucciones:</b><br>Cargue al sistema una <b>imagen sin trasparencias</b>.<br>Utilice el editor para ajustar la posición y tamaño de la imagen.<br>Observe los resultados <b>en la vista previa</b>.</p>
                </div>
            </div>
            <ul class="collection" style="margin-bottom: 0px">
                <li class="collection-item">
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
                </li>
            </ul>

        </article>
    </div>
    <div class="modal-footer actualizar">
        <a class="modelica-bold modal-close waves-effect btn-flat red-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">close</i> Cancelar</b></a>
        <a class="modelica-bold modal-close waves-effect btn-flat green-text text-darken-1" onclick="scrollTopModal()"><b><i class="material-icons left">done</i> Actualizar</b></a>
    </div>
</div>