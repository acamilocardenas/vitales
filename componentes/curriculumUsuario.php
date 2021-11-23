<?php
    $consultaEva = $mysqli->query("SELECT * FROM VW_Datos_Usuario WHERE idUsuario = '$DocumentoEvaluado'");
    $usuarioEva = $consultaEva->fetch_assoc();

    $documentoEva = $usuarioEva['idUsuario'];
    $nombreEva = $usuarioEva['nombre'];
    $apellidoEva = $usuarioEva['apellido'];
    $NacimientoEva = $usuarioEva['fechaNacimiento'];
    $ConvertirNacEva = explode("-", $NacimientoEva);
    $DiaNacEva = $ConvertirNacEva[2];
    $MesNacEva = (string)$ConvertirNacEva[1];
    $MesNacFormEva = ConvertMes($MesNacEva);
    $AñoNacEva = $ConvertirNacEva[0];
    $FechaNacEva = ($DiaNacEva.' de '.$MesNacFormEva.' de '.$AñoNacEva);
    $FechaNacEvaJs = ($DiaNacEva.' '.$MesNacFormEva.', '.$AñoNacEva);
    $RHEva = $usuarioEva['RH'];
    $telefonoEva = $usuarioEva['telefono'];
    $estadoEva =  $usuarioEva['activo'];
    $fotoEva = $usuarioEva['foto'];
    $rolesEva = explode(",", $usuarioEva['roles']);
    $rolesNumEva = count($rolesEva);
    $conductorEva = (string)$rolesEva[0];
    if($rolesNumEva > 1) {
     $adminEva = (string)$rolesEva[1];
    }
    $puntosEva = $usuarioEva['puntos'];
    $proximoPuntoEva = $usuarioEva['proximoPunto'];
    $registroEva = $usuarioEva['registro'];
    $ConvertirRegEva = explode("-", $registroEva);
    $MesRegEva = (string)$ConvertirRegEva[1];
    $MesRegFormEva = ConvertMes($MesRegEva);
    $AñoRegEva = $ConvertirRegEva[0];
    $FechaRegEva = ($MesRegFormEva.' de '.$AñoRegEva);

    $licenciasEva = array();
    $fechaLicenciasEva = array();
    $LicenciaActualizacionEva = array();

    $consultaLicEva = $mysqli->query("SELECT CL.nombreCategoria AS categoria, LU.fechaExpedicion AS expedicion, LU.actualizacion AS actualizacion FROM Usuario AS U INNER JOIN Licencia_Usuario AS LU ON U.idUsuario = LU.idUsuario INNER JOIN Categoria_licencia AS CL ON LU.idCategoria = CL.idCategoria WHERE U.idUsuario = '$documentoEva' ") or die($mysqli->error());
    
    while ( $valor = mysqli_fetch_array( $consultaLicEva ) ) {
        array_push($licenciasEva, $valor['categoria']);
        array_push($fechaLicenciasEva, $valor['expedicion']);
        array_push($LicenciaActualizacionEva, $valor['actualizacion']);
    }
?>
<script type="text/javascript">
      let FechaNacEvaJs = "<?= $FechaNacEvaJs ?>";
</script>
<div class="row img-puntos" style="margin-bottom: 0px">
    <div class="col s12">
        <?php
            if(!isset($fotoEva)) {
                echo'<img class="usuario-historial" src="img/Perfil.png">';
                if($puntosEva >= 12 ) {
                    echo'<img class="puntos-historial" src="img/oro.png" title="Medalla Oro" alt="Medalla Oro">';
                } else if ($puntosEva <= 11 && $puntosEva >= 7) {
                    echo'<img class="puntos-historial" src="img/plata.png" title="Medalla Plata" alt="Medalla Plata">';
                } else {
                    echo'<img class="puntos-historial" src="img/bronce.png" title="Medalla Bronce" alt="Medalla Bronce">';
                }
            } else {
                echo'<img class="usuario-historial" src="'.$fotoEva.'">';
                if($puntosEva >= 12 ) {
                    echo'<img class="puntos-historial" src="img/oro.png" title="Medalla Oro" alt="Medalla Oro">';
                } else if ($puntosEva <= 11 && $puntosEva >= 7) {
                    echo'<img class="puntos-historial" src="img/plata.png" title="Medalla Plata" alt="Medalla Plata">';
                } else {
                    echo'<img class="puntos-historial" src="img/bronce.png" title="Medalla Bronce" alt="Medalla Bronce">';
                }
            }
        ?>
    </div>
</div>

