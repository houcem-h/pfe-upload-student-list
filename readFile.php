<?php

	require 'class/db_conf.php';

	//Si l'utilisateur n'est pas connecté on le redirige vers la page de connexion
	if(!$user->is_loggedin()) {
		$user->redirect('index.php');
	}
	//On récupère les données de l'utilisateur à partir de son id (depuis la session)
	$user_id = $_SESSION['user_session'];
	$req = $DB_con->prepare("SELECT * FROM users WHERE login=:user_id");
	$req->execute(array(":user_id"=>$user_id));
	$ligne=$req->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <title>PFE - ISET Bizerte</title>
    <script src="auth/js/myScripts.js"></script>
    
</head>
<body>
<div class="container">
<!-- Navbar start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<span class="navbar-brand mb-0 h1">PFE - ISET Bizerte</span>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav">
<li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
  </li>
  <li class="nav-item">
        <a class="nav-link" href="https://pfe.isetbz.ovh/">PFE site</a>
  </li>
  </ul>
  <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
<li class="nav-item dropdown">
      <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $ligne['PRENOM'].' '.$ligne['NOM']; ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
      <a class="dropdown-item" href="auth/logout.php">Logout</a>
    </div>
    </li>
    </ul>
    </div>
</nav>
<!-- Navbar end -->
<!-- jumbotron start -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-6 text-center">Students list from the file</h1>
            <p class="text-center">If every thing is OK, click the start the upload button bellow.</p>
        </div>
    </div>
<!-- jumbotron end -->

<form action="startUpload.php" method="post">
  <button type="submit" id="startUpload" class="btn btn-outline-success btn-lg btn-block">Start the upload to the DB</button>
  <input type="hidden" name="filename" value="<?php echo $_COOKIE['target_file'] ?>">
</form>
<br/>
<?php
$json = file_get_contents($_COOKIE['target_file']);
$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);
?>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <?php
      foreach ($jsonIterator as $key => $val) {
        foreach ($val as $Colsnames => $RowsContent)
          echo '<th scope="col">'.$Colsnames.'</th>';
        if(is_array($val) and $val > 0)
          break;
        }
      ?>
    </tr>
  </thead>
  <tbody>
<?php
        foreach ($jsonIterator as $key => $val) {            
            if(is_array($val)) {
                echo '</tr><tr><th scope="row">'.$key.'</th>';
            } else {                
                echo '<td>'.$val.'</td>';
            }
        }
?>

  </tbody>
</table>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
