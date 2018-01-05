<?php
	class inscription {
		private $db;	//variable de connexion à la base de données

		//constructeur permettant d’affecter une connexion à un utilisateur
		function __construct($DB_con)
		{
		  $this->db = $DB_con;
        }

        private function getStudentClass($classe){
            try{                
                $ClassID = $this->db->prepare("SELECT * FROM classe WHERE label=:label_class");
                $ClassID->execute(array(":label_class"=>$classe));
                $ligne=$ClassID->fetch(PDO::FETCH_ASSOC);
                return $ligne['id'];
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function InsertNewInscription($classe,$id_Etud){
            try{
                $classID = $this->getStudentClass($classe);
                $reqInsert2 = $this->db->prepare("INSERT INTO inscriptions (annee_universitaire,date_creation,date_modificator,classe,etudiant) VALUES (:annee_universitaire,:date_creation,:date_modificator,:classe,:etudiant)");                
                if ($reqInsert2->execute(array(":annee_universitaire"=>3,":date_creation"=>date('Y-m-d H:i:s'),":date_modificator"=>date('Y-m-d H:i:s'),":classe"=>$classID,":etudiant"=>$id_Etud))) echo $id_Etud.' inséré avec succées<br>';
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

    }
    
?>