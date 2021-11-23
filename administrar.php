<?php
   /* Muestra información del usuario y algunos mensajes útiles */
   ob_start();
   require 'db.php';
   session_start();
   unset( $_SESSION['message'] );//eliminamos posibles mesages de error
   //verificamos url inicio de seccion administrador
   if(isset($_GET['admin']) && !empty($_GET['admin']) AND isset($_GET['password']) && !empty($_GET['password']))
   {
      $admin = $mysqli->escape_string($_GET['admin']);
      $password = $mysqli->escape_string($_GET['password']);
      $consulta = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$admin'");
  
      if ( $consulta->num_rows == 0 )
      { 
         // El usuario no existe
         $_SESSION['admin'] = 0;
      }
      else
      { 
        // El usuario si existe
         $usuario = $consulta -> fetch_assoc();
         //verificar contraseña
         if (password_verify($password, $usuario['contraseña']))
         {
            $_SESSION['admin'] = 1;
         }
         else
         {
            $_SESSION['admin'] = 0;
         }
      }
      header("location: administrar.php");
    }
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
     <script type="text/javascript">
      let DocumentoJS = "<?= $documento ?>";
   </script>
   <script type="text/javascript" src="js/buscarInfractores.js"></script>
   <script type="text/javascript" src="js/scroll-vertical.js"></script>
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
        
        <li>
           <a href="faq.php" class="waves-effect">
              <i class="material-icons">contact_support</i>FAQ
           </a>
        </li>
        
        <?php
           if(isset($admin)) {
              if ($_SESSION['admin'] != 1 || !isset($_SESSION['admin']))
              {
                
                echo '<li class="active verificar">
                          <a class="sidenav-close waves-effect">
                            <i class="material-icons">settings</i>Administrar
                          </a>
                      </li>';
              }
              else {
                echo '<li>
                        <ul class="collapsible collapsible-accordion">
                          <li class="bold active"><a class="collapsible-header waves-effect" tabindex="0"><i class="material-icons">settings</i>Administrar<i class="material-icons right">expand_more</i></a>
                            <div class="collapsible-body">
                              <ul class="light">
                                <li class="active"><a class="sidenav-close waves-effect"><i class="material-icons">thumb_down</i>Usuarios infractores</a></li>
                                <li><a href="licencias.php" class="waves-effect"><i class="material-icons">departure_board</i>Licencias a vencer</a></li>
                                <li><a href="usuarios.php" class="waves-effect"><i class="material-icons">person_search</i>Evaluar usuarios</a></li>';
                                if ($admin== 'Super-Admin') { 
                                    echo '<li><a href="admin-usuarios.php" class="waves-effect"><i class="material-icons">no_accounts</i>Administrar usuarios</a></li>';
                                } echo '
                              </ul>
                            </div>
                          </li>
                        </ul>
                      </li>';
              }
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
         <?php
               if ($_SESSION['admin'] != 1 || !isset($_SESSION['admin']))
               {
                  echo'
                        <blockquote class="hoverable z-depth-1 contenido white">
                           <div class="row">
                              <div class="col s12 center titulo">
                                 <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;ADMINISTRAR</h4>
                              </div>
                           </div>

                           <div class="verificar">
                              <div class="valign-wrapper">
                                 <div class="col s12 alerta">
                                    <p class="center"><b>¡Ingresa tu contraseña para continuar!</b><br>Por favor ingrese tu contraseña para validar tu panel administrativo.</p>
                                 </div>
                              </div>

                              <div class="row input-form hide">
                                 <div class="input-field col s12 InDocumento">
                                    <input id="Documento" autocomplete="off" type="text" value="'.$documento.'" name="CedulaV" id="disabled">
                                    <label for="Documento">Usuario*</label>
                                 </div>
                              </div>

                              <div class="row input-form" style="margin-bottom:0px;">
                                <div class="input-field col s11 InContraseña">                                      
                                    <input id="InContraseña" type="password"  name="Contraseña">
                                    <label for="InContraseña">Contraseña*</label>
                                    <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                                 </div>
                                 <div class="tippedpass col s1">
                                    <a class="tooltipped" data-position="top" data-tooltip="<div><b>Recuerda:</b><br>Solo números y letras.<br>Mínimo 8 carácteres.<br>Mínimo una letra.<br>Mínimo un número.<br>No contener espacios en blanco.</div>"><i class="material-icons">feedback</i></a>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="input-field col s11"  style="margin-top: -20px;"> 
                                    <label>
                                       <input type="checkbox" class="filled-in mostrar-pass"/>
                                       <span>Mostrar contraseña</span>
                                    </label>
                                 </div>
                              </div>

                              <!-- mensaje de formulario correcto al enviar -->
                              <div class="valign-wrapper loginSuccess hide">
                                 <div class="col s12 informacion">
                                    <p class="center">
                                       <div class="progress light-blue lighten-3">
                                          <div class="indeterminate light-blue darken-1"></div>
                                       </div>
                                    </p>

                                    <p class="center"><b>¡Procesando datos de inicio de sección!</b><br>Tus datos fueros validados y enviados correctamente.<br>Espere un momento...</p>
                                 </div>
                              </div>

                              <!-- mensaje de formulario incorrecto al enviar -->
                              <div class="valign-wrapper loginError hide">
                                 <div class="col s12 error">
                                    <p class="center"><b>¡No podemos verificar tus datos!</b><br>Formulario incompleto o incorrecto.<br>Por favor revisa tus datos para iniciar sección.</p>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="input-field col s12 center-align btn-login">
                                    <button class="modelica-bold btn waves-effect waves-light btn-large hoverable blue darken-3" type="submit">
                                       <b>ADMINISTRAR</b>
                                       <i class="material-icons right">settings</i>
                                    </button>
                                 </div>
                              </div>
                           </div>

                        </blockquote>';
               }
               else
               {
                  echo'
                        <blockquote class="hoverable z-depth-1 contenido white">
                        <div class="row">
                           <div class="valign-wrapper loginAdminOk">
                              <div class="col s12 mensaje">
                                 <p class="center"><b>¡Hola Administrador '.$nombre.'!</b><i class="material-icons right" style="color:#155724">clear</i><br>Tus datos fueros validados correctamente.<br>Ahora cuentas con nuevas opciones en tu menú lateral, donde podrás ver, administrar y evaluar todos los usuarios conductores registrados.<br>Cada vez que salgas de panel administrativo tendrás que volver a verificar tu usuario.</p>
                              </div>
                           </div>

                           <div class="row" style="margin-bottom: 0px">
                              <div class="col s12 center titulo">
                                 <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;USUARIOS INFRACTORES</h4>
                              </div>
                           </div>

                           <div class="valign-wrapper admin-mobile hide">
                              <div class="col s12 error">
                                 <p class="center"><b>Recuerda:</b><br>Administrar es mejor desde un PC de escritorio o portátil.</p>
                              </div>
                           </div>

                           <div class="row en-mantenimiento hide">

                              <div class="col s12 center mantenimiento">
                                 <img src="img/mantenimiento.png">
                              </div>

                              <div class="col s12 center mantenimiento">
                                 <div class="valign-wrapper">
                                    <div class="col s12 alerta">
                                       <p class="center">
                                          <div class="progress orange  lighten-3">
                                             <div class="determinate  brown lighten-1" style="width: 80%"></div>
                                          </div>
                                       </p>
                                       <p class="center">
                                          <b>¡Oops!<br>Sitio en mantenimiento y construcción</b><br>Estamos trabajando lo más rápido posible para brindarte la mejor experiencia como administrador, vuelva pronto.<br>Gracias.
                                       </p>
                                    </div>
                                 </div>
                              </div>
                        </div>

                           

                            <div class="col s12 center sin-historial">
                              <p>Aquellos usuarios del programa vitales que hayan infringido políticas, tengan compárenlos y/o infracciones registradas; aparecerán aquí.</p>
                            </div>
                           </div>

                           <div class="row" style="margin-bottom: 0px;">


                            <nav style="height: 48px; line-height: 48px;">
                                <div class="nav-wrapper">
                                   <div class="input-field busqueda">
                                      <input id="search" type="search" placeholder="Buscar usuario">
                                      <label for="search" class="label-icon"><i class="material-icons" style="height: 48px; line-height: 48px;">search</i></label>
                                      <i class="material-icons" style="height: 48px; line-height: 48px;">close</i>
                                   </div>
                                </div>
                            </nav>

                            <div class="col s12" style="margin-top: 5px;">
                                <p style="margin: 0px" class="grey-text">Buscar usuarios por nombre o número de identificación, luego presione ENTER.</p>
                            </div> 

                            <div class="col s12 while-search hide">
                                <div class="valign-wrapper">
                                    <div class="col s12 informacion">
                                        <p class="center">
                                             <div class="progress cyan lighten-2">
                                                <div class="indeterminate cyan darken-3"></div>
                                             </div>
                                        </p>
                                        <p class="center"><b>¡Cargando información de los usuarios.!</b><br>Espere un momento...</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="datos"></div>';
                                   

                    

                   echo '</blockquote>';
               }
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