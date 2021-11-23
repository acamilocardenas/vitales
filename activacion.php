<?php
	//Proceso de activacion, actualiza la informacion de logIn del usuario a la db programa_vitale
	//Datos de seguridad validar usuario evitar manipulacion del DOM
	$Documento = $mysqli->escape_string($_POST['Documento']);
	$Pass = $mysqli->escape_string($_POST['Pass']);
	$Hash = $mysqli->escape_string($_POST['Hash']);

	//Datos de seguridad
	$Telefono = $mysqli->escape_string($_POST['Telefono']);
	$Password = $mysqli->escape_string(password_hash($_POST['Contraseña'], PASSWORD_BCRYPT));
	$NewHash = $mysqli->escape_string(md5(rand(0,1000)));
	// Comprobar si el usuario con ese numero de documento si existe
   	$validarUsuario = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$Documento' AND contraseña = '$Pass' AND hash = '$Hash'") or die($mysqli->error());
  	// Sabemos que el usuario ya existe si las filas devueltas son más de 0
  	if ( $validarUsuario->num_rows > 0 ) 
  	{                           
		$UsuarioV = $validarUsuario->fetch_assoc();
      	if (password_verify($_POST['Contraseña'], $UsuarioV['contraseña']))
      	{
	        $_SESSION['message'] = '<div class="row">
	                                	<div class="col s12 center-align">
		                                  	<div class="valign-wrapper">
				                                <div class="col s12 alertaError">
				                                    <p class="center"><b>¡Ha ingresado la contraseña actual!</b></p>
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
      	else
      	{
			//Observar que la contraseña no sea la misma
			// procedemos a actualizar los datos
	  		$ActivarUsuario = "UPDATE LogIn SET  telefono = '$Telefono', contraseña = '$Password', hash = '$NewHash', activo = 1 WHERE idUsuario = '$Documento' AND contraseña = '$Pass' AND hash = '$Hash'";
	  		// Agregar usuario a la base de datos
	  		if ( $mysqli->query($ActivarUsuario) )
	  		{
	  			$ActualizarLogIn = $mysqli->query("UPDATE LogIn SET actualizacion = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
	  			$ActualizarUser = $mysqli->query("UPDATE Usuario SET registro = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
	  			$_SESSION['message'] = '<div class="row">
		                                	<div class="col s12 center-align">
			                                  	<div class="valign-wrapper">
						                           <div class="col s12 mensaje">
						                              	<p class="center"><b>¡Gracias '.$nombre.'!</b><br>Tu cuenta ha sido activada correctamente y la seguridad de tu cuenta actualizada.<br> Ahora podrás acceder a todas las funciones del sitio.</p>
						                           </div>
						                        </div>
			                                </div>
		                              	</div>
		                              	<div class="row">
			                                <div class="col s12 center-align">
			                                    <a href="perfil.php">
			                                        <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
			                                            <i class="material-icons left">account_circle</i><b>Ver Perfil</b>
			                                        </button>
			                                    </a>
			                                </div>
			                            </div>';            		
	        	header("location: activar-cuenta.php"); 
	  		}
	  		else
	        {
	      		$_SESSION['message'] = '<div class="row">
		                                	<div class="col s12 center-align">
			                                  	<div class="valign-wrapper">
					                                <div class="col s12 alertaError">
					                                    <p class="center"><b>¡La activación de la cuenta ha fallado!</b></p>
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
	else
	{
		$_SESSION['message'] = '<div class="row">
	                                <div class="col s12 center-align">
	                                  	<div class="valign-wrapper">
			                                <div class="col s12 alertaError">
			                                    <p class="center"><b>¡Activación fallida!</b><br>¡El usuario con este Número de identificación no existe!<br>No sabemos como llegó hasta aquí...</p>
			                                </div>
			                            </div>
	                                </div>
	                            </div>
								<div class="row">
								  	<div class="col s12 center-align">
								      	<a href="javascript:history.go(-1)">
								          	<button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
								              	<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
								          	</button>
								      	</a>
								  	</div>
								</div>';
      	header("location: error.php");
	}