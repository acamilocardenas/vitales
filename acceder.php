<?php 
    // Página principal con dos formularios registrarse e iniciar seción
    ob_start();
    require 'db.php';
    session_start();
    $_SESSION['Usuario_on'] = 0;
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
    <title>Programa Vitales | Acceder</title>
    <?php 
        include 'componentes/librerias.php'; // Incluir archivos js y css
    ?>
    <script type="text/javascript" src="js/validarFormularioLogin.js"></script>
</head>

<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['Entrar'])) 
        { 
            require 'login.php';//Inicio de sesión de usuario
        }
    }
?>

<body>
    <!-- fondo del sitio -->
    <section class="fondo animate__animated animate__fadeIn animate__slower">
        <div class="patron1"></div>
        <div class="camion ancho">
           <div class="patron2"></div>
        </div>
    </section>

    <!-- pantalla login -->
    <?php 
        include 'componentes/formularioLogin.php'; // Incluir formulario de login
    ?>
    <?php 
        include 'componentes/pop-up.php'; // Incluir pop-up
    ?>
    

</body>
</html>
<?php
    ob_end_flush();
?>