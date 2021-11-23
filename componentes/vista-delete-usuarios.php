<?php
   #Buscar usuarios realtime
   ob_start();
   require '../db.php';
   session_start();
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: text/html; charset=UTF-8');
   define('USUARIOS_POR_PAGINA', 20);
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
      $consultaNumUsuarios = "SELECT COUNT(*) AS NumUsuarios FROM VW_Usuarios_Admin  WHERE idUsuario LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR apellido LIKE '%".$q."%'";
   } else {
      // consultar usuarios
      $consultaNumUsuarios = "SELECT COUNT(*) AS NumUsuarios FROM VW_Usuarios_Admin";
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
         // header("location: admin-usuarios.php?page=$total_pages"); si no fuera ajax
         $salida.= '<script type="text/javascript">$(location).attr("href","admin-usuarios.php?input='.$q.'&page='.$total_pages.'");</script>';
      }
   } else {
      $start = 0;
   }


   //recibo datos del filtro desde ajax 
   if(isset($_POST['consulta'])) {
      // Escapar variables de $_POST para protegerse de las inyecciones SQL
      $q = $mysqli->real_escape_string($_POST['consulta']);
      // consultar usuarios con filtro
      $consulta = "SELECT * FROM VW_Usuarios_Admin WHERE idUsuario LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR apellido LIKE '%".$q."%' LIMIT ".$start.", ".USUARIOS_POR_PAGINA."";
   } else {
      // consultar usuarios
      $consulta = "SELECT * FROM VW_Usuarios_Admin LIMIT ".$start.", ".USUARIOS_POR_PAGINA."";
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
                              <th>Puntos</th>
                              <th>Último Acceso</th>
                              <th></th>
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
                                 <td class="td-usuario">'.$valores['idUsuario'].'<br><span>'.$valores['nombre'].' '.$valores['apellido'].'</span><div class="roles"><b>Roll: </b>'.$valores['roles'].'</div>';
                                    if($valores['estado'] == '1') {
                                             $salida.='<div class="estado-acti">Activo</div>';
                                    } else {
                                       $salida.='<div class="estado-inacti">Inactivo</div>';
                                    } $salida.= '
                                 </td>
                                 <td>';
                                       if($valores['puntos'] >= 12 ) {
                                          $salida.= '<div class="valign-wrapper"><i class="material-icons">star</i>&nbsp;&nbsp;'.$valores['puntos'].'</div><span><b>Infracciones:</b> '.$valores['Infracciones'].'</span>';
                                      } else if ($valores['puntos'] <= 11 && $valores['puntos'] >= 7) {
                                          $salida.= '<div class="valign-wrapper"><i class="material-icons">star_half</i>&nbsp;&nbsp;'.$valores['puntos'].'</div><span><b>Infracciones:</b> '.$valores['Infracciones'].'</span>';
                                      } else {
                                          $salida.= '<div class="valign-wrapper"><i class="material-icons">star_border</i>&nbsp;&nbsp;'.$valores['puntos'].'</div><span><b>Infracciones:</b> '.$valores['Infracciones'].'</span>';
                                      } $salida.= '
                                 </td>
                                 <td>'.substr($valores['ultimoLog'], 0, 10).'<br><span>Hora: '.substr($valores['ultimoLog'], 11, 5).'</span></td>';
                                 if($documento == $valores['idUsuario']) {
                                    $salida.= '<td style="padding: 10px 15px"><div class="valign-wrapper toasts-admin"><a class="waves-effect admin" style="line-height: 0;"><i class="material-icons grey-text">unpublished</i></a></div></td>';
                                 } else {
                                    $salida.= '<td style="padding: 10px 15px"><div class="valign-wrapper"><a onclick="ConfirmarCambiarEstado(&#39;'.$valores['nombre'].'&#39;, &#39;'.$valores['apellido'].'&#39;, &#39;'.$valores['idUsuario'].'&#39;, &#39;'.$valores['hash'].'&#39;, &#39;'.$valores['estado'].'&#39;)" class="waves-effect" style="line-height: 0;"><i class="material-icons deep-purple-text text-darken-3" alt="Cambiar estado">flaky</i></a></div></td>';
                                 }
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
                                 $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.($page - 1 ).'" style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a><i class="material-icons" style="padding: 0px;">chevron_left</i></a></li>';
                              }

                              for ($i=1;$i<=$total_pages;$i++) {
                                 if ($page == $i) {
                                    $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                 } else {
                                    $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                 }
                              }

                              if ($page != $total_pages) {
                                 $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.($page + 1).'" style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect" style="padding: 0px;"><a><i class="material-icons">chevron_right</i></a></li>';
                              }
                           } else {
                              if ($page != 1) {
                                 $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.($page - 1).'" style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a style="padding: 0px;"><i class="material-icons">chevron_left</i></a></li>';
                              }

                              for ($i=1;$i<=$total_pages;$i++) {
                                 if ($i <= 5 AND $page < 5){
                                    if ($page == $i) {
                                       $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                    } else {
                                       $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                    }
                                 } else if ($page >= 5) {
                                    if ($i < $page AND $i > ($page - 4)) {
                                       $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.$i.'">'.$i.'</a></li>';
                                    }else if ($page == $i) {
                                       $salida.= '<li class="active"><a>'.$i.'</a></li>';
                                    } else if ($i == $page + 1) {
                                       $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.($page + 1).'">'.($page + 1).'</a></li>';
                                    }
                                 }
                              }

                              if ($page != $total_pages) {
                                 $salida.= '<li class="waves-effect"><a href="admin-usuarios.php?input='.$q.'&page='.($page + 1).'" style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              } else {
                                 $salida.= '<li class="disabled waves-effect"><a style="padding: 0px;"><i class="material-icons">chevron_right</i></a></li>';
                              }
                           

                           }
                        }$salida.= '
                     </ul>
                  </div>
               </div>
               <script type="text/javascript">Init ();</script>';//iniciar funcion para scrool vertical
   } else {
      // No existen usuarios
         $salida.= '<div class="row">
                     <div class="col s12 center sin-historial">
                        <img src="img/vacio.png">
                        <h6><b>Tu búsqueda no produjo ningún resultado</b></h6>
                        <p>Intenta nuevamente.</p>
                     </div>
                  </div>';
   }
   echo $salida;
   $mysqli->close();
?>

      
         
   