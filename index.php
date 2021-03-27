<?php

// Lit les variables envoyées via POST

$sessionId = $_POST["sessionId"];

$serviceCode = $_POST["serviceCode"];

$phoneNumber = $_POST["phoneNumber"];

$text = $_POST["text"];

// Ceci est le premier écran de menu

if($text == "") {
    $response = "CON Option Insécurité à Lubumbashi \n";
    $response .= "1. Signaler un cambriolage \n";
    $response .= "2. Créer un compte \n";

} 

else if ($text == "1") {
    $response = "Bonjour la police c'est Judith \n";
    $response .= "à la rue busira au quartier Lufira n°50, \n";
    $response .= "commune Katuba signale un cambriolage \n";
    $response .= "END #Au secour insécurité \n";

}

else if ($text == "2") {
    $response = "CON Votre nom est s'il vous plait ";

}

elseif ($ussd_string_exploded[0] == 2 && $level == 3) {
    // $ response = "CON Veuillez entrer votre nom de famille" ;
    $response = "CON Votre postnom est s'il vous plait";
}

elseif ($ussd_string_exploded[0] == 2 && $level == 4) {
    // $ response = "CON Veuillez entrer votre email" ;            
    $response = "CON Please enter your email";
}

else if ($text == "2*1") {
    $response = "CON Votre nom est ".$phoneNumber;

}

else if ($text == "1*1") {
    $accountNumber = "ACC1001";

    $response = "END Your phone number is ".$accountNumber;

}

else if ($text == "1*2") {
    $balance = "KES 10,000".$accountNumber;

    $response = "END Your balance is ".$balance;

}

header("Content-type: text/plain");
echo $response;

?>
