<?php
    #We obtain the data which is contained in the post url on our server.
    #Nous obtenons les données contenues dans l'url de l'article sur notre serveur.

    $sessionId   = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $text        = $_POST["text"];

    
    $ussd_string_exploded = explode("*", $text);

    // Get ussd menu level number from the gateway
    // Obtient le numéro de niveau de menu ussd de la passerelle

    $level = count($ussd_string_exploded);
    
    if ($text == "" ) {
        $response = "CON Option Insécurité à Lubumbashi \n";
        $response .= "1. Signaler un cambriolage \n";
        $response .= "2. Créer un compte \n";
    }
    else if ($text == "1") 
    {
        $data = getUser($phoneNumber);

        if ($data != null) {
            $message  = "ALERTE INSECURITE : Monsieur ".$data["nom"]." ".$data["postnom"]." ".$data["prenom"]." ";
            $message .= "vient de lancer une alerte depuis l\'avenue/rue ".$data["rue_avenue"]." N°".$data["numero"]." ";
            $message .= "au quartier ".$data["quartier"]." dans la commune de ".$data["commune"]." ";
            $message .= "dans la ville de ".$data["ville"]." dans la province ".$data["province"]." \n";
            $message .= "#Au secour police.";
            // envoyer une alerte
            sendAlert($data["id_user"], $message);

            // afficher un message de notification à l'utilisateur
            $response  = "CON Cher(e) ".$data["nom"]." ".$data["postnom"]." ".$data["prenom"]." ";
            $response .= "votre alerte est lancé depuis l'avenue/rue ".$data["rue_avenue"]." N°".$data["numero"]." ";
            $response .= "au quartier ".$data["quartier"]." dans la commune de ".$data["commune"]." ";
            $response .= "dans la ville de ".$data["ville"]." dans la province ".$data["province"].".\n";
            $response .= "Le secours vient bientôt. Soyez rassurer. \n";
            $response .= "END ";
            

        } else{
            $response = "END Veuillez vous enregistrer à notre service.";
        }
        
    }
    else if ($text == "2") 
    {
        $response = "CON Veuillez entrer votre nom. "; //1
    }
    if($ussd_string_exploded[0] == 2 && $level == 2)
    {
        $response = "CON Veuillez entrer votre postnom. "; //2
    }
    else if($ussd_string_exploded[0] == 2 && $level == 3)
    {
        $response = "CON Veuillez entrer votre prenom. "; //3
    }
    else if($ussd_string_exploded[0] == 2 && $level == 4)
    {
        $response = "CON Veuillez entrer votre genre (M/F). "; //4
    }
    else if($ussd_string_exploded[0] == 2 && $level == 5)
    {
        $response = "CON Veuillez entrer votre rue/avenue "; //5
    }
    else if($ussd_string_exploded[0] == 2 && $level == 6)
    {
        $response = "CON Veuillez entrer le numero de votre rue/avenue "; //6
    }
    else if($ussd_string_exploded[0] == 2 && $level == 7)
    {
        $response = "CON Veuillez entrer le quartier "; //7
    }
    else if($ussd_string_exploded[0] == 2 && $level == 8)
    {
        $response = "CON Veuillez entrer votre commune "; //8
    }
    else if($ussd_string_exploded[0] == 2 && $level == 9) 
    {
        $response = "CON Veuillez entrer votre ville "; //9
    }
    else if($ussd_string_exploded[0] == 2 && $level == 10)
    {
        $response = "CON Veuillez entrer votre Province "; //10
    }
    else if($ussd_string_exploded[0] == 2 && $level == 11)
    {
        $response  = "CON Cher(e) ".$ussd_string_exploded[1]." ".$ussd_string_exploded[2]." ".$ussd_string_exploded[2];
        $response .= "votre enregistrement à l'avenue/rue ".$ussd_string_exploded[5]." N°".$ussd_string_exploded[6]." ";
        $response .= "au quartier ".$ussd_string_exploded[7]." dans la commune de ".$ussd_string_exploded[8]." ";
        $response .= "dans la ville de ".$ussd_string_exploded[9]." dans la province ".$ussd_string_exploded[10].".\n";
        $response .= "Confirmez-vous toutes ces informations ?\n";
        $response .= "1.Oui ?\n";
        $response .= "2.Non ?";
    }
    else if ($ussd_string_exploded[0] == 2 && $ussd_string_exploded[11] == 1 && $level == 12) 
    {
        $data = array(            
            'nom' =>$ussd_string_exploded[1],
            'postnom' =>$ussd_string_exploded[2],
            'prenom' => $ussd_string_exploded[3],
            'genre' => $ussd_string_exploded[4],
            'rue_avenue' => $ussd_string_exploded[5],
            'numero' => $ussd_string_exploded[6],
            'quartier' => $ussd_string_exploded[7],
            'commune' => $ussd_string_exploded[8],
            'ville' => $ussd_string_exploded[9],
            'province' => $ussd_string_exploded[10],
            'pays' => "RDC",
            'num_tel'=>$phonenumber
        );

        insertUser($data);

        $response = "END Felicitation cher ".$data["nom"]." ".$data["postnom"]." ".$data["prenom"]." vous êtes enregistré à notre service. ";
    }
    else if ($ussd_string_exploded[0] == 2 && $ussd_string_exploded[11] == 2 && $level == 12) 
    {
        $response = "END Votre enregistrement est annulé veuillez recommencer !";
    }

    function getConnexion()
    {
        $dsn = 'mysql:host=localhost;dbname=securite'; //database name
        $user = 'root'; // your mysql user 
        $password = ''; // your mysql password

        return new PDO($dsn, $user, $password);
    }

    function insertUser($data)
    {
        $connexion = getConnexion();

        $requete = sprintf("INSERT INTO user(nom, postnom, prenom, genre, rue_avenue, numero, quartier, commune, ville, province, pays, num_tel) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
                        $data["nom"], $data["postnom"], $data["prenom"], $data["genre"], $data["rue_avenue"], $data["numero"], $data["quartier"], $data["commune"], $data["ville"], $data["province"], $data["pays"], $data["num_tel"]);
        $result = $connexion-> prepare($requete);
        $result->execute();
    }

    function sendAlert($user_id, $message)
    {
        $connexion = getConnexion();
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $requete = sprintf("INSERT INTO alerte(`message`, `date`, `user_id`) VALUES('%s', '%s', '%s')", $message, $now, $user_id);
        $result = $connexion-> prepare($requete);
        $result->execute();
    }

    function getUser($numPhone) {
        $connexion = getConnexion();
        $reponse = $connexion->prepare('SELECT * FROM user WHERE num_tel= ?');
        $reponse->execute(array($numPhone));
        $data = $reponse -> fetch(PDO::FETCH_ASSOC);
        $reponse->closeCursor();
        return $data;
    }
    
    
    header('Content-type: text/plain');
    echo $response;

?>