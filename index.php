<?php

// Lit les variables envoyées via POST

$sessionId = $_POST["sessionId"];

$serviceCode = $_POST["serviceCode"];

$phoneNumber = $_POST["phoneNumber"];

$text = $_POST["text"];

// Ceci est le premier écran de menu

if($text == "") {
    $response = "CON What do you want to check \n";
    $response .= "1. My Account No \n";
    $response .= "2. My Phone Number \n";

} 

else if ($text == "1") {
    $response = "CON Choose account information you want to view \n";
    $response .= "1. Account Number \n";
    $response .= "2. Account Balance \n";

}

else if ($text == "2") {
    $response = "END Your phone number is ".$phoneNumber;

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
