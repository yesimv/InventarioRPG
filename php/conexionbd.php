<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "sistemainventario";

	$conn = new mysqli($host,$user,$pass,$db);

	if (!$conn) {
		echo "Error en la conexión";
	}
?> 