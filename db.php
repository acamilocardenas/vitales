<?php
/*Configuración de conecxión a base de datos*/
$Host = 'localhost';
$Usuario = 'programa_root';
$pass = 'dKAsnol}-C_~';
$BaseDeDatos = 'programa_vitales';
$mysqli = new mysqli($Host, $Usuario, $pass, $BaseDeDatos) or die($mysqli->error);
$mysqli->query("SET NAMES 'utf8'");
