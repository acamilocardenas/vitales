<?php
   #Buscar usuarios realtime
   ob_start();
   require '../db.php';
   session_start();
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: text/html; charset=UTF-8');
   define('USUARIOS_POR_PAGINA', 5);
   $salida = "";
   $documento;
   $page;
   $q="";

 //recibo datos del filtro desde ajax 
   if(isset($_POST['documento'])) {
      // Escapar variables de $_POST para protegerse de las inyecciones SQL
      $documento = $mysqli->real_escape_string($_POST['documento']);
   }


   //recibo datos del filtro desde ajax 
   if(isset($_POST['consulta'])) {
      // Escapar variables de $_POST para protegerse de las inyecciones SQL
      $q = $mysqli->real_escape_string($_POST['consulta']);
      // consultar usuarios con filtro
      $consultaNumUsuarios = "SELECT COUNT(*) AS NumUsuarios FROM VW_Licencias_Expiradas WHERE idUsuario LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR apellido LIKE '%".$q."%'";
   } else {
      // consultar usuarios
      $consultaNumUsuarios = "SELECT COUNT(*) AS NumUsuarios FROM VW_Licencias_Expiradas";
   }

   #paginacion
   $NumeroUsuarios = $mysqli->query($consultaNumUsuarios);
   $row = $NumeroUsuarios->fetch_assoc();
   $numTotalUsuarios = $row['NumUsuarios'];

   if ($numTotalUsuarios > 0) {
      $page = false;
       //examino la pagina a mostrar y el inicio del registro a mostrar
      /* funcion si no fuera ajax
      if (isset($_GET["page"])) {
         $page = $_GET["page"];
      }*/
      if(isset($_POST['pagina'])) {
         // Escapar variables de $_POST para protegerse de las inyecciones SQL
         $page = $mysqli->real_escape_string($_POST['pagina']);
      }
      if (!$page) {
         $start = 0;
         $page = 1;
      } else {
         $start = ($page - 1) * USUARIOS_POR_PAGINA;
      }
       //calculo el total de paginas
      $total_pages = ceil($numTotalUsuarios / USUARIOS_POR_PAGINA);
      if ($page > $total_pages) {
         // header("location: usuarios.php?page=$total_pages"); si no fuera ajax
         $salida.= '<script type="text/javascript">$(location).attr("href","usuarios.php?input='.$q.'&page='.$total_pages.'");</script>';
      }
   } else {
      $start = 0;
   }


   //recibo datos del filtro desde ajax 
   if(isset($_POST['consulta'])) {
      // Escapar variables de $_POST para protegerse de las inyecciones SQL
      $q = $mysqli->real_escape_string($_POST['consulta']);
      // consultar usuarios con filtro
      $consulta = "SELECT * FROM VW_Licencias_Expiradas WHERE idUsuario LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR apellido LIKE '%".$q."%' GROUP BY (idUsuario) ORDER BY expiracion DESC LIMIT ".$start.", ".USUARIOS_POR_PAGINA."";
   } else {
      // consultar usuarios
      $consulta = "SELECT * FROM VW_Licencias_Expiradas GROUP BY (idUsuario) ORDER BY expiracion DESC LIMIT ".$start.", ".USUARIOS_POR_PAGINA."";
   }

   $usuarios = $mysqli->query($consulta);

   if($usuarios->num_rows > 0) {
      // Si existen usuarios
      $salida.= '<div class="row">
                  <div class="col s12 left con-historial">
                     <p style="margin-bottom: 0px"><b>Total usuarios: </b>'.$numTotalUsuarios.'</p>';
                     if($total_pages > 1){
                        $salida.= '<p style="margin: 0px"><b>Pagina: </b> '.$page.' de ' .$total_pages.' paginas.</p>';
                     }           
       $salida.= '</div>

                  <div  class="col s12 center resultados">
                     <div class="table-overflow" id="scroll-area">
                        <table class="centered highlight">
                           <thead>
                              <tr>
                                <th colspan="2">Usuario</th>
                                <th>Licencia</th>
                              </tr>
                           </thead>
                           <tbody>';
               while ( $valores = mysqli_fetch_array( $usuarios ) ) {
                   $salida.= '<tr>
                                 <td>
                                    <a class="td-perfil waves-effect">';
                                       if(!isset($valores['fotoPerfil'])) {
                                          $salida.='<img class="circle" src="img/Perfil.png">';
                                       } else {
                                          $salida.='<img class="circle" src="'.$valores['fotoPerfil'].'">';
                                       } $salida.= '
                                    </a>
                                 </td>
                                 <td class="td-usuario">'.$valores['nombre'].' '.$valores['apellido'].'<br><span><b>Documento: </b>'.$valores['idUsuario'].'</span><div class="roles"><b>Teléfono: </b>'.$valores['telefono'].'</div>';
                                    if($valores['activo'] == '1') {
                                             $salida.='<div class="estado-acti">Activo</div>';
                                    } else {
                                       $salida.='<div class="estado-inacti">Inactivo</div>';
                                    } $salida.= '
                                 </td>
                                 <td class="td-usuario"><b>Categoría: </b>'.$valores['categoria'].'<br><span><b>Fecha expedición: </b>'.$valores['expedicion'].'</span>';
                                    if($valores['estado'] == '0') {
                                        $salida.='<div class="fecha-warning"><b>Pronto a expirar: </b>'.$valores['expiracion'].'</div>';
                                    } else {
                                        $salida.='<div class="fecha-inacti"><b>Expiro : </b>'.$valores['expiracion'].'</div>';
                                    } $salida.= '
                                 </td>';
                   $salida.= '</tr>';
               }
                $salida.= '</tbody>
                        </table>
                     </div>
                  </div>

                  <div class="col s12 center">
                     <ul class="pagination">';
                        if ($total_pages > 1) {
                           if($total_pages < 5) {
                              if ($page != 1) {
                                 $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.($page - 1 ).'" style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a><i class="material-icons" style="padding: 0px;">chevron_left</i></a></li>';
                              }

                              for ($i=1;$i<=$total_pages;$i++) {
                                 if ($page == $i) {
                                    $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                 } else {
                                    $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                 }
                              }

                              if ($page != $total_pages) {
                                 $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.($page + 1).'" style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect" style="padding: 0px;"><a><i class="material-icons">chevron_right</i></a></li>';
                              }
                           } else {
                              if ($page != 1) {
                                 $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.($page - 1).'" style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              }

                              for ($i=1;$i<=$total_pages;$i++) {
                                 if ($i <= 5 AND $page < 5){
                                    if ($page == $i) {
                                       $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                    } else {
                                       $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                    }
                                 } else if ($page >= 5) {
                                    if ($i < $page AND $i > ($page - 4)) {
                                       $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                    }else if ($page == $i) {
                                       $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                    } else if ($i == $page + 1) {
                                       $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.($page + 1).'">'.($page + 1).'</a></li>';
                                    }
                                 }
                              }

                              if ($page != $total_pages) {
                                 $salida.= '<li class="waves-effect"><a href="licencias.php?input='.$q.'&page='.($page + 1).'" style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              }
                           }
                        }
          $salida.= '</ul>
                  </div>
               </div>
               <script type="text/javascript">Init ();</script>';//iniciar funcion para scrool vertical
   } else {
      // No existen usuarios
         $salida.= '<div class="row">
                     <div class="col s12 center sin-historial">
                        <img src="img/vacio.png">
                        <h6><b>No se encontraron usuarios con licencias expiradas o prontas a expirar.</b></h6>
                     </div>
                  </div>';
   }
   echo $salida;
   $mysqli->close();

?>