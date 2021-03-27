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
    $ussd_string_exploded = explode("*", $text);

    // Get ussd menu level number from the gateway
    // Obtient le numéro de niveau de menu ussd de la passerelle

    // $level = count($ussd_string_exploded);
    $level = explode("*", $text);
    
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
        $response = "CON Votre nom est s'il vous plait ";
    }
    if($ussd_string_exploded[0] == 2 && $level == 2)
    {
        $response = "CON Votre prenom est s'il vous plait ";
    }
    else if($ussd_string_exploded[0] == 2 && $level == 3)
    {
        $response = "END Merci ".$level[0]." pour vous inscrire.\nNous vous tiendrons au courant" ;
    }
    
    
    header('Content-type: text/plain');
    echo $response;

?>