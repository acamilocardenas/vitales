<?php
	//Proceso verificar usuario para cambiar contraseña.
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
	// Escapar  Documento de $_POST para protegerse de las inyecciones SQL

   // Datos personales
	$Documento = $mysqli->escape_string($_POST['Documento']);
	$consulta = $mysqli->query("SELECT U.idUsuario AS idUsuario, U.fechaNacimiento AS fechaNacimiento, RH.nombreRH AS RH, L.telefono AS telefono, L.hash AS hash FROM Usuario AS U INNER JOIN RH AS RH ON U.idRH = RH.idRH INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario WHERE U.idUsuario = '$Documento'");

	if ( $consulta->num_rows == 0 )
	{ 
		// El usuario no existe
    	$_SESSION['message'] = '<div class="row">
                                <div class="col s12 center-align">
                                  	<div class="valign-wrapper">
		                                <div class="col s12 alertaError">
		                                    <p class="center"><b>¡Validación incorrecta!</b><br>El usuario con este número de doumento no existe.<br>!Registrate o inténtalo de nuevo!</p>
		                                </div>
		                            </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col s12 center-align">
                                      <a href="verificar-cuenta.php">
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
		// Escapar  el resto de los datos de $_POST para protegerse de las inyecciones SQL
		$Nacimiento = $mysqli->escape_string($_POST['Nacimiento']);
		$ConvertirNac = explode(" ", $Nacimiento);
		$DiaNac = $ConvertirNac[0];
		$MesNac = (string)$ConvertirNac[1];
		$MesNacForm = ConvertMes($MesNac);
		$AñoNac = $ConvertirNac[2];
		$FechaNac = (($AñoNac.'-'.$MesNacForm.'-'.$DiaNac));
		$Rh = $mysqli->escape_string($_POST['Rh']);
		$Telefono = $mysqli->escape_string($_POST['Telefono']);

	    $usuario = $consulta->fetch_assoc();
	    $hash = $usuario['hash'];
	    if ( $FechaNac != $usuario['fechaNacimiento'] )
	    {
	    	// fecha mal
	    	$_SESSION['message'] = '<div class="row">
	                                <div class="col s12 center-align">
	                                  	<div class="valign-wrapper">
			                                <div class="col s12 alertaError">
			                                    <p class="center"><b>¡Validación incorrecta!</b><br>La información suministrada no coincide<br>!Inténtalo de nuevo!</p>
			                                </div>
			                            </div>
	                                </div>
	                              </div>
	                              <div class="row">
	                                  <div class="col s12 center-align">
	                                      <a href="verificar-cuenta.php">
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
	    	if ($Rh != $usuario['RH'])
	    	{
	    		// RH mal
		    	$_SESSION['message'] = '<div class="row">
		                                <div class="col s12 center-align">
		                                  	<div class="valign-wrapper">
				                                <div class="col s12 alertaError">
				                                    <p class="center"><b>¡Validación incorrecta!</b><br>La información suministrada no coincide<br>!Inténtalo de nuevo!</p>
				                                </div>
				                            </div>
		                                </div>
		                              </div>
		                              <div class="row">
		                                  <div class="col s12 center-align">
		                                      <a href="verificar-cuenta.php">
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
	    		if ($Telefono != $usuario['telefono'])
	    		{
	    			// Telefono mal
			    	$_SESSION['message'] = '<div class="row">
			                                <div class="col s12 center-align">
			                                  	<div class="valign-wrapper">
					                                <div class="col s12 alertaError">
					                                    <p class="center"><b>¡Validación incorrecta!</b><br>La información suministrada no coincide<br>!Inténtalo de nuevo!</p>
					                                </div>
					                            </div>
			                                </div>
			                              </div>
			                              <div class="row">
			                                  <div class="col s12 center-align">
			                                      <a href="verificar-cuenta.php">
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
	    			header("location: password.php?documento=$Documento&hash=$hash");
	    		}
	    	}
	    }
	}