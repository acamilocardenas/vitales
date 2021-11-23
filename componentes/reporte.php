<section style="position: absolute; top: 0px; left: 0px; width: 100vw; height: 100vh; overflow-y: hidden; z-index: -99999" class="seccion-pdf hide">
   <div class="container">
     <div class="row" style="margin-bottom: 0px">
         <div class="col s12 " id="element-to-print" style="padding-bottom: 0px">
            <blockquote  class="hoverable z-depth-1 contenido grey lighten-5" style="margin: 0px">
               <div class="row">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black" style="margin: 0px"><img src="img/titulo.png">&nbsp;Programa vitales Reporte</h4>
                  </div>
               </div>
               
               <div class="row img-puntos" style="margin-bottom: 0px">
                  <div class="col s12">
                     <?php
                        if(!isset($foto)) {
                           echo'<img class="usuario-historial" src="img/Perfil.png">';
                           if($puntos >= 12 ) {
                              echo'<img class="puntos-historial" src="img/oro.png" title="Medalla Oro" alt="Medalla Oro">';
                           }
                           else if ($puntos <= 11 && $puntos >= 7) {
                              echo'<img class="puntos-historial" src="img/plata.png" title="Medalla Plata" alt="Medalla Plata">';
                           }
                           else {
                              echo'<img class="puntos-historial" src="img/bronce.png" title="Medalla Bronce" alt="Medalla Bronce">';
                           }
                        } else {
                           echo'<img class="usuario-historial" src="'.$foto.'">';
                           if($puntos >= 12 ) {
                              echo'<img class="puntos-historial" src="img/oro.png" title="Medalla Oro" alt="Medalla Oro">';
                           }
                           else if ($puntos <= 11 && $puntos >= 7) {
                              echo'<img class="puntos-historial" src="img/plata.png" title="Medalla Plata" alt="Medalla Plata">';
                           }
                           else {
                              echo'<img class="puntos-historial" src="img/bronce.png" title="Medalla Bronce" alt="Medalla Bronce">';
                           }
                        }
                     ?>
                  </div>
               </div>
               <div class="row" style="margin-bottom: 0px">
                  <div class="col s12 center">
                     <p class="modelica-bold" style="color: #003587; margin: 0px">No ID:  <?=$documento?></p>
                     <h6 class="modelica-bold" style="margin: 0px"><?=$nombre?> <?=$apellido?></h6>                     
                  </div>
                  <div class="col s12 center">
                     <p class="modelica-bold" style="margin: 0px">
                     <?php
                       if($puntos >= 12 ) {
                           echo 'Conductor Oro';
                       }
                       else if ($puntos <= 11 && $puntos >= 7) {
                           echo 'Conductor Plata';
                       }
                       else {
                        echo 'Conductor Bronce';
                       }
                     ?>
                     </p>       
                     <p class="puntaje modelica-bold">
                        <?php
                          if($puntos >= 12 ) {
                              echo '<a class="valign-wrapper alto"><i class="material-icons">star</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                          else if ($puntos <= 11 && $puntos >= 7) {
                              echo '<a class="valign-wrapper medio"><i class="material-icons">star_half</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                          else {
                              echo '<a class="valign-wrapper bajo"><i class="material-icons">star_border</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                        ?>
                     </p>
                  </div>
               </div>


               <div class="row" style="margin-bottom: 0px;">
                  <div class="col s12">
                     <div class="" style="text-align: justify;">
                     <?php
                        if($puntos >= 12 ) {
                           echo '<div class="col s12 mensaje"><p><b>Soy conductor oro</b><br>Oro es la mayor categoría que existe.<br>Inicias con doce puntos que debes mantener o aumentar con tu buen comportamiento en la vía.<br><b>!Excelente campeón!</b></p></div>';
                        }
                        else if ($puntos <= 11 && $puntos >= 7) {
                           echo '<div class="col s12 informacion"><p><b>Soy conductor plata</b><br>Eres conductor plata cuando tienes de 7 a 11 puntos, porque has cometido alguna infracción en la vía o incumplido alguna de las políticas establecidas de nuestra compañía.<br><b>¡Vamos por el oro!</b></p></div>';
                        }
                        else {
                           echo '<div class="col s12 alerta"><p><b>Soy conductor bronce</b><br>Eres conductor bronce cuando tienes menos de 7 puntos. Es la categoría más baja, es asignada por cometer una falta grave o varias infracciones en la vía y no cumplir con las políticas establecidas por nuestra compañía.<br><b>¡Ánimo, cambiemos el chip!</b></p></div>';
                        }
                     ?>
                     </div>
                  </div>
               </div>

               <div class="row" style="margin-bottom: 0px;">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;Información del usuario</h4>
                  </div>
               </div>

               <div class="row" style="margin-bottom: 0px;">
                  <div class="col s12">
                     <div class="col s12 informacion" style="padding-bottom: 0.75rem">
                        <div class="col s12 valign-wrapper">
                           <h6><i class="material-icons">how_to_reg</i></h6>
                           <h6 class="modelica-bold">&nbsp;&nbsp;DATOS PERSONALES</h6>
                        </div>

                        <div class="col s12" style="padding: 5px; background-color: rgba(76.5, 80.8, 95.3, .05); border-radius: 8px;">
                              <div class="col s6">
                                 <b>Fecha de nacimiento:</b> <?=$FechaNac?>
                              </div>
                              <div class="col s6">
                                 <b>Documento:</b> C.C <?=$documento?>
                              </div>
                              <div class="col s6">
                                 <b>Grupo sanguíneo y RH:</b> <?=$RH?>
                              </div>
                              <div class="col s6">
                                 <b>Teléfono</b> <?=$telefono?>
                              </div>
                        </div>

                        <div class="col s12 valign-wrapper">
                           <h6><i class="material-icons">local_shipping</i></h6>
                           <h6 class="modelica-bold">&nbsp;&nbsp;DATOS DE LA LICENCIA</h6>
                        </div>

                        <?php
                           if (is_array($licencias) || is_object($licencias)) {
                              foreach (($licencias) as $clave => $licencia) {
                                 $Expedicion = explode("-", $fechaLicencias[$clave]);
                                 $DiaExp = $Expedicion[2];
                                 $MesExp = (string)$Expedicion[1];
                                 $MesExpForm = ConvertMes($MesExp);
                                 $AñoExp = $Expedicion[0];
                                 $FechaExp = ($DiaExp.' '.$MesExpForm.', '.$AñoExp);
                                 if(count($licencias) == 1) {
                                    echo '<div class="col s12">
                                             <div style="margin: 5px; padding: 5px; background-color: rgba(76.5, 80.8, 95.3, .05); border-radius: 8px;">
                                                <b>Licencia: </b> '.$licencia.'<br>
                                                <b>Fecha expedición: </b> '.$FechaExp.'
                                             </div>
                                          </div>';
                                 } else if($clave == 2) {
                                    echo '<div class="col s6 offset-s3">
                                             <div style="margin: 5px; padding: 5px; background-color: rgba(76.5, 80.8, 95.3, .05); border-radius: 8px;">
                                                <b>Licencia: </b> '.$licencia.'<br>
                                                <b>Fecha expedición: </b> '.$FechaExp.'
                                             </div>
                                          </div>';
                                 } else {
                                    echo '<div class="col s6">
                                             <div style="margin: 5px; padding: 5px; background-color: rgba(76.5, 80.8, 95.3, .05); border-radius: 8px;">
                                                <b>Licencia: </b> '.$licencia.'<br>
                                                <b>Fecha expedición: </b> '.$FechaExp.'
                                             </div>
                                          </div>';
                                 }
                                   
                              }
                           }
                        ?>
                        <div class="col s12" style="margin-top: 0.75rem">
                           <a class="valign-wrapper" style="color: #31708f;"><i class="material-icons">event</i><b>&nbsp;&nbsp;Se unió en&nbsp;<?= $FechaReg?></b></a>
                        </div>
                     </div>
                  </div>
               </div>
            </blockquote>
            <footer class=" col s12 page-footer blue darken-4">
               <div class="container">
               </div>
               <div class="footer-copyright">
                  <div class="container" style="line-height: 30px">
                     © 2020 NORGAS S.A
                     <img class="copyright-img right" src="img/marcasBlaco.png" style="position: absolute; left: 50%;transform: translateX(-50%);">
                     <img class="copyright-img right" src="img/vitale.png">
                  </div>
               </div>
            </footer>

            <blockquote class="newpage hoverable z-depth-1 contenido grey lighten-5" style="margin: 0px">
               <div class="row " style="margin-bottom: 0px;">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;Historial</h4>
                  </div>
               </div>

               <?php

                  // consultar historial
                  $historial = $mysqli->query("SELECT N.descripcion AS norma, T.nombreTipo AS tipo, N.valor AS puntos, H.fechaInfraccion AS dateInfraccion, H.registro AS dateRegistro FROM Historial AS H INNER JOIN Norma AS N ON H.idNorma = N.idNorma INNER JOIN Tipo_Norma AS T ON N.idTipo = T.idTipo WHERE H.idUsuario = '$idUsuario' ORDER BY H.registro DESC");
                  if ( $historial->num_rows == 0 )
                  { 
                     // El historial no existe
                     echo '<div class="row">
                              <div class="col s12 center sin-historial">
                                 <img src="img/vacio.png" style="margin-top: 0px;">
                                 <h6><b>No hay actividad.</b></h6>
                                 <p>Puntos anuales, políticas infringidas, compárenlos y/o infracciones aparecerán aquí.</p>
                              </div>
                           </div>';
                  }
                  else
                  { 
                     // El historial si existe
                     echo '<div class="row">
                              <div class="col s12 center con-historial">
                                 <p>Puntos anuales, políticas infringidas, compárenlos y/o infracciones aparecerán aquí.</p>';
                     while ( $valores = mysqli_fetch_array( $historial ) ) {
                        $DIn = $valores['dateInfraccion'];
                        $ConvertirDIn = explode("-", $DIn);
                        $DiaDIn = $ConvertirDIn[2];
                        $MesDIn = (string)$ConvertirDIn[1];
                        $MesDInForm = ConvertMes($MesDIn);
                        $AñoDIn = $ConvertirDIn[0];
                        $dateInfraccion = ($DiaDIn.' de '.$MesDInForm.', '.$AñoDIn);

                        $DReg = $valores['dateRegistro'];
                        $ConvertirDReg = explode("-", $DReg);
                        $DiaDReg = explode(" ", $ConvertirDReg[2]);
                        $DiaDReg = $DiaDReg[0];
                        $MesDReg = (string)$ConvertirDReg[1];
                        $MesDRegForm = ConvertMes($MesDReg);
                        $AñoDReg = $ConvertirDReg[0];
                        $dateRegistro = ($DiaDReg.' de '.$MesDRegForm.', '.$AñoDReg);


                        if($valores['tipo'] == 'Beneficio') {
                           echo '
                                 <ul class="collection">
                                    <li class="collection-item">
                                       <span class="new badge green" data-badge-caption="punto">+ '.$valores['puntos'].'</span>
                                       <h6><b>'.$valores['tipo'].'</b></h6>
                                       <p class="descripcion">'.$valores['norma'].'</p>
                                       <p class="date"><b>Fecha Registro: </b>'.$dateRegistro.'</p>
                                    </li>
                                 </ul>';
                        }
                        else {
                           echo '<ul class="collection">
                                    <li class="collection-item">
                                       <span class="new badge red" data-badge-caption="puntos">- '.$valores['puntos'].'</span>
                                       <h6><b>'.$valores['tipo'].'</b></h6>
                                       <p class="descripcion">'.$valores['norma'].'</p>
                                       <p class="date"><b>Fecha Infracción: </b>'.$dateInfraccion.'<br><b>Fecha Registro: </b>'.$dateRegistro.'</p>
                                    </li>
                                 </ul>';
                        }
                     }
                     echo '</div>
                        </div>';
                  }
                  $fechaReporte = date("Y-m-d");
                  $ConvertirFR = explode("-", $fechaReporte);
                  $DiaFR = $ConvertirFR[2];
                  $MesFR = (string)$ConvertirFR[1];
                  $MesFRForm = ConvertMes($MesFR);
                  $AñoFR = $ConvertirFR[0];
                  $dateReporte = ($DiaFR.' de '.$MesFRForm.', '.$AñoFR);
                  echo '<p class="right-align grey-text"><b>Reporte Generado </b>'.$dateReporte.'</p>';
               ?>

            </blockquote>
            <footer class=" col s12 page-footer blue darken-4">
               <div class="container">
               </div>
               <div class="footer-copyright">
                  <div class="container" style="line-height: 30px">
                     © 2020 NORGAS S.A
                     <img class="copyright-img right" src="img/marcasBlaco.png" style="position: absolute; left: 50%;transform: translateX(-50%);">
                     <img class="copyright-img right" src="img/vitale.png" >
                  </div>
               </div>
            </footer>
         </div>
      </div>
   </div>
</section>