<?php
   /* Muestra información del usuario y algunos mensajes útiles */
   ob_start();
   require 'db.php';
   session_start();
   unset( $_SESSION['message'] );//eliminamos posibles mesages de error
   // Comprobamos si el usuario ha iniciado sesión utilizando la variable de sesión
   if ($_SESSION['Usuario_on'] != 1 || !isset($_SESSION['Usuario_on']))
   {
      $_SESSION['message'] = '<div class="row">
                                 <div class="col s12 center-align">
                                    <div class="valign-wrapper">
                                       <div class="col s12 alertaError">
                                          <p class="center"><b>¡Debes iniciar sesión para ingresar a tu perfil!</b></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col s12 center-align">
                                    <a href="acceder.php">
                                       <button class="waves-effect waves-light btn-large hoverable blue darken-3">
                                          <i class="material-icons right">vpn_key</i><b>Inicia sesión</b>
                                       </button>
                                    </a>
                                 </div>
                              </div>';
      header("location: error.php");   
   }
   else 
   {
      // traer valiables de seccion
      $idUsuario = $_SESSION['documneto'];
      $consulta = $mysqli->query("SELECT * FROM VW_Datos_Usuario WHERE idUsuario = '$idUsuario'");
      $usuario = $consulta->fetch_assoc();

      $documento = $usuario['idUsuario'];
      $nombre = $usuario['nombre'];
      $apellido = $usuario['apellido'];
      $Nacimiento = $usuario['fechaNacimiento'];
      $ConvertirNac = explode("-", $Nacimiento);
      $DiaNac = $ConvertirNac[2];
      $MesNac = (string)$ConvertirNac[1];
      $MesNacForm = ConvertMes($MesNac);
      $AñoNac = $ConvertirNac[0];
      $FechaNac = ($DiaNac.' de '.$MesNacForm.' de '.$AñoNac);
      $RH = $usuario['RH'];
      $telefono = $usuario['telefono'];
      $estado =  $usuario['activo'];
      $foto = $usuario['fotoPerfil'];
      $roles = explode(",", $usuario['roles']);
      $rolesNum = count($roles);
      $conductor = (string)$roles[0];
      if($rolesNum > 1) {
         $admin = (string)$roles[1];
      }
      $puntos = $usuario['puntos'];
      $proximoPunto = $usuario['proximoPunto'];
      $registro = $usuario['registro'];
      $ConvertirReg = explode("-", $registro);
      $MesReg = (string)$ConvertirReg[1];
      $MesRegForm = ConvertMes($MesReg);
      $AñoReg = $ConvertirReg[0];
      $FechaReg = ($MesRegForm.' de '.$AñoReg);

      $licencias = array();
      $fechaLicencias = array();
      $LicenciaActualizacion = array();

      $consultaLic = $mysqli->query("SELECT CL.nombreCategoria AS categoria, LU.fechaExpedicion AS expedicion, LU.actualizacion AS actualizacion FROM Usuario AS U INNER JOIN Licencia_Usuario AS LU ON U.idUsuario = LU.idUsuario INNER JOIN Categoria_licencia AS CL ON LU.idCategoria = CL.idCategoria WHERE U.idUsuario = '$idUsuario' ") or die($mysqli->error());
      while ( $valor = mysqli_fetch_array( $consultaLic ) ) {
         array_push($licencias, $valor['categoria']);
         array_push($fechaLicencias, $valor['expedicion']);
         array_push($LicenciaActualizacion, $valor['actualizacion']);
      }
      //Si no esta activo
      if (!$estado)
      {
         header("location: activar-cuenta.php"); 
      }
   }
   function ConvertMes($MesNac) {
      switch ($MesNac) {
         case '01':
            return 'Enero';
            break;       
         case '02':
            return 'Febrero';
            break;  
         case '03':
            return 'Marzo';
            break; 
         case '04':
            return 'Abril';
            break;
         case '05':
            return 'Mayo';
            break;    
         case '06':
            return 'Junio';
            break;  
         case '07':
            return 'Julio';
            break;
         case '08':
            return 'Agosto';
            break;
         case '09':
            return 'Septiembre';
            break;    
         case '10':
            return 'Octubre';
            break;  
         case '11':
            return 'Noviembre';
            break;     
         case '12':
            return 'Diciembre';
            break;   
         default:
            break;
      }
   }
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta name="format-detection" content="telephone=no">
   <meta name="msapplication-tap-highlight" content="no">
   <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
   <meta name='author' href="" email="" content='Julio Cesar Calderón Garcia - Desarrollador Multimedia'>
   <meta name="description" content="Aplicativo didactico empresarial de licencia vial para el personal conductor">
   <link rel="icon" type="image/png" href="img/logo.png"/>
   <title><?=$nombre?> | Vitales Historial</title>
   <?php 
      include 'componentes/libreriasprofile.php'; // Incluir archivos js y css
   ?>
