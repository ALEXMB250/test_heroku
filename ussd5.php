<?php

    // $sessionId   = $_POST["sessionId"];
    // $serviceCode = $_POST["serviceCode"];
    // $phoneNumber = $_POST["phoneNumber"];
    $_POST["text"] = "fksjhdfhk";

    $text = $_POST["text"];

    // use explode to split the string text response from Africa's talking gateway into an array.
    // utilise exploser pour diviser la réponse textuelle de chaîne de la passerelle parlante de l'Afrique en un tableau.

    $ussd_string_exploded = explode("*", $text);

    // Get ussd menu level number from the gateway
    // Obtient le numéro de niveau de menu ussd de la passerelle

    $level = count($ussd_string_exploded);

    print_r($ussd_string_exploded);
    echo "--------";
    print_r($level);die();

    if ($text == "") {

        $response = "CON Bienvenue dans les cours en ligne à HLAB \n" ;
        $response .= "1. Enregistrer \n" ;
        $response .= "2. À propos de HLAB" ;

        // first response when a user dials our ussd code
        // première réponse lorsqu'un utilisateur compose notre code ussd
        // $response  = "CON Welcome to Online Classes at HLAB \n";
        // $response .= "1. Register \n";
        // $response .= "2. About HLAB";
    }

    elseif ($text == "1") {

        $response = "CON Choisissez le framework à apprendre \n" ;
        $response .= "1. Django Web Framework \n" ;
        $response .= "2. Laravel Web Framework" ;

        // when user respond with option one to register

        // $response = "CON Choose which framework to learn \n";
        // $response .= "1. Django Web Framework \n";
        // $response .= "2. Laravel Web Framework";
    }

    elseif ($text == "1*1") {

        $response = "CON Veuillez entrer votre prénom" ;

        // lors de l'utilisation de la réponse avec l'option django
        // when use response with option django
        // $response = "CON Please enter your first name";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 3) {
        $response = "CON Veuillez entrer votre nom de famille" ;
        // $response = "CON Please enter your last name";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 4) {
        $response = "CON Veuillez entrer votre email" ;
        // $response = "CON Please enter your email";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 5) {
        // sauvegarde des données dans la base de données
        $response = "END Vos données ont été capturées avec succès! Merci de vous être inscrit aux cours en ligne Django au HLAB." ;
        
        // save data in the database
        // $response = "END Your data has been captured successfully! Thank you for registering for Django online classes at HLAB.";
    }

    elseif ($text == "1*2") {
        // lors de l'utilisation de la réponse avec l'option Laravel
        $response = "CON Veuillez entrer votre prénom." ;

        // when use response with option Laravel
        // $response = "CON Please enter your first name. ";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 3) {
        $response = "CON Veuillez entrer votre nom de famille" ;
        // $response = "CON Please enter your last name";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 4) {
        $response = "CON Veuillez entrer votre email" ;            
        // $response = "CON Please enter your email";
    }

    elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 2 && $level == 5) {
        // sauvegarde des données dans la base de données
        $response = "END Vos données ont été capturées avec succès! Merci de vous être inscrit aux cours en ligne Laravel au HLAB." ;
        
        // save data in the database
        // $response = "END Your data has been captured successfully! Thank you for registering for Laravel online classes at HLAB.";
    }


    elseif ($text == "2") {
        // Notre réponse un utilisateur répond avec l'entrée 2 de notre premier niveau
        $response = "END Chez HLAB, nous essayons de trouver un bon équilibre entre théorie et pratique !." ;
        
        // Our response a user respond with input 2 from our first level
        // $response = "END At HLAB we try to find a good balance between theory and practical!.";
    }


    // renvoyer votre réponse à l'API
    // send your response back to the API
    
    header('Content-type: text/plain');
    echo $response;

?>