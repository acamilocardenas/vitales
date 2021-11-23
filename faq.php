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
   <title>Bienvenido <?=$nombre?> | Vitales</title>
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
            <li class="bold"><a class="collapsible-header waves-effect" tabindex="0"><i class="material-icons">account_circle</i>Mi Perfil<i class="material-icons right">expand_more</i></a>
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
                  <li><a href="historial.php" class="waves-effect"><i class="material-icons">history_edu</i>Historial</a></li>
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
      
      <li class="active">
         <a class="sidenav-close waves-effect">
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
            <blockquote class="hoverable z-depth-1 contenido white">
               <div class="row">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;¿Preguntas Frecuentes?</h4>
                  </div>
               </div>
               <div class="row">
                  <div class="col s12">
                     <article >
                        <p><b>¿Cómo puedo ser un conductor oro?</b></p>
                        Haciendo parte de nuestro plan vitales, al hacerte parte recibirás una licencia en la categoría oro.<br>Al ser de estar categoría y recibir esta licencia tienes 12 puntos, aceptas que tu comportamiento vial durante el año será excelente.
                        <p><b>¿Qué otras categorías existen?</b></p>
                        Plata y bronce. Estas categorías tienen una puntuación de 7 a 11 y menor a 7.<br>Si estás en una de estas categorías probablemente has cometido una infracción o has faltado a las políticas establecidas por nuestra compañía. Pero ánimo ¡Todos pueden ser conductores oro!
                        <p><b>¿Por qué ya no soy conductor oro?</b></p>
                        Posiblemente has cometido una infracción o falta, una sola falta durante todo el año, baja toda tu categoría.
                        <p><b>¿Qué debo hacer para tener puntos en mi tarjeta Norgas?</b></p>
                        Deberás mantener tu buen comportamiento en la vía, cumplir con las normas y realizar un trabaja impecable siempre.
                        <p><b>¿Si soy un conductor oro, puedo ganar más puntos?</b></p>
                        Sí. Solo debes mantener tu categoría, no presentar ninguna novedad en la revisión anual de tu comportamiento vial.Si respetas la vía, cuidas tu vida y la de los demás, te aseguras de llegar siempre a casa tranquilo y feliz; ganarás 1 punto. Podrás alcanzar un máximo de 6 puntos.
                        <p><b>¿Por qué perdí puntos?</b></p>
                        Porque incumpliste con alguna de las políticas relacionadas con la seguridad vial.
                        <p><b>¿Cuáles son las faltas balas?</b></p>
                        No hacer la inspección pre operacional del vehículo.<br>Perderás 2 puntos.
                        <p><b>¿Cuáles son las faltas leves?</b></p>
                        Salir a operación de ruta sin portar la documentación vial exigible para el vehículo.<br>Perderás 3 puntos.
                        <p><b>¿Cuáles son las faltas medias?</b></p>
                        Uso de teléfonos móviles en conducción.<br>Perderás 4 puntos.
                        <p><b>¿Cuáles son las faltas graves?</b></p>
                        Llevar personas ajenas a la organización en tu vehículo.<br>Perderás 6 puntos.
                        <p><b>¿Cómo sé cuántos puntos tengo?</b></p>
                        Podrás escanear tu código QR de la pulsera entregada por recursos humanos. También puedes ingresar a ww.programavital.com y conocer tu categoría.


                     </article>
                  </div>
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
    ?>


</body>
</html>
<?php
   ob_end_flush();
?>