<?php
	//On commence une session
	session_start();

	//Les paramètres de connexion
	$DB_host = "localhost";
	$DB_user = "root";
	$DB_pass = "";
	$DB_name = "pfe_isetbz";

	try {
		//ON crée une nouvelle connexion
		$DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	//avec chaque nouvelle connexion
	// On fait appel à la classe user
	include 'user.class.php';
	include 'inscri.class.php';
	// puis on crée un nouvel utilisateur
	// en insanciant la classe user avec la connexion déjà créée ($DB_con)
	$user = new USER($DB_con);
	$inscription = new inscription($DB_con);

?>
