<?php
  /* Cierre el proceso, desactiva y destruye las variables de sesión */
  session_start();
  session_unset();
  session_destroy(); 
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
   <title>Cerrando sesión | Programa Vitales </title>
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

<div class="container error">
  <div class="row">
    <div class="col s12 m9 l6 animate__animated animate__fadeIn animate__dalay-1s">
      <div class="row z-depth-2">
        <ul class="tabs tabs-formulario">
                    <li class="tab col s12">
                        <a class="active">
                            <b>
                                <i class="material-icons" style="position: absolute; left: calc(50% - 115px); ">power</i>Gracias por visitarnos
                            </b>
                        </a>
                    </li>
                </ul>
        <div  class="row white col s12 center-align">
          <div class="row sessionMessage">
            <div class="row">
              <div class="col s12 center-align">
                  <div class="valign-wrapper">
                  <div class="col s12 alerta">
                      <p class="center"><b>¡Has sido desconectado!</b><br>Para seguir navegando en programa vitales, debes iniciar sección nuevamente</p>
                  </div>
              </div>
              </div>
            </div>
            <div class="row">
                <div class="col s12 center-align">
                  <a href="index.php"class="modelica-bold waves-effect waves-light btn-large hoverable blue darken-3"><i class="material-icons left">home</i>Volver a vitales</a>
                </div>
            </div>
          </div>
        </div>
          <?php 
            include 'componentes/footer.php'; // Incluir footer
          ?>
      </div>
    </div>
  </div>
</div>

<!-- barra de navegacion -->
<div class="row">
  <nav class="header valign-wrapper navOff">
    <div class="nav-wrapper" style="width: 100%;">
      <a href="#!" id="title">Programa Vitales</a>
      <ul id="nav-mobile" class="left" style="left: 10px; margin-right: 0px;">
      <li style="width: 40px; text-align: center;"><a href="javascript:history.go(-1)" style="font-size: 16px; padding: 0px;"><i class="material-icons center">arrow_back</i></a></li>
      </ul>
    </div>
  </nav>
</div>
    

</body>
</html>
<?php
    ob_end_flush();
?>