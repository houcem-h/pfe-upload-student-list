<?php
	class user {
		private $db;	//variable de connexion à la base de données

		//constructeur permettant d’affecter une connexion à un utilisateur
		function __construct($DB_con)
		{
		  $this->db = $DB_con;
		}


		//méthode permettant de connecter l'utilisateur s'il est déjà inscrit
		public function login($uname,$upass)
		{
		   try
		   {
			  //On prépare la requête
			  $req = $this->db->prepare("SELECT * FROM users WHERE LOGIN=:uname LIMIT 1");
			  //Un autre manière de relier les valeurs réelles et les paramètres fictifs
			  $req->execute(array(':uname'=>$uname));
			  // Récupérer une ligne avec fetch
			  $ligne=$req->fetch(PDO::FETCH_ASSOC);

			  if($req->rowCount() > 0)
			  {
				 // Si l'utilisteur existe alors
				 // On vérifie son mot de passe saisie avec le hashage enregistré dans la BD
				 if(md5($upass) == $ligne['PASSWORD'])
				 {
					// Si le mot de passe est correct
					if ($ligne['admin_priv'] == 1) {
						//s'il a le privilège administrateur
						// alors on lui crée une session
						$_SESSION['user_session'] = $ligne['LOGIN'];
						return true;
					}
				 }
				 else
				 {
					return false;
				 }
			  }
		   }
		   catch(PDOException $e)
		   {
			   echo $e->getMessage();
		   }
	   }

	   public function addUser($ncin,$login,$email,$nom,$prenom,$tel){
		try{                
			$reqInsert1 = $this->db->prepare("INSERT INTO users (type,cin,date_creation,date_modificator,LOGIN,MAIL,NOM,PASSWORD,PRENOM,TEL,validated,admin_priv) VALUES (:type,:cin,:date_creation,:date_modificator,:login,:mail,:nom,:password,:prenom,:tel,:validated,:admin_priv);");
			if ($reqInsert1->execute(array(":type"=>2,":cin"=>$ncin,":date_creation"=>date('Y-m-d H:i:s'),":date_modificator"=>date('Y-m-d H:i:s'),":login"=>$login,":mail"=>$email,":nom"=>$nom,":password"=>md5($ncin),":prenom"=>$prenom,":tel"=>$tel,":validated"=>1,":admin_priv"=>0))) echo $prenom.' inséré avec succées<br>';
		}catch(PDOException $e) {
			echo $e->getMessage();
		}
	   }

	   public function getUserID($cin){
		try{                
			$UserID = $this->db->prepare("SELECT * FROM users WHERE cin=:cin");
			$UserID->execute(array(":cin"=>$cin));
			$ligne=$UserID->fetch(PDO::FETCH_ASSOC);
			return $ligne['id'];
		}catch(PDOException $e) {
			echo $e->getMessage();
		}
	   }

	//Cette méthode permet de tester si un utilisateur est connecté ou non
	public function is_loggedin() {
		//Il suffit de tester si la variable session $_SESSION['user_session'] existe ou non
		if(isset($_SESSION['user_session'])) {
				 return true;
		}
	}

	//Une méthode permettant la redirection vers une url spécifiée
	public function redirect($url) {
		header("Location: $url");
	}

	//Cette méthode permettra le déconnexion de l'utilisateur
	public function logout() {
		// Destruction de la session
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
   	}



	}

?>
