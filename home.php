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
    <h1 class="display-4 text-center">Upload Students List page</h1>
    <p class="lead">This page allows an upload of the students's list to the PFE-ISET Bizerte application's Data Base. The supported file's formats are only CSV and JSON.<br/> To convert your CSV file to a valid JSON file or vice versa check this <a href="http://www.csvjson.com/csv2json">link</a>.</p>
  </div>
</div>
<!-- jumbotron end -->
<?php
if(!empty($_GET)){
  if($_GET['insertOk']== 1){
    ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Students list uploaded in the DB. users names are <strong>emails</strong> and passwords are <strong>CIN numbers</strong>.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <br/>    
    <?php
  }
}
        $typeFileErr='';
        $uploadOk = 0;
        if (!empty($_POST)){
          $target_dir = "./files/";
          $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
          //Check the file extension
          $jsonFileType = pathinfo($target_file,PATHINFO_EXTENSION);
          if ($jsonFileType !='json')
            $typeFileErr = 'Type de fichier invalide !';
          else $uploadOk = 1;
        // Check if file already exists
        if (file_exists($target_file)) {
          $target_file = substr_replace($target_file, mt_rand(), strlen($target_file)-5, 0);
          }
        }
        ?>
<form method="post" action="" enctype="multipart/form-data">
  <div class="form-group row">
    <label for="inputJSONFile" class="col-sm-2 col-form-label">File</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" name="fileToUpload" id="inputJSONFile" placeholder="JSON File" required>
      <span class="text-danger"><?php echo $typeFileErr;?></span>
    </div>
  </div>
  <!-- <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-legend col-sm-2">Type</legend>
      <div class="col-sm-10">
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="fileType" id="jsonFile" value="json" checked>
            JSON
          </label>
        </div>
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" type="radio" name="fileType" id="csvFile" value="csv">
            CSV
          </label>
        </div>
      </div>
    </div>
  </fieldset> -->
  <div class="form-group row">
    <label for="inputYear" class="col-sm-2 col-form-label">Year</label>
    <div class="col-sm-10">
      <input type="Text" class="form-control" name="year" id="inputYear" value="<?php if(date('n')>6) echo date('Y').'/'.(date('Y')+1); else echo (date('Y')-1).'/'.date('Y');?>" required>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Start Reading File</button>
      <button type="reset" class="btn btn-dark">Abort !</button>
    </div>
  </div>
</form>
<?php
        if ($uploadOk == 1){
          // Copy uploaded file to the targer directory
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $cookie_name = "target_file";
            $cookie_value = $target_file;
            setcookie($cookie_name, $cookie_value, time()+86400, "/");
            header('Location:readFile.php');
          }
        }
?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
