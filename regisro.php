<?php
	//Proceso de registro, inserta la informacion del usuario a la db programa_vitale
	function ConvertMes($MesNac) {
	  	switch ($MesNac) {
			case 'Enero,':
				return '01';
				break;       
			case 'Febrero,':
				return '02';
				break;  
			case 'Marzo,':
				return '03';
				break; 
			case 'Abril,':
				return '04';
				break;
			case 'Mayo,':
				return '05';
				break;    
			case 'Junio,':
				return '06';
				break;  
			case 'Julio,':
				return '07';
				break;
			case 'Agosto,':
				return '08';
				break;
			case 'Septiembre,':
				return '09';
				break;    
			case 'Octubre,':
				return '10';
				break;  
			case 'Noviembre,':
				return '11';
				break;     
			case 'Diciembre,':
				return '12';
				break;   
			default:
				break;
	  	}
	}
	// Escapar de todas las variables de $_POST para protegerse de las inyecciones SQL

   // Datos personales
	$Nombre = $mysqli->escape_string($_POST['Nombre']);  
	$Apellido = $mysqli->escape_string($_POST['Apellido']);
	$Nacimiento = $mysqli->escape_string($_POST['Nacimiento']);
	$ConvertirNac = explode(" ", $Nacimiento);
	$DiaNac = $ConvertirNac[0];
	$MesNac = (string)$ConvertirNac[1];
	$MesNacForm = ConvertMes($MesNac);
	$AñoNac = $ConvertirNac[2];
	$FechaNac = (($AñoNac.'-'.$MesNacForm.'-'.$DiaNac));
	$Documento = $mysqli->escape_string($_POST['Documento']);
	$Rh = $mysqli->escape_string($_POST['Rh']);

	// Datos foto de perfil
	$Foto = $mysqli->escape_string($_POST['fotoBase64']);

	// Datos licencia Uno
	$Licencia1 = $mysqli->escape_string($_POST['LicenciaUno']);
	$Expedicion1 = $mysqli->escape_string($_POST['ExpedicionUno']);
	$ConvertirExp1 = explode(" ", $Expedicion1);
	$DiaExp1 = $ConvertirExp1[0];
	$MesExp1 = (string)$ConvertirExp1[1];
	$MesExForm1 = ConvertMes($MesExp1);
	$AñoExp1 = $ConvertirExp1[2];
	$FechaExp1 = (($AñoExp1.'-'.$MesExForm1.'-'.$DiaExp1));

	//Datos de seguridad
	$Telefono = $mysqli->escape_string($_POST['Telefono']);
	$Password = $mysqli->escape_string(password_hash($_POST['Contraseña'], PASSWORD_BCRYPT));
	$Hash = $mysqli->escape_string(md5(rand(0,1000)));

	// Comprobar si el usuario con ese numero de documento ya existe
   	$validarUsuario = $mysqli->query("SELECT idUsuario FROM Usuario WHERE idUsuario ='$Documento'") or die($mysqli->error());
  	// Sabemos que el usuario ya existe si las filas devueltas son más de 0
  	if ( $validarUsuario->num_rows > 0 ) 
  	{                       
      	$_SESSION['message'] = '<div class="row">
	                                <div class="col s12 center-align">
	                                  	<div class="valign-wrapper">
			                                <div class="col s12 alertaError">
			                                    <p class="center"><b>¡Registro fallido!</b><br>¡El usuario con este Número de identificación ya existe!</p>
			                                </div>
			                            </div>
	                                </div>
	                            </div>
								<div class="row">
								  	<div class="col s12 center-align">
								      	<a href="regisro.php">
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
		// procedemos a guardar usuario
  		$NewUsuario = "INSERT INTO Usuario (idUsuario, nombre, apellido, fechaNacimiento, idRH, fotoPerfil)" 
                   ."VALUES ('$Documento', '$Nombre', '$Apellido', '$FechaNac', '$Rh', '$Foto')";
  		// Agregar usuario a la base de datos
  		if ( $mysqli->query($NewUsuario) )
  		{	
  			$LogIn = "INSERT INTO LogIn (idUsuario, telefono, contraseña, hash, activo)" 
                    ."VALUES ('$Documento','$Telefono', '$Password', '$Hash', 1)";
            // Agregar login a la base de datos       
            if ( $mysqli->query($LogIn) )
	        {
	        	$registrarLicenciaUno = "INSERT INTO Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)" 
	                   				."VALUES ('$Documento','$Licencia1','$FechaExp1')";
                // Agregar licencia 1 a la base de datos
               if ( $mysqli->query($registrarLicenciaUno) )
               {
               		// Datos licencia Dos
					if(isset($_POST['LicenciaDos']))
					{
						$Licencia2 = $mysqli->escape_string($_POST['LicenciaDos']);
						$Expedicion2 = $mysqli->escape_string($_POST['ExpedicionDos']);
						$ConvertirExp2 = explode(" ", $Expedicion2);
						$DiaExp2 = $ConvertirExp2[0];
						$MesExp2 = (string)$ConvertirExp2[1];
						$MesExForm2 = ConvertMes($MesExp2);
						$AñoExp2 = $ConvertirExp2[2];
						$FechaExp2 = (($AñoExp2.'-'.$MesExForm2.'-'.$DiaExp2));

						$registrarLicenciaDos = "INSERT INTO Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)" 
	                   						   ."VALUES ('$Documento','$Licencia2','$FechaExp2')";
		                // Agregar licencia 2 a la base de datos
		               if ( $mysqli->query($registrarLicenciaDos) === FALSE )
		               {
		               		$LimpiarUsuario = $mysqli->query("DELETE FROM Usuario WHERE idUsuario = '$Documento'") or die($mysqli->error());
               				$_SESSION['message'] = '<div class="row">
														<div class="col s12 center-align">
															<div class="valign-wrapper">
								                                <div class="col s12 alertaError">
								                                    <p class="center"><b>¡Registro fallido!</b><br>Code: Explode(Tabla Licencia_Usuario Licencia_2)</p>
								                                </div>
								                            </div>
														</div>
													</div>
													<div class="row">
														<div class="col s12 center-align">
															<a href="regisro.php">
																<button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
																	<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
																</button>
															</a>
														</div>
													</div>';
							header("location: error.php");	
		               }
					}
					// Datos licencia Tres
					if(isset($_POST['LicenciaTres']))
					{
						$Licencia3 = $mysqli->escape_string($_POST['LicenciaTres']);
						$Expedicion3 = $mysqli->escape_string($_POST['ExpedicionTres']);
						$ConvertirExp3 = explode(" ", $Expedicion3);
						$DiaExp3 = $ConvertirExp3[0];
						$MesExp3 = (string)$ConvertirExp3[1];
						$MesExForm3 = ConvertMes($MesExp3);
						$AñoExp3 = $ConvertirExp3[2];
						$FechaExp3 = (($AñoExp3.'-'.$MesExForm3.'-'.$DiaExp3));

						$registrarLicenciaTres = "INSERT INTO Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)" 
	                   						   ."VALUES ('$Documento','$Licencia3','$FechaExp3')";
	                   	// Agregar licencia 3 a la base de datos
		               if ( $mysqli->query($registrarLicenciaTres) === FALSE )
		               {
		               		$LimpiarUsuario = $mysqli->query("DELETE FROM Usuario WHERE idUsuario = '$Documento'") or die($mysqli->error());
               				$_SESSION['message'] = '<div class="row">
														<div class="col s12 center-align">
															<div class="valign-wrapper">
								                                <div class="col s12 alertaError">
								                                    <p class="center"><b>¡Registro fallido!</b><br>Code: Explode(Tabla Licencia_Usuario Licencia_3)</p>
								                                </div>
								                            </div>
														</div>
													</div>
													<div class="row">
														<div class="col s12 center-align">
															<a href="regisro.php">
																<button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
																	<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
																</button>
															</a>
														</div>
													</div>';
							header("location: error.php");	
		               }
					}
                  	$_SESSION['message'] = '<div class="row">
												<div class="col s12 center-align">
													<div class="valign-wrapper">
						                                <div class="col s12 mensaje">
						                                    <p class="center"><b>¡Ya eres un nuevo usuario!</b><br>ahora solo ingresa a tu cuenta iniciando sesión.</p>
						                                </div>
						                            </div>
												</div>
											</div>
											<div class="row">
												<div class="col s12 center-align">
													<div class="col s6 center-align">
													  <a href="acceder.php">
													      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
													          <i class="material-icons left">vpn_key</i><b>Inicia sesión</b>
													      </button>
													  </a>
													</div>
													<div class="col s6 center-align">
													  <a href="index.php">
													      <button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
													          <i class="material-icons left">home</i><b>Volver al inicio</b>
													      </button>
													  </a>
													</div>
												</div>
											</div>';
                  header("location: success.php");
               }
               else
               {
               		$LimpiarUsuario = $mysqli->query("DELETE FROM Usuario WHERE idUsuario = '$Documento'") or die($mysqli->error());
               		$_SESSION['message'] = '<div class="row">
													<div class="col s12 center-align">
														<div class="valign-wrapper">
							                                <div class="col s12 alertaError">
							                                    <p class="center"><b>¡Registro fallido!</b><br>Code: Explode(Tabla Licencia_Usuario Licencia_1)</p>
							                                </div>
							                            </div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 center-align">
														<a href="regisro.php">
															<button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
																<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
															</button>
														</a>
													</div>
												</div>';
					header("location: error.php");
               }
            }
            else 
            {
				$LimpiarUsuario = $mysqli->query("DELETE FROM Usuario WHERE idUsuario = '$Documento'") or die($mysqli->error());
            	$_SESSION['message'] = '<div class="row">
													<div class="col s12 center-align">
														<div class="valign-wrapper">
							                                <div class="col s12 alertaError">
							                                    <p class="center"><b>¡Registro fallido!</b><br>Code: Explode(Tabla LogIn)</p>
							                                </div>
							                            </div>
													</div>
												</div>
												<div class="row">
													<div class="col s12 center-align">
														<a href="regisro.php">
															<button class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3">
																<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
															</button>
														</a>
													</div>
												</div>';
				header("location: error.php");
            }
  		}
  		else
  		{
  			$_SESSION['message'] = '<div class="row">
												<div class="col s12 center-align">
													<div class="valign-wrapper">
						                                <div class="col s12 alertaError">
						                                    <p class="center"><b>¡Registro fallido!</b><br>Code: Explode(Tabla Usuario)</p>
						                                </div>
						                            </div>
												</div>
											</div>
											<div class="row">
												<div class="col s12 center-align">
													<a href="regisro.php">
														<button class="waves-effect waves-light btn-large hoverable blue darken-3">
															<i class="material-icons left">keyboard_backspace</i><b>Atras</b>
														</button>
													</a>
												</div>
											</div>';
			header("location: error.php");
  		}
  	}

?>