<?php
	#formulario de actualizar información
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: text/html; charset=UTF-8');
    ob_start();
    require 'db.php';
    session_start();

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
    
    //recibo datos desde ajax
    // Escapar de todas las variables de $_POST para protegerse de las inyecciones SQL
    $Form = $mysqli->escape_string($_POST['Form']);
    $Documento = $mysqli->escape_string($_POST['Documento']);

	if($Form == 'Nombre') {
		//Datos Actualizar Nombre
	    $Nombre = $mysqli->escape_string($_POST['Nombre']);
		$Apellido = $mysqli->escape_string($_POST['Apellido']);
		// procedemos a actualizar los datos
		$ActualizarNombre = "UPDATE Usuario SET nombre = '$Nombre', apellido = '$Apellido' WHERE idUsuario = '$Documento'";
  		if ( $mysqli->query($ActualizarNombre) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;   
        }
	}
	else if($Form == 'FechaNacimiento') {
		//Datos Actualizar Fecha Nacimiento
		$Nacimiento = $mysqli->escape_string($_POST['Nacimiento']);
		$ConvertirNac = explode(" ", $Nacimiento);
		$DiaNac = $ConvertirNac[0];
		$MesNac = (string)$ConvertirNac[1];
		$AñoNac = $ConvertirNac[2];
		$MesNacForm = ConvertMes($MesNac);
		$FechaNac = (($AñoNac.'-'.$MesNacForm.'-'.$DiaNac));
		// procedemos a actualizar los datos
		$ActualizarNacimiento = "UPDATE Usuario SET fechaNacimiento = '$FechaNac' WHERE idUsuario = '$Documento'";
  		if ( $mysqli->query($ActualizarNacimiento) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;   
        }
	} else if($Form == 'RH') {
		//Datos Actualizar Nombre
	    $RH = $mysqli->escape_string($_POST['RH']);
		// procedemos a actualizar los datos
		$ActualizarRH = "UPDATE Usuario SET idRH = '$RH' WHERE idUsuario = '$Documento'";
  		if ( $mysqli->query($ActualizarRH) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if($Form == 'Foto') {
		//Datos Actualizar Nombre
	    $Foto = $mysqli->escape_string($_POST['Foto']);
		// procedemos a actualizar los datos
		$ActualizarFoto = "UPDATE Usuario SET fotoPerfil = '$Foto' WHERE idUsuario = '$Documento'";
  		if ( $mysqli->query($ActualizarFoto) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if ($Form == 'LicenciaUpdate') {
		//Datos Actualizar licencia
		$LicenciaOld = $mysqli->escape_string($_POST['LicenciaOld']);
        $ExpedicionOld = $mysqli->escape_string($_POST['ExpedicionOld']);
        $LicenciaNew = $mysqli->escape_string($_POST['LicenciaNew']);
        $ExpedicionNew = $mysqli->escape_string($_POST['ExpedicionNew']);
        // procedemos a actualizar los datos
		$ActualizarLic = "UPDATE Licencia_Usuario SET idCategoria = '$LicenciaNew', fechaExpedicion = '$ExpedicionNew'  WHERE idUsuario = '$Documento' AND idCategoria = '$LicenciaOld' AND fechaExpedicion = '$ExpedicionOld' ";
  		if ( $mysqli->query($ActualizarLic) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if ($Form == 'LicenciaDelete') {
		//Datos Eliminar licencia
		$Licencia = $mysqli->escape_string($_POST['Licencia']);
        $Expedicion = $mysqli->escape_string($_POST['Expedicion']);
        // procedemos a eliminar los datos
		$EliminarLic = "DELETE FROM Licencia_Usuario WHERE idUsuario = '$Documento' AND idCategoria = '$Licencia' AND fechaExpedicion = '$Expedicion' ";
  		if ( $mysqli->query($EliminarLic) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if ($Form == 'LicenciaAdd') {
		//Datos añadir licencia
		$Licencia = $mysqli->escape_string($_POST['Licencia']);
        $Expedicion = $mysqli->escape_string($_POST['Expedicion']);
        // procedemos a eliminar los datos
		$InsertarLic = "INSERT INTO Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)" 
	                   				."VALUES ('$Documento','$Licencia','$Expedicion')";
  		if ( $mysqli->query($InsertarLic) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	}  else if($Form == 'Telefono') {
		//Datos Actualizar Telefono
	    $Telefono = $mysqli->escape_string($_POST['Telefono']);
		// procedemos a actualizar los datos
		$ActualizarTelefono = "UPDATE LogIn SET telefono = '$Telefono' WHERE idUsuario = '$Documento'";
  		if ( $mysqli->query($ActualizarTelefono) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if($Form == 'Verificar') {
		
		// procedemos a buscar usuario
		$Consulta = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$Documento'");
  		if ( $Consulta->num_rows > 0 )
  		{
  			//Usuario encontrado
  			//vericar contraseña
  			$Usuario = $Consulta->fetch_assoc();
		    if ( password_verify($_POST['Contraseña'], $Usuario['contraseña']))
		    {
		    	$result = 2;
		    }
		    else
		    {
		    	$result = 3;
		    }          		
  		}
  		else
        {
        	//Usuario no encontrado
      		$result = 0;
        }
	} else if($Form == 'Contraseña') {
		//verificar que no sea la misma contraseña
		$Consulta = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$Documento'");
		$Usuario = $Consulta->fetch_assoc();
		if (password_verify($_POST['Contraseña'], $Usuario['contraseña']))
		{
			//Las contraseñas son identicas
			$result = 4;
		}
		else
		{
			$Contraseña = password_hash($_POST['Contraseña'], PASSWORD_BCRYPT);
	      	$Hash = $mysqli->escape_string(md5(rand(0,1000)));

	      	$ActualizarPass = ("UPDATE LogIn SET contraseña = '$Contraseña', hash = '$Hash' WHERE idUsuario = '$Documento'");
	      	if ( $mysqli->query($ActualizarPass) )
		    {
		    	$Actualizar = $mysqli->query("UPDATE LogIn SET actualizacion = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
		    	//actualización exitosa
	  			$result = 1; 
		    }
		    else
		    {
		    	//actualización fail
	      		$result = 0;
		    }
		}	
	} else if($Form == 'DeleteSancion') {
		//Datos eliminar historial
		$Norma = $mysqli->escape_string($_POST['Norma']);
    	$Evaluador = $mysqli->escape_string($_POST['Evaluador']);
    	$Infraccion = $mysqli->escape_string($_POST['Infraccion']);
    	$Registro = $mysqli->escape_string($_POST['Registro']);

		// procedemos a eliminar historial
		$EliminarHistorial = "DELETE FROM Historial WHERE idUsuario = '$Documento' AND idNorma = '$Norma' AND idEvaluador = '$Evaluador' AND fechaInfraccion = '$Infraccion' AND DATE_FORMAT(registro, '%Y-%m-%d') = '$Registro'";
  		if ( $mysqli->query($EliminarHistorial) )
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if($Form == 'AddSancion') {
		//Datos eliminar historial
		$Norma = $mysqli->escape_string($_POST['Norma']);
    	$Evaluador = $mysqli->escape_string($_POST['Evaluador']);
    	$Infraccion = $mysqli->escape_string($_POST['Infraccion']);

		// procedemos a eliminar historial
		$AddHistorial = "INSERT INTO Historial (idUsuario, idNorma,  idEvaluador, fechaInfraccion)" 
	                   				."VALUES ('$Documento', '$Norma', '$Evaluador', '$Infraccion')";
  		if ($mysqli->query($AddHistorial))
  		{
  			//actualización exitosa
  			$result = 1;            		
  		}
  		else
        {
        	//actualización fail
      		$result = 0;
        }
	} else if($Form == 'UpdateEstado') {
		//Datos actualizar estado
    	$Hash = $mysqli->escape_string($_POST['Hash']);
    	$Estado = $mysqli->escape_string($_POST['Estado']);

		// procedemos a actualizar el estado
		$ActualizarEstado = ("UPDATE LogIn SET estado = '$Estado' WHERE idUsuario = '$Documento' AND hash = '$Hash'");
      	if ( $mysqli->query($ActualizarEstado) )
	    {
	    	$Actualizar = $mysqli->query("UPDATE LogIn SET actualizacion = now() WHERE idUsuario = '$Documento'") or die($mysqli->error());
	    	//actualización exitosa
  			$result = 1; 
	    }
	    else
	    {
	    	//actualización fail
      		$result = 0;
	    }
	}
	//envio resultados a la app
	echo utf8_encode($result);
	$mysqli->close();
	ob_end_flush();
?>