</head>
<body>
   <div class="navbar-fixed">
      <div class="nav-wrapper">
         <nav>
            <div class="row">
               <div class="col s12">
                  <a class="modelica-bold brand-logo right">VITALES</a>
                  <ul class="left">
                     <li>
                        <a data-target="slide-out" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
                     </li>
                     <li>
                        <a href="perfil.php" class="btn-perfil waves-effect">
                           <?php
                              if(!isset($foto)) {
                                 echo'<img class="circle" src="img/Perfil.png">';
                              } else {
                                 echo'<img class="circle" src="'.$foto.'">';
                              }
                           ?>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </nav>
      </div>
   </div>

   <ul id="slide-out" class="sidenav">
      <li>
         <div class="user-view">
            <div class="background">
               <img src="img/fondoperfil2.jpg" width="300">
            </div>
            <a href="perfil.php" class="waves-effect">
               
               <?php
                  if(!isset($foto)) {
                     echo'<img class="circle" src="img/Perfil.png">';
                  } else {
                     echo'<img class="circle" src="'.$foto.'">';
                  }
               ?>
            </a>
            <a><span class="white-text name"><?=$nombre?> <?=$apellido?></span></a>
            <a href="puntos.php"><span class="white-text email"><?=$puntos?> Puntos</span></a>
         </div>
      </li>
      <li>
         <ul class="collapsible collapsible-accordion">
            <li class="bold active"><a class="collapsible-header waves-effect" tabindex="0"><i class="material-icons">account_circle</i>Mi Perfil<i class="material-icons right">expand_more</i></a>
              <div class="collapsible-body">
                <ul class="light">
                  <li><a href="perfil.php" class="waves-effect"><i class="material-icons">visibility</i>Ver Perfil</a></li>
                  <?php
                       if($puntos >= 12 ) {
                           echo '<li><a href="puntos.php" class="waves-effect"><i class="material-icons">star</i>Mis Puntos</a></li>';
                       }
                       else if ($puntos <= 11 && $puntos >= 7) {
                           echo '<li><a href="puntos.php" class="waves-effect"><i class="material-icons">star_half</i>Mis Puntos</a></li>';
                       }
                       else {
                           echo '<li><a href="puntos.php" class="waves-effect"><i class="material-icons">star_border</i>Mis Puntos</a></li>';
                       }
                  ?>
                  <li class="active"><a class="waves-effect sidenav-close"><i class="material-icons">history_edu</i>Historial</a></li>
                  <li><a href="actualizar.php" class="waves-effect"><i class="material-icons">edit</i>Editar datos</a></li>
                </ul>
              </div>
            </li>
         </ul>
      </li>
      
      <li>
         <ul class="collapsible collapsible-accordion">
            <li class="bold"><a class="collapsible-header waves-effect" tabindex="0"><i class="material-icons">policy</i>Programa Vitales<i class="material-icons right">expand_more</i></a>
              <div class="collapsible-body">
                <ul class="light">
                  <li><a href="programa.php" class="waves-effect">¿Qué es el programa?</a></li>
                  <li><a href="ganar_perder.php" class="waves-effect">¿Cómo gano o pierdo puntos?</a></li>
                  <li><a href="puntos.php" class="waves-effect">¡Quiero conocer mis puntos!</a></li>
                </ul>
              </div>
            </li>
          </ul>
      </li>
      
      <li>
         <a href="faq.php" class="waves-effect">
            <i class="material-icons">contact_support</i>FAQ
         </a>
      </li>
      
      <?php
         if(isset($admin)) {
            $_SESSION['admin'] = 0;
            echo '<li>
                     <a href="administrar.php" class="waves-effect">
                        <i class="material-icons">settings</i>Administrar
                     </a>
                  </li>
               ';
         }
      ?>
      
      <li class="aling-center">
         <a href="logout.php">
               <i class="material-icons">meeting_room</i>Cerrar sesión
         </a>
      </li>
      
  </ul>
  </div>

   <div class="container">
      <?php
         // Mostrar mensaje sobre el enlace de verificación de cuenta solo una vez
         if ( isset($_SESSION['message']) )
         {
            echo $_SESSION['message'];
            unset( $_SESSION['message'] );// Eliminar mensajes al actualizar la página
         }
      ?>
      <div class="row" style="margin-bottom: 0px">
         <div class="col s12 ">
            <blockquote class="hoverable z-depth-1 contenido grey lighten-5">
               <div class="row">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;Historial</h4>
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
               <div class="row">
                  <div class="col s12 center">
                     <h6 class="modelica-bold" style="margin-top: 0px"><?=$nombre?> <?=$apellido?></h6>
                     <p class="roles">
                        <?=$conductor?>
                        <?php
                           if(isset($admin)) {
                              echo ' y '.$admin.'';
                                       
                           };
                        ?>
                     </p>
                     <p class="puntaje">
                        <?php
                          if($puntos >= 12 ) {
                              echo '<a href="puntos.php" class="valign-wrapper alto"><i class="material-icons">star</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                          else if ($puntos <= 11 && $puntos >= 7) {
                              echo '<a href="puntos.php" class="valign-wrapper medio"><i class="material-icons">star_half</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                          else {
                              echo '<a href="puntos.php" class="valign-wrapper bajo"><i class="material-icons">star_border</i>&nbsp;&nbsp;<b>'.$puntos.'&nbsp;&nbspPuntos</b></a>';
                          }
                        ?>
                     </p>
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
                                 <img src="img/vacio.png">
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
               ?>

            </blockquote>
            <?php 
               include 'componentes/footer.php'; // Incluir footer
            ?>
         </div>
      </div>
   </div>
   <?php 
      include 'componentes/pop-up.php'; // Incluir pop-up
    ?>


</body>
</html>
<?php
   ob_end_flush();
?>
