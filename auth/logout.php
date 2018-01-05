<?php

	require '../class/db_conf.php';
	//Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion
	if(!$user->is_loggedin()) {
		$user->redirect('../index.php');
	}

	//On déconnecte l'utilisateur
	$user->logout();
	//Puis on le redirige vers la page de connexion
	$user->redirect('../index.php');
?>