<div class="row">
    <div class="col s12 center">
        <h6 class="modelica-bold" style="margin-top: 0px"><?=$nombreEva?> <?=$apellidoEva?></h6>
        <p class="roles">
            <?=$conductorEva?>
            <?php
                if(isset($adminEva)) {
                    echo ' y '.$adminEva.'';        
                };
            ?>
        </p>
        <p class="puntaje">
            <?php
                if($puntosEva >= 12 ) {
                    echo '<a class="valign-wrapper alto"><i class="material-icons">star</i>&nbsp;&nbsp;<b>'.$puntosEva.'&nbsp;&nbspPuntos</b></a>';
                } else if ($puntosEva <= 11 && $puntosEva >= 7) {
                    echo '<a class="valign-wrapper medio"><i class="material-icons">star_half</i>&nbsp;&nbsp;<b>'.$puntosEva.'&nbsp;&nbspPuntos</b></a>';
                }
                else {
                    echo '<a class="valign-wrapper bajo"><i class="material-icons">star_border</i>&nbsp;&nbsp;<b>'.$puntosEva.'&nbsp;&nbspPuntos</b></a>';
                }
            ?>
        </p>
    </div>
</div>

<?php
    if(isset($_SESSION['evaluacion'])) {
        echo $_SESSION['evaluacion'];
    }
    if(!isset($_GET['evaluacion'])) {
        unset( $_SESSION['evaluacion'] );// Eliminar mensajes de update
    }
    // consultar historial
    $historialEva = $mysqli->query("SELECT H.idNorma AS idNorma, N.descripcion AS norma, T.nombreTipo AS tipo, N.valor AS puntos, H.fechaInfraccion AS dateInfraccion, H.registro AS dateRegistro, H.idEvaluador AS idEvaluador, CONCAT(U.nombre, ' ', U.apellido) AS Evaluador FROM Historial AS H INNER JOIN Norma AS N ON H.idNorma = N.idNorma INNER JOIN Tipo_Norma AS T ON N.idTipo = T.idTipo INNER JOIN Usuario AS U ON H.idEvaluador = U.idUsuario WHERE H.idUsuario = '$documentoEva' ORDER BY H.registro DESC");
    if ( $historialEva->num_rows == 0 ) { 
        // El historial no existe
        echo '<div class="row" style="margin-bottom: 0px;">
                <div class="col s12 center sin-historial">
                    <img src="img/vacio.png">
                    <h6><b>El usuario no presenta compárenlos y/o infracciones.</b></h6>
                </div>
            </div>';
    } else { 
        // El historial si existe
        echo '<div class="row" style="margin-bottom: 0px;">
                <div class="col s12 center con-historial">';
         while ( $valoresEva = mysqli_fetch_array( $historialEva ) ) {
            $idNormaEva = $valoresEva['idNorma'];
            $idEvaluador = $valoresEva['idEvaluador'];
            $DInEva = $valoresEva['dateInfraccion'];
            $ConvertirDInEva = explode("-", $DInEva);
            $DiaDInEva = $ConvertirDInEva[2];
            $MesDInEva = (string)$ConvertirDInEva[1];
            $MesDInFormEva = ConvertMes($MesDInEva);
            $AñoDInEva = $ConvertirDInEva[0];
            $dateInfraccionEva = ($DiaDInEva.' de '.$MesDInFormEva.', '.$AñoDInEva);
            $DRegEva = $valoresEva['dateRegistro'];
            $ConvertirDRegEva = explode("-", $DRegEva);
            $DiaDRegEva = explode(" ", $ConvertirDRegEva[2]);
            $DiaDRegEva = $DiaDRegEva[0];
            $MesDRegEva = (string)$ConvertirDRegEva[1];
            $MesDRegFormEva = ConvertMes($MesDRegEva);
            $AñoDRegEva = $ConvertirDRegEva[0];
            $dateRegistroEva = ($DiaDRegEva.' de '.$MesDRegFormEva.', '.$AñoDRegEva);
            $evaluadorEva = $valoresEva['Evaluador'];

            $dlInfraccion = (string)($AñoDInEva.'-'.$MesDInEva.'-'.$DiaDInEva);
            $dlRegistro = (string)($AñoDRegEva.'-'.$MesDRegEva.'-'.$DiaDRegEva);

            if($valoresEva['tipo'] == 'Beneficio') {
                echo '<ul class="collection">
                        <li class="collection-item">
                            <span class="new badge green" data-badge-caption="punto">+ '.$valoresEva['puntos'].'</span>
                            <h6><b>'.$valoresEva['tipo'].' N° '.$idNormaEva.'</b></h6>
                            <p class="descripcion">'.$valoresEva['norma'].'</p>
                            <p class="date"><b>Fecha Registro: </b>'.$dateRegistroEva.'</p>
                        </li>
                    </ul>';
            }
            else {
                echo '<ul class="collection">
                        <li class="collection-item">
                            <span class="new badge red" data-badge-caption="puntos">- '.$valoresEva['puntos'].'</span>
                            <h6><b>'.$valoresEva['tipo'].' N° '.$idNormaEva.'</b></h6>
                            <p class="descripcion">'.$valoresEva['norma'].'</p>
                            <p class="date"><b>Evaluador: </b>'.$evaluadorEva.'<br><b>Fecha Infracción: </b>'.$dateInfraccionEva.'<br><b>Fecha Registro: </b>'.$dateRegistroEva.'</p>

                            <div class="valign-wrapper while-delete-sancion hide">
                                <div class="col s12 error" style="margin-right: 10px;">
                                    <p class="center">
                                        <div class="progress red lighten-3">
                                           <div class="indeterminate red darken-1"></div>
                                        </div>
                                    </p>
                                    <p class="center"><b>Eliminando Sanción!</b><br>Espere un momento...</p>
                                </div>
                            </div>

                            <div class="valign-wrapper delete delete-sancion hide">
                                <div class="row" style="margin-bottom: 0px; width: 100%">   
                                    <div class="col m8 s12">
                                        <p class="center" style="margin: 0px;">¿Está seguro de eliminar esta sanción del perfil de <b>'.$nombreEva.' '.$apellidoEva.'</b>?</p>
                                    </div>
                                    <div class="col m4 s12">
                                        <div class="eliminar-btns"  style="margin-bottom: 0px;">   
                                            <a class="cancel-delete-btn waves-effect btn-floating red darken-1"><i class="material-icons">close</i></a>
                                            <a class="confir-delete-btn waves-effect btn-floating green darken-1" onclick="eliminarSancion( this, '.$documentoEva.', '.$idNormaEva.', &#39;'.$dlInfraccion.'&#39;, &#39;'.$dlRegistro.'&#39;, '.$idEvaluador.')"><i class="material-icons">done</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="date"><a class="waves-effect btn-floating hoverable grey delete-sancion-btn"><i class="material-icons">delete</i></a></p>
                        </li>
                    </ul>';
            }
        }
        echo '</div>
            </div>';
    }
