<?php
   /* Muestra información del usuario y algunos mensajes útiles */
   ob_start();
   require 'db.php';
   session_start();
   unset( $_SESSION['message'] );//eliminamos posibles mesages de error
   //verificamos url estado de la actualización
   if(isset($_GET['update']) && !empty($_GET['update']))
   {
      $update = $mysqli->escape_string($_GET['update']);
      if ( $update == 1 )
      { 
         // Actualización exitosa
         $_SESSION['update'] = '<div class="col s12 valign-wrapper before-update">
                                    <div class="center-aling mensaje">
                                       <p style="text-align: center"><b>La cuenta se ha actualizado correctamente.</b></p>
                                    </div>
                                 </div>';
      }
      else
      { 
         $_SESSION['update'] = '<div class="col s12 valign-wrapper before-update">
                                    <div class="center-aling error">
                                       <p style="text-align: center"><b>La actualización de la cuenta ha fallado.</b></p>
                                    </div>
                                 </div>';
      }
      header("location: actualizar.php");
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
      $FechaNac = ($DiaNac.' de '.$MesNacForm.', '.$AñoNac);
      $FechaNacJs = ($DiaNac.' '.$MesNacForm.', '.$AñoNac);
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
   <title><?=$nombre?> | Vitales Actualizar</title>

   <?php 
      include 'componentes/libreriasprofile.php'; // Incluir archivos js y css
      // $licencias = ['C3'];
      // $fechaLicencias = ['1984-01-19'];
   ?>
   <script type="text/javascript">
      let DocumentoJS = "<?= $documento ?>";
      let NombreJS = "<?= $nombre ?>";
      let ApellidoJS = "<?= $apellido ?>";
      let FechaNacJs = "<?= $FechaNacJs ?>";
      let RHJS = "<?= $RH ?>";
      let TelefonoJS = "<?= $telefono ?>";
      let LicenciasJS = <?php echo json_encode($licencias);?>;
      let FechaLicenciasJS = <?php echo json_encode($fechaLicencias);?>;
   </script>
   <link rel="stylesheet" href="css/croppr.min.css"/>
   <script type="text/javascript" src="js/croppr.min.js"></script>
   <script type="text/javascript" src="js/recortarFoto.js"></script>
   <script type="text/javascript" src="js/actualizar.js"></script>
   <script type="text/javascript" src="js/dateFormat.js"></script>

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
                  <li><a href="historial.php" class="waves-effect"><i class="material-icons">history_edu</i>Historial</a></li>
                  <li class="active"><a class="sidenav-close waves-effect"><i class="material-icons">edit</i>Editar datos</a></li>
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
                  <li><a href="programa.php"class="waves-effect">¿Qué es el programa?</a></li>
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
            <blockquote class="hoverable z-depth-1 contenido white">
               <div class="row">
                  <div class="col s12 center titulo">
                     <h4 class="modelica-black"><img src="img/titulo.png">&nbsp;Actualizar Cuenta</h4>
                  </div>
               </div>
               <div class="row">
                  <div class="col s12 center">
                     <article>
                        <img src="img/actualizar.png" class="editar center"><br>
                        Aquí podras verificar y actualizar la información de tu cuenta.
                     </article>
                  </div>
                  <?php
                     if( isset($_SESSION['update']) ) {
                        echo $_SESSION['update'];
                     }
                     if(!isset($_GET['update'])) {
                        unset( $_SESSION['update'] );// Eliminar mensajes de update
                     }
                  ?>
                  <div class="col s12">
                     <ul class="collection with-header">
                        <li class="collection-header modelica-bold">
                           <div class=" valign-wrapper titulo-editar">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">how_to_reg</i></h4></div>
                                <div class="col s11">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">DATOS PERSONALES</h5>
                                    <h6 class="modelica-bold show-on-small hide-on-med-and-up" style="margin-left: 1rem">DATOS PERSONALES</h6>
                                </div>
                            </div>
                        </li>
                        <a class="collection-item dato" onclick="documento()">
                           <div class="truncate blue-grey-text"><b>Documento:</b> <?=$documento?></div>
                        </a>
                        <a class="collection-item dato edit-nombre-btn">
                           <div class="truncate"><b>Nombre:</b> <?=$nombre?> <?=$apellido?></div>
                           <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">edit</i></div>
                        </a>


                        <li class="collection-item edit-nombre">

                           <div class="valign-wrapper while-update-nombre hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando Nombre!</b><br>Espere un momento...</p>
                              </div>
                           </div>
                           
                           <div class="row form-nombre" style="margin-bottom: 0px">
                              <p style="padding: 0px 10px; margin-top: 0px"><b>Nombre:</b> Los cambios aplicados a tu nombre se reflejarán en tu cuenta, por favor indique su nombre/s y apellidos completos.</p>
                              <div class="input-form col s12">
                                 <div class="input-field col m6 s12 ReNombres">
                                     <input id="Nombre" type="text" name="Nombre" value="<?= $nombre ?>">
                                     <label class="active" for="Nombre" >Nombre*</label>
                                     <span class="helper-text" data-error="Nombre incorrecto" data-success="Nombre correcto"></span>
                                 </div>
                                 <div class="input-field col m6 s12 ReApellidos">
                                     <input id="Apellido" type="text" name="Apellido" value="<?= $apellido ?>">
                                     <label class="active" for="Apellido">Apellidos*</label>
                                     <span class="helper-text" data-error="Apellidos incorrecto" data-success="Apellidos correcto"></span>
                                 </div>
                              </div>
                              <div class="actualizar col s12">
                                 <a class="close-nombre-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                 <a class="update-nombre-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                              </div>
                           </div>

                        </li>

                        <a class="collection-item dato edit-brithday-btn">
                           <div><b>Fecha de nacimiento:</b> <?=$FechaNac?></div>
                           <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">edit</i></div>
                        </a>

                        <li class="collection-item edit-brithday">

                           <div class="valign-wrapper while-update-brithday hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando Fecha de nacimiento!</b><br>Espere un momento...</p>
                              </div>
                           </div>
                           
                           <div class="row form-brithday" style="margin-bottom: 0px">
                              <p style="padding: 0px 10px; margin-top: 0px"><b>Fecha de nacimiento:</b> Tu fecha de nacimiento se puede usar para reforzar la seguridad de la cuenta.</p>
                              <div class="input-form col s12">
                                 <div class="input-field col s12">
                                    <input id="Nacimiento" type="text" class="datepicker ReNacimiento">
                                    <label for="Nacimiento">Fecha de nacimiento*</label>
                                    <span class="helper-text" data-error="Fecha incorrecta" data-success="Fecha correcta"></span>
                                 </div>
                              </div>
                              <div class="actualizar col s12">
                                 <a class="close-brithday-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                 <a class="update-brithday-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                              </div>
                           </div>
                           
                        </li>

                        <a class="collection-item dato edit-rh-btn">
                           <div><b>Grupo Sanguíneo y RH:</b> <?=$RH?></div>
                           <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">edit</i></div>
                        </a>

                        <li class="collection-item edit-rh">

                           <div class="valign-wrapper while-update-rh hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando Grupo Sanguíneo y RH!</b><br>Espere un momento...</p>
                              </div>
                           </div>
                           
                           <div class="row form-rh" style="margin-bottom: 0px">
                              <p style="padding: 0px 10px; margin-top: 0px"><b>Grupo Sanguíneo y RH:</b> Tu grupo sanguíneo y RH es muy importante para nosotros, elige adecuadamente.</p>
                              <div class="input-form col s12">
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
                              <div class="actualizar col s12">
                                 <a class="close-rh-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                 <a class="update-rh-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                              </div>
                           </div>
                           
                        </li>
                     </ul>
                  </div>

                  <div class="col s12">
                     <ul class="collection with-header">
                        <li class="collection-header modelica-bold">
                           <div class=" valign-wrapper titulo-editar">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">account_circle</i></h4></div>
                                <div class="col s11">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">FOTO DEL PERFIL</h5>
                                    <h6 class="modelica-bold show-on-small hide-on-med-and-up" style="margin-left: 1rem">FOTO DEL PERFIL</h6>
                                </div>
                            </div>
                        </li>

                        <a class="collection-item avatar edit-foto-btn">
                           <div>
                              <?php
                                 if(!isset($foto)) {
                                    echo'<img class="circle" src="img/Perfil.png">';
                                 } else {
                                    echo'<img class="circle" src="'.$foto.'">';
                                 }
                              ?>
                              <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">photo_camera</i></div>
                              <div class="center info">Puedes personalizar tu cuenta con una foto</div>
                           </div>
                        </a>

                        <li class="collection-item edit-foto">

                           <div class="valign-wrapper while-update-foto hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando tu foto de usuario!</b><br>Espere un momento...</p>
                              </div>
                           </div>
                           


                           <div class="row form-foto" style="margin-bottom: 0px">
                              <p style="padding: 0px 10px; margin-top: 0px"><b>Foto de perfil:</b> Puedes personalizar tu cuenta con una foto.</p>

                              <div class="valign-wrapper">
                                 <div class="col s12 informacion" style="margin-right: 10px;">
                                    <p class="center"><b>Instrucciones:</b><br>Cargue al sistema una <b>imagen sin trasparencias</b>.<br>Utilice el editor para ajustar la posición y tamaño de la imagen.<br>Observe los resultados <b>en la vista previa</b>.</p>
                                 </div>
                              </div>
                              
                              <div class="input-form">
                                 <div class="file-field input-field col s12">
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

                              <div class="col s12 editorPrew hide">
                             
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
                                        <p style="text-align: center;"><br>Aquí puede observar los resultados.<br>La foto de perfil será publicada conforme se muestra en esta vista previa.</p>
                                    </div>
                                 </div>
                              </div>

                              <div class="row hide">
                                 <div class="input-field col s12 fotoBase64">
                                    <textarea id="fotoBase64" class="materialize-textarea" name="fotoBase64" value=""></textarea>
                                    <label for="fotoBase64" class="active">Foto Base64</label>
                                 </div>
                              </div>

                              <div class="actualizar col s12">
                                 <a class="close-foto-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                 <a class="update-foto-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                              </div>
                           </div>
                           
                        </li>

                     </ul>
                  </div>

                  <div class="col s12">
                     <ul class="collection with-header">
                        <li class="collection-header modelica-bold">
                           <div class=" valign-wrapper titulo-editar">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">local_shipping</i></h4></div>
                                <div class="col s11">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">DATOS DE LA LICENCIA</h5>
                                    <h6 class="modelica-bold show-on-small hide-on-med-and-up" style="margin-left: 1rem">DATOS DE LA LICENCIA</h6>
                                </div>
                            </div>
                        </li>
                        <?php
                           foreach (($licencias) as $clave => $licencia) {
                              $NumLicencias = count($licencias);
                              $NumLicencia = ['uno', 'dos', 'tres'];
                              $Expedicion = explode("-", $fechaLicencias[$clave]);
                              $DiaExp = $Expedicion[2];
                              $MesExp = (string)$Expedicion[1];
                              $MesExpForm = ConvertMes($MesExp);
                              $AñoExp = $Expedicion[0];
                              $FechaExp = ($DiaExp.' de '.$MesExpForm.', '.$AñoExp);
                              echo '<a class="collection-item licencias edit-lic-'.$NumLicencia[$clave].'-btn">
                                       <div><strong>Licencia:</strong> '.($clave + 1).' de 3</div>
                                       <div><strong>Categoría:</strong> '.$licencia.'</div>
                                       <div><b>Fecha expedición: </b> '.$FechaExp.'</div>
                                       <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">chevron_right</i></div>
                                    </a>';

                              echo  '<li class="collection-item edit-lic-'.$NumLicencia[$clave].'">
                                                               
                                       <div class="valign-wrapper while-update-lic-'.$NumLicencia[$clave].' hide">
                                          <div class="col s12 informacion" style="margin-right: 10px;">
                                             <p class="center">
                                                <div class="progress light-blue lighten-3">
                                                   <div class="indeterminate light-blue darken-1"></div>
                                                </div>
                                             </p>
                                             <p class="center"><b>¡Actualizando Licencia!</b><br>Espere un momento...</p>
                                          </div>
                                       </div>
      
                                       <div class="valign-wrapper while-delete-lic-'.$NumLicencia[$clave].' hide">
                                          <div class="col s12 error" style="margin-right: 10px;">
                                             <p class="center">
                                                <div class="progress red lighten-3">
                                                   <div class="indeterminate red darken-1"></div>
                                                </div>
                                             </p>
                                             <p class="center"><b>Eliminando Licencia!</b><br>Espere un momento...</p>
                                          </div>
                                       </div>';
                                       
                                       if (count($licencias) > 1) 
                                       { 
                                 echo '<div class="valign-wrapper delete delete-lic-'.$NumLicencia[$clave].' hide">
                                          <div class="row" style="margin-bottom: 0px;">   
                                             <div class="col m8 s12">
                                                <p class="center" style="margin: 0px;">¿Está seguro de eliminar la licencia <b>'.$licencia.'</b> con fecha de expedición <b>'.$FechaExp.'</b> de su perfil?</p>
                                             </div>
                                             <div class="col m4 s12">
                                                <div class="eliminar-btns"  style="margin-bottom: 0px;">   
                                                   <a class="cancel-delete-lic-'.$NumLicencia[$clave].'-btn waves-effect btn-floating red darken-1"><i class="material-icons">close</i></a>
                                                   <a class="confirm-delete-lic-'.$NumLicencia[$clave].'-btn waves-effect btn-floating green darken-1"><i class="material-icons">done </i></a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>';
                                       }

                                  echo '<div class="row form-lic-'.$NumLicencia[$clave].'" style="margin-bottom: 0px">
                                          <p style="padding: 0px 10px; margin-top: 0px"><strong>Licencia:</strong> '.($clave + 1).' de 3</p>
                                          <div class="input-form col s12">
                                             <div class="input-field col m6 s12">
                                                <select id="Licencia-'.$NumLicencia[$clave].'" class="Licencia-'.$NumLicencia[$clave].'"></select>
                                                <label for="Licencia-'.$NumLicencia[$clave].'">Categoria de Licencia*</label>
                                                <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                            </div>
                                            
                                             <div class="input-field col m6 s12">
                                                <input id="Expedicion-'.$NumLicencia[$clave].'" type="text" class="datepicker Expedicion-'.$NumLicencia[$clave].'">
                                                <label for="Expedicion-'.$NumLicencia[$clave].'">Fecha Expedición*</label>
                                                <span class="helper-text" data-error="Fecha expedicion incorrecta" data-success="Fecha Expedicion correcta"></span>
                                             </div>
                                          </div>

                                          <div class="actualizar col s12">
                                             <a class="close-lic-'.$NumLicencia[$clave].'-btn waves-effect btn-floating red darken-1"><i class="material-icons">close</i></a>';
          if (count($licencias) > 1) { echo '<a class="delete-lic-'.$NumLicencia[$clave].'-btn waves-effect btn-floating blue-grey darken-4"><i class="material-icons">delete_forever</i></a>';}
                                       echo '<a class="update-lic-'.$NumLicencia[$clave].'-btn waves-effect btn-floating green darken-1"><i class="material-icons">done</i></a>
                                          </div>
                                       </div>
                                       
                                    </li>';
                           }
                           if (count($licencias) < 3) {
                              $NuevaLicencia =  $NumLicencias;
                              $NumNewLicencia = ['uno', 'dos', 'tres'];
                               echo '<a class="collection-item nueva-lic-btn edit-lic-'.$NumNewLicencia[$NuevaLicencia].'-btn">
                                       <div><b>Nueva Licencia</b>
                                       <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">add</i></div></div>
                                    </a>

                                    <li class="collection-item edit-lic-'.$NumNewLicencia[$NuevaLicencia].'">
                                                                  
                                       <div class="valign-wrapper while-add-lic-'.$NumNewLicencia[$NuevaLicencia].' hide">
                                          <div class="col s12 informacion" style="margin-right: 10px;">
                                             <p class="center">
                                                <div class="progress light-blue lighten-3">
                                                   <div class="indeterminate light-blue darken-1"></div>
                                                </div>
                                             </p>
                                             <p class="center"><b>¡Añadiendo Licencia!</b><br>Espere un momento...</p>
                                          </div>
                                       </div>
                                       
                                       <div class="row form-lic-'.$NumNewLicencia[$NuevaLicencia].'" style="margin-bottom: 0px">
                                          <p style="padding: 0px 10px; margin-top: 0px"><strong>Nueva Licencia:</strong> '.($NuevaLicencia + 1).' de 3</p>
                                          <div class="input-form col s12">
                                             <div class="input-field col m6 s12">
                                                <select id="Licencia-'.$NumNewLicencia[$NuevaLicencia].'" class="Licencia-'.$NumNewLicencia[$NuevaLicencia].'"></select>
                                                <label for="Licencia-'.$NumNewLicencia[$NuevaLicencia].'">Categoria de Licencia*</label>
                                                <span class="helper-text" data-error="Incorrecto" data-success="Correcto"></span>
                                            </div>
                                             <div class="input-field col m6 s12">
                                                <input id="Expedicion-'.$NumNewLicencia[$NuevaLicencia].'" type="text" class="datepicker Expedicion-'.$NumNewLicencia[$NuevaLicencia].'">
                                                <label for="Expedicion-'.$NumNewLicencia[$NuevaLicencia].'">Fecha Expedición*</label>
                                                <span class="helper-text" data-error="Fecha expedicion incorrecta" data-success="Fecha Expedicion correcta"></span>
                                             </div>
                                          </div>
                                       

                                          <div class="actualizar col s12">
                                             <a class="close-lic-'.$NumNewLicencia[$NuevaLicencia].'-btn waves-effect btn-floating red darken-1"><i class="material-icons">close</i></a>
                                             <a class="add-lic-'.$NumNewLicencia[$NuevaLicencia].'-btn waves-effect btn-floating green darken-1"><i class="material-icons">done</i></a>
                                          </div>
                                       </div>
                                       
                                    </li>';
                           }
                        ?>

                        
                     </ul>
                  </div>

                  <div class="col s12">
                     <ul class="collection with-header">
                        <li class="collection-header modelica-bold">
                           <div class=" valign-wrapper titulo-editar">
                                <div class="col s1" style="margin: 0px; padding: 0px;"><h4><i class="material-icons">lock</i></h4></div>
                                <div class="col s11">
                                    <h5 class="modelica-bold show-on-medium-and-up hide-on-small-only">SEGURIDAD DE LA CUENTA</h5>
                                    <h6 class="modelica-bold show-on-small hide-on-med-and-up" style="margin-left: 1rem">SEGURIDAD DE LA CUENTA</h6>
                                </div>
                            </div>
                        </li>
                        <a class="collection-item dato edit-tel-btn">
                           <div><b>Número de celular:</b> <?=$telefono?></div>
                           <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">edit</i></div>
                        </a>

                        <li class="collection-item edit-tel">

                           <div class="valign-wrapper while-update-tel hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando Número de celular!</b><br>Espere un momento...</p>
                              </div>
                           </div>
                           
                           <div class="row form-tel" style="margin-bottom: 0px">
                              <p style="padding: 0px 10px; margin-top: 0px"><b>Número de celular:</b> Usarás esta información si alguna vez olvidas tu contraseña.</p>
                              <div class="input-form col s12">
                                 <div class="input-field col s12 ReTelefono">
                                    <input  id="Telefono" type="text" class="Telefono" name="Telefono" value="<?= $telefono ?>">
                                    <label for="Telefono">Número de celular*</label>
                                    <span class="helper-text" data-error="Número de Contacto Incorrecto" data-success="Número de Contacto correcto"></span>
                                </div>
                              </div>
                              <div class="actualizar col s12">
                                 <a class="close-tel-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                 <a class="update-tel-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                              </div>
                           </div>
                           
                        </li>

                        <a class="collection-item dato edit-pass-btn">
                           <div><b>Contraseña:</b> ••••••••••</div>
                           <div class="secondary-content blue-grey-text text-lighten-2"><i class="material-icons">edit</i></div>
                        </a>

                        <li class="collection-item edit-pass">

                           <div class="valign-wrapper while-update-pass hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>¡Actualizando Contraseña!</b><br>Espere un momento...</p>
                              </div>
                           </div>

                           <div class="valign-wrapper while-verificar-pass hide">
                              <div class="col s12 informacion" style="margin-right: 10px;">
                                 <p class="center">
                                    <div class="progress light-blue lighten-3">
                                       <div class="indeterminate light-blue darken-1"></div>
                                    </div>
                                 </p>
                                 <p class="center"><b>Verificando Contraseña!</b><br>Espere un momento...</p>
                              </div>
                           </div>

                           <div class="valign-wrapper error-verificar-pass hide">
                              <div class="col s12 error" style="margin-right: 10px;">
                                 <p class="center"><b>¡Contraseña incorrecta!</b><br>Por favor vuelva a intentarlo.</p>
                              </div>
                           </div>

                           
                           <div class="row form-pass" style="margin-bottom: 0px">

                              <div class="verificar-pass">
                                 <p style="padding: 0px 10px; margin-top: 0px"><b>Contraseña:</b> Para actualizar su contraseña debe ingresar su contraseña actual.</p>
                                 

                                 <div class="input-form col s12">
                                    <div class="input-field col s12 AntContraseña">
                                       <input id="Antcontraseña" type="password"  name="ContraseñaAnterior">
                                       <label for="Antcontraseña">Contraseña Actual*</label>
                                       <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                                    </div>

                                    <div class="input-field col s11"  style="margin: -20px 0px 50px 0px"> 
                                       <label>
                                           <input type="checkbox" class="filled-in mostrar-pass-ante"/>
                                           <span>Mostrar contraseña</span>
                                       </label>
                                   </div>
                                 </div>
                                 <div class="actualizar col s12">
                                    <a class="close-pass-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                    <a class="verificar-pass-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                                 </div>
                              </div>
                                 
                              <div class="actualizar-pass">
                                 <p style="padding: 0px 10px; margin-top: 0px"><b>Contraseña:</b> Sé verífico correctamente su contraseña, ya puedes elegir tu nueva contraseña.</p>

                                 <div class="valign-wrapper">
                                    <div class="col s12 mensaje">
                                       <p class="center"><b>*Ten encuenta que tu contraseña:</b><br>Solo puede tener números y letras, contener mínimo 8 carácteres, mínimo una letra, mínimo un número y no pueden haber espacios en blanco.</p>
                                    </div>
                                 </div>

                                 <div class="valign-wrapper error-update-pass hide">
                                    <div class="col s12 alerta" style="margin-right: 10px;">
                                       <p class="center"><b>¡Ha ingresado la contraseña actual!</b><br>Por favor vuelva a intentarlo.</p>
                                    </div>
                                 </div>

                                 <div class="input-form col s12">
                                    <div class="input-field col m6 s12 ReContraseña">
                                       <input id="contraseña" type="password"  name="Contraseña">
                                       <label for="contraseña">Nueva contraseña*</label>
                                       <span class="helper-text" data-error="Contraseña Incorrecta" data-success="Contraseña correcta"></span>
                                    </div>
                                    <div class="input-field col m6 s12 ValContraseña">
                                       <input id="valcontraseña" type="password">
                                       <label for="valcontraseña">Repetir contraseña*</label>
                                       <span class="helper-text" data-error="Las contraseñas no coinciden" data-success="Las contraseñas coinciden"></span>
                                    </div>
                                    <div class="input-field col s11"  style="margin: -20px 0px 50px 0px"> 
                                       <label>
                                           <input type="checkbox" class="filled-in mostrar-pass-new"/>
                                           <span>Mostrar contraseñas</span>
                                       </label>
                                   </div>
                                 </div>
                                 <div class="actualizar col s12">
                                    <a class="close-pass-btn waves-effect btn-floating red darken-1"><i class="material-icons left">close</i></a>
                                    <a class="update-pass-btn waves-effect btn-floating green darken-1"><i class="material-icons left">done</i></a>
                                 </div>
                              </div>

                           </div>

                        </li>

                     </ul>
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
      #include 'componentes/ActualizarPop-up.php'; // Incluir pop-up's de actualizaciones
   ?>
   <?php 
      include 'componentes/pop-up.php'; // Incluir pop-up
   ?>

</body>
</html>
<?php
   ob_end_flush();
?>

