<?php
    #We obtain the data which is contained in the post url on our server.
    #Nous obtenons les données contenues dans l'url de l'article sur notre serveur.

    $sessionId   = $_POST["sessionId"];
    $serviceCode = $_POST["serviceCode"];
    $phoneNumber = $_POST["phoneNumber"];
    $text        = $_POST["text"];

    // $text=$_GET['USSD_STRING'];
    // $phonenumber=$_GET['MSISDN'];
    // $serviceCode=$_GET['serviceCode'];


    $level = explode("*", $text);
    if ($text == "" ) {
        // $response="CON Welcome to the registration portal.\nPlease enter you full name";
        $response = "CON Bienvenue sur le portail d'inscription.\nVeuillez entrer votre nom complet" ;
    }

    if(isset($level[0]) && $level[0]!="" && !isset($level[1])){
        // $response="CON Hi ".$level[0].", enter your ward name";
        $response = "CON Salut " . $level[0].", entrez le nom de votre paroisse" ;
        
    }
    else if(isset($level[1]) && $level[1]!="" && !isset($level[2])){
        // $response="CON Please enter you national ID number\n"; 
        $response = "CON Veuillez entrer votre numéro d'identification national \n" ;

    }
    else if(isset($level[2]) && $level[2]!="" && !isset($level[3]))
    {
        // Enregistrer les données dans la base de données
        $data=array(
            'phonenumber'=>$phonenumber,
            'fullname' =>$level[0],
            'electoral_ward' => $level[1],
            'national_id'=>$level[2]
            );

        // $response="END Thank you ".$level[0]." for registering.\nWe will keep you updated"; 
        $response = "END Merci".$level[0]."pour vous inscrire.\nNous vous tiendrons au courant" ;
    }

    header('Content-type: text/plain');
    echo $response;

?>