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
        $response = "Bonjour la police c'est Judith \n";
        $response .= "à la rue busira au quartier Lufira n°50, \n";
        $response .= "commune Katuba signale un cambriolage \n";
        $response .= "END #Au secour insécurité \n";
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
        $response .= "au quartier ".$ussd_string_exploded[7]." commune ".$ussd_string_exploded[8]." ";
        $response .= "dans la ville de ".$ussd_string_exploded[9]." dans la province ".$ussd_string_exploded[10].".\n";
        $response .= "Confirmez-vous toutes ces informations ?\n";
        $response .= "1.Oui ?\n";
        $response .= "2.Non ?";
    }
    else if ($ussd_string_exploded[0] == 2 && $level == 12) 
    {
        $data=array(
            'numTel'=>$phonenumber,
            'nom' =>$ussd_string_exploded[1],
            'postnom' =>$ussd_string_exploded[2],
            'prenom' => $ussd_string_exploded[3],
            'genre' => $ussd_string_exploded[4],
            'rue_avenue' => $ussd_string_exploded[5],
            'numero' => $ussd_string_exploded[6],
            'quartier' => $ussd_string_exploded[7],
            'commune' => $ussd_string_exploded[8],
            'ville' => $ussd_string_exploded[9],
            'province' => $ussd_string_exploded[10]
        );
        $response = "END Felicitation".$data["prenom"]." vous êtes enregistré à notre service. ";
    }
    
    
    header('Content-type: text/plain');
    echo $response;

?>