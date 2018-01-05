<?php
    require 'class/db_conf.php';
    
    //get the name of the file from the POST request
    if (!empty($_POST)){
        $Listfile = $_POST['filename'];
    } else{
        $Listfile = 'empty';
    }


    //create a new recursive iterator to parse the JSON file
    $json = file_get_contents($Listfile);
    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($json, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

        $userInsert = 0;
        $inscriptionInsert = 0;

    foreach ($jsonIterator as $key => $val) {
        if(is_array($val)) {
            
            //insert users
            if ($user->addUser($val['ncin'],$val['email'],$val['email'],$val['nom'],$val['ncin'],$val['prenom'],$val['tel'])) $userInsert+=1;            
            
            //get user ID
            $id_Etud = $user->getUserID($val['ncin']);            
            echo $id_Etud;

            //insert inscriptions
            if ($inscription->InsertNewInscription($val['classe'],$id_Etud)) $inscriptionInsert+=1;            
            
        }
    }            
        header('Location: home.php?insertOk=1');        

        // $array = ['list' => 'Upload Done successfuly !'];
        // echo json_encode($array);
    
?>