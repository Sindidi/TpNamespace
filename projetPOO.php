<?php 

	require 'index.php';

	use location\dao\Bien;
	use location\dao\gestionBien;

	 $db = new PDO('mysql:host=localhost;dbname=BDLocation', 'root', 'passer');
	 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	 $gestion = new gestionBien($db);

	 $gestion->find("zale");


?>