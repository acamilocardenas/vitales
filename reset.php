<?php
	// Restablecimiento de contraseña, actualiza la base de datos con la nueva contraseña de usuario
   require 'db.php';
   session_start();
   // Obtenemos el Documento Hash desde los campos ocultos del formulario
   $Documento = $mysqli->escape_string($_POST['CedulaV']);
   $Hash = $mysqli->escape_string($_POST['HashV']);

   $Consulta = $mysqli->query("SELECT U.idUsuario AS idUsuario, L.hash AS hash, L.contraseña AS contraseña FROM Usuario AS U INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario WHERE U.idUsuario = '$Documento' AND L.hash = '$Hash'");
   if ($Consulta->num_rows == 0)
   { 
     	// los parametros de documento y hash no son validas
    	$_SESSION['message'] = '<div class="row">
	                                <div class="col s12 center-align">
	                                  	<div class="valign-wrapper">
			                                <div class="col s12 alertaError">
			                                    <p class="center"><b>¡Parámetros no válidos para la modificación de la cuenta!</b><br>Posiblemente haya cambiado su contraseña muy reciente.<br>Por favor vuelva a verificar la propiedad de su cuenta, si aún desea restablecer su contraseña.</p>
			                                </div>
			                            </div>
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col s12 center-align">
										<div class="col s6 center-align">
										  <a href="acceder.php">
										      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
										          <i class="material-icons right">vpn_key</i><b>Iniciar sección</b>
										      </button>
										  </a>
										</div>
										<div class="col s6 center-align">
										  <a href="verificar-cuenta.php">
										      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
										          <i class="material-icons right">home</i><b>Verificar cuenta</b>
										      </button>
										  </a>
										</div>
									</div>
	                            </div>';
      	header("location: error.php");
   }
   else 
   {
      	// verificamos que la contraseña no sea la actual
      	$UsuarioV = $Consulta->fetch_assoc();
      	if (password_verify($_POST['NewContraseña'], $UsuarioV['contraseña']))
      	{
	        $_SESSION['message'] = '<div class="row">
	                                	<div class="col s12 center-align">
		                                  	<div class="valign-wrapper">
				                                <div class="col s12 alerta">
				                                    <p class="center"><b>¡Ha ingresado la contraseña actual!</b></p>
				                                </div>
				                            </div>
		                                </div>
	                              	</div>
		                            <div class="row">

		                            	<div class="col s12 center-align">
											<div class="col s6 center-align">
											  <a href="acceder.php">
											      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
											        	<b><i class="material-icons right">vpn_key</i>Iniciar sesión</b>
											      </button>
											  </a>
											</div>
											<div class="col s6 center-align">
											  <a href="javascript:history.go(-1)">
											      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
											        	<i class="material-icons left">keyboard_backspace</i><b>Intentar de nuevo</b>
											      </button>
											  </a>
											</div>
										</div>
		                            </div>';
	      	header("location: error.php"); 
      	}
      	else
      	{
      		$NewContraseña = password_hash($_POST['NewContraseña'], PASSWORD_BCRYPT);
      		$NewHash = $mysqli->escape_string(md5(rand(0,1000)));
      		$idUsuario = $UsuarioV['idUsuario'];
      		$Actualizacion = ("UPDATE LogIn SET contraseña = '$NewContraseña', hash = '$NewHash' WHERE idUsuario = '$idUsuario' AND hash = '$Hash'");
      		//Confirmar actualizacion
	      	if ( $mysqli->query($Actualizacion) )
	      	{
	      		$Actualizar = $mysqli->query("UPDATE LogIn SET actualizacion = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
	      		$_SESSION['message'] = '<div class="row">
		                                	<div class="col s12 center-align">
			                                  	<div class="valign-wrapper">
					                                <div class="col s12 mensaje">
					                                    <p class="center"><b>¡Tu contraseña ha sido cambiada exitosamente!</b></p>
					                                </div>
					                            </div>
			                                </div>
		                              	</div>
			                            <div class="row">
			                                <div class="col s12 center-align">
			                                    <a href="acceder.php">
			                                        <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
			                                            <b><i class="material-icons right">vpn_key</i>Iniciar sesión</b>
			                                        </button>
			                                    </a>
			                                </div>
			                            </div>';
	        	header("location: success.php");    
	        }
	        else
	        {
	      		$_SESSION['message'] = '<div class="row">
		                                	<div class="col s12 center-align">
			                                  	<div class="valign-wrapper">
					                                <div class="col s12 alertaError">
					                                    <p class="center"><b>¡La actualización de la cuenta ha fallado!</b></p>
					                                </div>
					                            </div>
			                                </div>
		                              	</div>
			                            <div class="row">
			                                <div class="col s12 center-align">
			                                    <a href="javascript:history.go(-1)">
			                                        <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
			                                            <i class="material-icons left">keyboard_backspace</i><b>Intentar de nuevo</b>
			                                        </button>
			                                    </a>
			                                </div>
			                            </div>';
	        	header("location: error.php");    
	        }
      	}
    }
?>