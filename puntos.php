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
      # convertir base 64 a jpg
      /*$data = $usuario['foto'];
      $data = str_replace('data:image/jpeg;base64,', '', $data);
      $data = str_replace(' ', '+', $data);
      $data = base64_decode($data);
      $file = 'img/'.$nombre.'.jpg';
      $success = file_put_contents($file, $data);
      $foto = $file;*/
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
   <title><?=$nombre?> | Vitales Puntos </title>
   <script type="text/javascript" src="js/html2pdf.bundle.min.js"></script>
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
            <a><span class="white-text email"><?=$puntos?> Puntos</span></a>
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
                           echo '<li class="active"><a class="sidenav-close waves-effect"><i class="material-icons">star</i>Mis Puntos</a></li>';
                       }
                       else if ($puntos <= 11 && $puntos >= 7) {
                           echo '<li class="active"><a class="sidenav-close waves-effect"><i class="material-icons">star_half</i>Mis Puntos</a></li>';
                       }
                       else {
                           echo '<li class="active"><a class="sidenav-close waves-effect"><i class="material-icons">star_border</i>Mis Puntos</a></li>';
                       }
                  ?>
                  <li><a href="historial.php" class="waves-effect"><i class="material-icons">history_edu</i>Historial</a></li>
                  <li><a href="actualizar.php" class="waves-effect"><i class="material-icons">edit</i>Editar datos</a></li>
                </ul>
              </div>
            </li>
          </ul>
      </li>
      
      <li>
         <ul class="collapsible collapsible-accordion">
            <li class="bold active">
            	<a class="collapsible-header waves-effect" tabindex="0"><i class="material-icons">policy</i>Programa Vitales<i class="material-icons right">expand_more</i></a>
	              <div class="collapsible-body">
	                <ul class="light">
	                  <li><a href="programa.php" class="waves-effect">¿Qué es el programa?</a></li>
	                  <li><a href="ganar_perder.php" class="waves-effect">¿Cómo gano o pierdo puntos?</a></li>
	                  <li class="active"><a class="sidenav-close waves-effect">¡Quiero conocer mis puntos!</a></li>
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
         <div class="col s12">
            <blockquote class="hoverable z-depth-1 contenido white">
               <div class="row img-puntos">
                  <div class="col s12">
                     <?php
                     if($puntos >= 12 ) {
                           echo'<img class="puntos hoverable z-depth-1" src="img/oro.png" title="Medalla Oro" alt="Medalla Oro">';
                       }
                       else if ($puntos <= 11 && $puntos >= 7) {
                           echo'<img class="puntos hoverable z-depth-1" src="img/plata.png" title="Medalla Plata" alt="Medalla Plata">';
                       }
                       else {
                        echo'<img class="puntos hoverable z-depth-1" src="img/bronce.png" title="Medalla Bronce" alt="Medalla Bronce">';
                       }
                     ?>
                  </div>
               </div>
               <div class="row">
                  <div class="col s12 center titulo" >
                     <h4 class="modelica-black" style="margin-top: 0px"><img src="img/titulo.png">&nbsp;
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
                     </h4>
                     <h6 class="modelica-bold">
                        <?php
                          if($puntos >= 12 ) {
                              echo '<b class="valign-wrapper alto"><i class="material-icons">star</i>&nbsp;&nbsp;'.$puntos.'&nbsp;&nbspPUNTOS</b>';
                          }
                          else if ($puntos <= 11 && $puntos >= 7) {
                              echo '<b class="valign-wrapper medio"><i class="material-icons">star_half</i>&nbsp;&nbsp;'.$puntos.'&nbsp;&nbspPUNTOS</b>';
                          }
                          else {
                              echo '<b class="valign-wrapper bajo"><i class="material-icons">star_border</i>&nbsp;&nbsp;'.$puntos.'&nbsp;&nbspPUNTOS</b>';
                          }
                        ?>
                     </h6>
                  </div>
               </div>
               <div class="row img-puntos">
                  <div class="col s12 m6 center">
                     <?php
                        if(!isset($foto)) {
                           echo'<img class="usuario-puntos" src="img/Perfil.png">';
                        } else {
                           echo'<img class="usuario-puntos" src="'.$foto.'">';
                        }
                     ?>
                     <h6 class="modelica-bold"><?=$nombre?> <?=$apellido?></h6>
                     <p class="roles">
                        <?=$conductor?>
                        <?php
                           if(isset($admin)) {
                              echo ' y '.$admin.'';
                                       
                           };
                        ?>
                     </p>
                  </div>
                  <div class="col s12 m6">
                     <article class="" style="text-align: justify;">
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
                     </article>
                  </div>
               </div>
               <div class="center generarReporte">    
                  <a class="modelica-bold waves-effect waves-light btn-small hoverable btn-nueva-licencia"><i class="material-icons left">picture_as_pdf</i>Descargar Reporte</a>
               </div>

            </blockquote>
            <?php 
               include 'componentes/footer.php'; // Incluir footer
            ?>
         </div>
      </div>
   </div>
   <?php 
      include 'componentes/pop-up.php'; // Incluir pop-up
      include 'componentes/reporte.php'; // Incluir reporte
   ?>

</body>
</html>
<?php
   ob_end_flush();
?>


