<?php
require '../db.php';
	for ($i=0; $i <= 7; $i++) { 
		$Hash = $mysqli->escape_string(md5(rand(0,1000)));
		echo $Hash. "<br>";
	}