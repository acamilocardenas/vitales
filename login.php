<?php
	// Proceso de inicio de sesión del usuario, comprueba si el usuario existe y la contraseña es correcta
	// Escapar de todas las variables de $_POST para protegerse de las inyecciones SQL
	$Documento = $mysqli->escape_string($_POST['Documento']);
	$consulta = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$Documento'")or die($mysqli->error());

	if ( $consulta->num_rows == 0 )
	{ 
		// El usuario no existe
    	$_SESSION['message'] = '<div class="row">
                                <div class="col s12 center-align">
                                  	<div class="valign-wrapper">
		                                <div class="col s12 alertaError">
		                                    <p class="center"><b>¡Inicio de sección fallido!</b><br>El usuario con este número de documento no existe.<br>!Registrate o inténtalo de nuevo!</p>
		                                </div>
		                            </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col s12 center-align">
                                      <a href="acceder.php">
                                          <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
                                              <i class="material-icons left">keyboard_backspace</i><b>Atras</b>
                                          </button>
                                      </a>
                                  </div>
                              </div>';
      header("location: error.php");
	}
	else
	{ 
		// El usuario si existe
	    $usuario = $consulta->fetch_assoc();
	    if ( password_verify($_POST['Contraseña'], $usuario['contraseña']) )
	    {
	    	// verificar el estado del usuario
	    	if ( $usuario['estado'] == '0')
	    	{
	    		
	    		// El usuario tiene estado inactivo
		    	$_SESSION['message'] = '<div class="row">
                                <div class="col s12 center-align">
                                  	<div class="valign-wrapper">
		                                <div class="col s12 alerta">
		                                    <p class="center"><b>¡Inicio de sección fallido!</b><br>El usuario con este número de documento se encuentra desactivado.<br><i>!Si consideras que esto es un error, comunícate con los administradores!</i></p>
		                                </div>
		                            </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col s12 center-align">
                                      <a href="acceder.php">
                                          <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
                                              <i class="material-icons left">keyboard_backspace</i><b>Atras</b>
                                          </button>
                                      </a>
                                  </div>
                              </div>';
      		header("location: error.php");
	    	}	
	    	else if ( $usuario['activo'] == '0' )// verificar si el usuario ya esta activo
	    	{
	    		$ActualizarLog = $mysqli->query("UPDATE LogIn SET ultimoLog = now()  WHERE idUsuario = '$Documento'") or die($mysqli->error());
				$_SESSION['documneto'] = $usuario['idUsuario'];
		        // Así es como sabremos que el usuario ha iniciado sesión
	            $_SESSION['Usuario_on'] = 1;
	    		// El usuario no se encuentra activo
		    	$_SESSION['message'] = '<div class="row">
		                                <div class="col s12 center-align">
		                                  	<div class="valign-wrapper">
				                                <div class="col s12 alerta">				                            
				                                    <p class="center"><b>¡Tu cuenta no ha sido activada o se encuentra inactiva!</b><br>Intenta más tarde, si este estado persiste ponte en contacto con los administradores del Programa Vitales.</p>
				                                </div>
				                            </div>
		                                </div>
		                              </div>
		                              <div class="row">
		                                  <div class="col s12 center-align">
		                                      <a href="acceder.php">
		                                          <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
		                                               <i class="material-icons left">keyboard_backspace</i><b>Atras</b>
		                                          </button>
		                                      </a>
		                                  </div>
		                              </div>';
		      header("location: perfil.php");
	    	}
	    	else
	    	{
	    		$ActualizarLog = $mysqli->query("UPDATE LogIn SET ultimoLog = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
				$_SESSION['documneto'] = $usuario['idUsuario'];
		        // Así es como sabremos que el usuario ha iniciado sesión
	            $_SESSION['Usuario_on'] = 1;

		        header("location: perfil.php");

	    	}
	        
	    }
	    else
	    {
	    	// La contraseña es erronea
	        $_SESSION['message'] = '<div class="row">
	                                <div class="col s12 center-align">
	                                  	<div class="valign-wrapper">
			                                <div class="col s12 alertaError">
			                                    <p class="center"><b>¡Inicio de sección fallido!</b><br>Has ingresado una contraseña incorrecta.<br>¡inténtalo de nuevo!</p>
			                                </div>
			                            </div>
	                                </div>
	                              </div>
	                              <div class="row">
	                                  <div class="col s12 center-align">
	                                      <a href="acceder.php">
	                                          <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
	                                               <i class="material-icons left">keyboard_backspace</i><b>Atras</b>
	                                          </button>
	                                      </a>
	                                  </div>
	                              </div>';
	      	header("location: error.php");
	    }
	}

?>