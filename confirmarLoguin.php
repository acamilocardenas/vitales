<?php
    header('Access-Control-Allow-Origin: *');
	header('Content-Type: text/html; charset=UTF-8');
    ob_start();
    require 'db.php';
    session_start();
    
    //recibo datos de la app
    $Documento = $mysqli->escape_string($_POST['Documento']);
	$Contraseña= $mysqli->escape_string($_POST['Contrasena']);
	
	$consulta = $mysqli->query("SELECT * FROM LogIn WHERE idUsuario = '$Documento'");
	
	if ( $consulta->num_rows == 0 )
	{ 
		// El usuario no existe
    	$result = 0;
	}
	else
	{ 
		// El usuario si existe
	    $usuario = $consulta -> fetch_assoc();
	    //verificar contraseña
	    if (password_verify($Contraseña, $usuario['contraseña']))
	    {
	    	$result = 1;
	    }
	    else
	    {
	    	$result = 0;
	    }
	}
	//envio resultados a la app
	echo utf8_encode($result);
	$mysqli->close();
	ob_end_flush();
?>