?>
<div class="row">
    <div class="col s12 left titulo">
        <h5 class="modelica-black"><img src="img/titulo.png">&nbsp;Añadir sanciones</h5>
    </div>
</div>
<div class="row" style="margin-bottom: 0px;">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s6"><a class="active" href="#test1" onclick="$('.con-historial').scrollTop(0)"><b>Políticas</b></a></li>
        <li class="tab col s6"><a  href="#test2" onclick="$('.con-historial').scrollTop(0)"><b>Compartendos</b></a></li>
      </ul>
    </div>
    <?php
    $politicas = "";
    $Comparendos = "";
        $Normas = $mysqli->query("SELECT N.idNorma AS id, N.idTipo AS idTipo, TN.nombreTipo AS tipo, N.descripcion AS descripcion, N.valor AS valor FROM Norma AS N INNER JOIN Tipo_Norma AS TN ON N.idTipo = TN.idTipo ORDER BY N.idNorma ASC");
        if ( $Normas->num_rows > 0 ) { 
            while ( $valorNorma = mysqli_fetch_array( $Normas ) ) {
                if ($valorNorma['idTipo'] == '1') {
               $politicas.='<ul class="collection">
                                <li class="collection-item">
                                    <span class="new badge red" data-badge-caption="punto">- '.$valorNorma['valor'].'</span>
                                    <h6><b>'.$valorNorma['tipo'].'</b></h6>
                                    <p style="margin: 0px;"><b>Norma id: </b>'.$valorNorma['id'].'</p>
                                    <p class="descripcion">'.$valorNorma['descripcion'].'</p>
                                    <p class="date"><a class="waves-effect btn-floating hoverable grey add-sancion-btn"><i class="material-icons">add</i></a></p>
                                </li>

                                <li class="collection-item add-sancion">
                                    <div class="valign-wrapper while-add-sancion hide">
                                        <div class="col s12 informacion" style="margin-right: 10px;">
                                            <p class="center">
                                                <div class="progress light-blue lighten-3">
                                                   <div class="indeterminate light-blue darken-1"></div>
                                                </div>
                                            </p>
                                            <p class="center"><b>¡Añadiendo Sanción!</b><br>Espere un momento...</p>
                                        </div>
                                    </div>
                           
                                    <div class="row form-add-sancion" style="margin-bottom: 0px">
                                        <p style="padding: 0px 10px; margin-top: 0px"><b>Fecha de la infracción:</b> Por favor, indique la fecha en la que el usuario <b>'.$nombreEva.' '.$apellidoEva.'</b> infringió la norma.</p>
                                        <div class="input-form col s12">
                                            <div class="input-field col m6 s12 HInfractor hide">
                                                <input id="Infractor'.$valorNorma['id'].'" type="text" name="Infractor" value="'.$documentoEva.'">
                                                <label for="Infractor'.$valorNorma['id'].'" class="active">Infractor*</label>
                                            </div>
                                            <div class="input-field col m6 s12 HNorma hide">
                                                <input id="Norma'.$valorNorma['id'].'" type="text" name="Norma" value="'.$valorNorma['id'].'">
                                                <label for="Norma'.$valorNorma['id'].'" class="active">Norma*</label>
                                            </div>
                                            <div class="input-field col s12 HEvaluador hide">
                                                <input id="Evaluador'.$valorNorma['id'].'" type="text" name="Evaluador" value="'.$documento.'">
                                                <label for="Evaluador'.$valorNorma['id'].'" class="active">Evaluador*</label>
                                            </div>
                                            <div class="input-field col s12 HInfraccion">
                                                <input id="Infraccion'.$valorNorma['id'].'" type="text" class="datepicker">
                                                <label for="Infraccion'.$valorNorma['id'].'">Fecha infracción*</label>
                                                <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                                            </div>
                                        </div>
                                        <div class="actualizar col s12">
                                            <a class="close-add-sancion-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                            <a class="confir-add-sancion-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>';
                } else if ($valorNorma['idTipo'] == '2') {
            $Comparendos.='<ul class="collection">
                                <li class="collection-item">
                                    <span class="new badge red" data-badge-caption="punto">- '.$valorNorma['valor'].'</span>
                                    <h6><b>'.$valorNorma['tipo'].'</b></h6>
                                    <p style="margin: 0px;"><b>Norma id: </b>'.$valorNorma['id'].'</p>
                                    <p class="descripcion">'.$valorNorma['descripcion'].'</p>
                                    <p class="date"><a class="waves-effect btn-floating hoverable grey add-sancion-btn"><i class="material-icons">add</i></a></p>
                                </li>

                                <li class="collection-item add-sancion">
                                    <div class="valign-wrapper while-add-sancion hide">
                                        <div class="col s12 informacion" style="margin-right: 10px;">
                                            <p class="center">
                                                <div class="progress light-blue lighten-3">
                                                   <div class="indeterminate light-blue darken-1"></div>
                                                </div>
                                            </p>
                                            <p class="center"><b>¡Añadiendo Sanción!</b><br>Espere un momento...</p>
                                        </div>
                                    </div>
                           
                                    <div class="row form-add-sancion" style="margin-bottom: 0px">
                                        <p style="padding: 0px 10px; margin-top: 0px"><b>Fecha de la infracción:</b> Por favor, indique la fecha en la que el usuario <b>'.$nombreEva.' '.$apellidoEva.'</b> infringió la norma.</p>
                                        <div class="input-form col s12">
                                            <div class="input-field col m6 s12 HInfractor hide">
                                                <input id="Infractor'.$valorNorma['id'].'" type="text" name="Infractor" value="'.$documentoEva.'">
                                                <label for="Infractor'.$valorNorma['id'].'" class="active">Infractor*</label>
                                            </div>
                                            <div class="input-field col m6 s12 HNorma hide">
                                                <input id="Norma'.$valorNorma['id'].'" type="text" name="Norma" value="'.$valorNorma['id'].'">
                                                <label for="Norma'.$valorNorma['id'].'" class="active">Norma*</label>
                                            </div>
                                            <div class="input-field col s12 HEvaluador hide">
                                                <input id="Evaluador'.$valorNorma['id'].'" type="text" name="Evaluador" value="'.$documento.'">
                                                <label for="Evaluador'.$valorNorma['id'].'" class="active">Evaluador*</label>
                                            </div>
                                            <div class="input-field col s12 HInfraccion">
                                                <input id="Infraccion'.$valorNorma['id'].'" type="text" class="datepicker">
                                                <label for="Infraccion'.$valorNorma['id'].'">Fecha infracción*</label>
                                                <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                                            </div>
                                        </div>
                                        <div class="actualizar col s12">
                                            <a class="close-add-sancion-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                            <a class="confir-add-sancion-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>';
                    
                }
            }
        }
    ?>
    <div id="test1" class="col s12">
        <div class="col s12 con-historial" style="background: rgba(17, 102, 204, .08); padding-bottom: 0.75rem; height:500px; overflow-y: auto;">
            <?= $politicas ?>
        </div>
            
    </div>
    <div id="test2" class="col s12">
        <div class="col s12 con-historial" style="background: rgba(17, 102, 204, .08); padding-bottom: 0.75rem; height:500px; overflow-y: auto;">
            <?= $Comparendos ?>
        </div>  
    </div>
</div>