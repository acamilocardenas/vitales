<!-- Página principal con dos formularios registrarse e iniciar seción -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <link rel="icon" type="image/png" href="img/logo.png"/>
    <title>Programa Vitales | Norgas</title>
    <?php 
        include 'componentes/librerias.php'; // Incluir archivos js y css
    ?>
</head>

<body>
    <!-- fondo del sitio -->
    <section class="fondo animate__animated animate__fadeIn animate__slower">
        <div class="patron1"></div>
        <div class="camion ancho">
           <div class="patron2"></div>
        </div>
    </section>

    <!-- pantalla home -->
    <?php 
        include 'componentes/home.php'; // Incluir pantalla del home o bienvenida
    ?>    

</body>
</html>