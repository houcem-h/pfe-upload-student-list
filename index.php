<?php

	require 'class/db_conf.php';
	//Si l'utilisateur est déjà connecté on le redirige vers la page d'accueil
	if($user->is_loggedin()!="") {
		$user->redirect('./home.php');
	}
	if(!empty($_POST)) {
		//récupération des informations du formulaire
		$uname = $_POST['login'];
		$upass = $_POST['pwd'];

		//On essaie de connecter l'utilisateur
 		if ($user->login($uname,$upass))  {
			//Si les inforamtions sont correctes
			// alors son id sera ajouté dans la session
			// puis on le rederige vers la page d'accueil
			$user->redirect('home.php');
 		} else  {
			//Si les informations sont erronées
			// on crée la variable $error qui sera affichée en bas
			$error = "informations erronées !";
 		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PFE - ISET Bizerte</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="./auth/css/style.css" type="text/css"  />
</head>
<body>
<div class="signin-form">

	<div class="container">


       <form class="form-signin" method="post" id="login-form">

        <h2 class="form-signin-heading">Authentification</h2><hr />

        <div id="error">
        <?php
			//Si la variable $error existe on l'affiche
			if(isset($error))
			{
				?>
                <div class="alert alert-danger">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                </div>
                <?php
			}
		?>
        </div>

        <div class="form-group">
        <input type="text" class="form-control" name="login" placeholder="username" required />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="password" />
        </div>
     	<hr />
        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-default"> Login! </button>
        </div>
      	<!-- <br />
            <label>Vous n'avez pas un compte ! <a href="sign-up.php">Inscription</a></label> -->
      </form>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
