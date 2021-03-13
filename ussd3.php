<?php

    header('Content-type: text/plain');
    
    $phone = $_GET['phoneNumber'];
    $session_id = $_GET['sessionId'];
    $service_code = $_GET['serviceCode'];
    $ussd_string= $_GET['text'];
    
    $level = 0;
    
    $ussd_string_exploded = explode ("*",$ussd_string);
    
    $level = count($ussd_string_exploded);

    if($level == 1 or $level == 0){
        
        display_menu(); // show the home/first menu
    }

    if ($level > 1)
    {

        if ($ussd_string_exploded[0] == "1")
        {
            register($ussd_string_exploded,$phone, $dbh);
        }

    else if ($ussd_string_exploded[0] == "2"){
            about($ussd_string_exploded);
        }
    }

    function ussd_proceed($ussd_text){
        echo "CON $ussd_text";
    }
    
    function ussd_stop($ussd_text){
        echo "END $ussd_text";
    }
    
    function display_menu()
    {
        $ussd_text =    "1. Register \n 2. About \n"; // add \n so that the menu has new lines // ajouter \ n pour que le menu ait de nouvelles lignes
        ussd_proceed($ussd_text);
    }
    
    function about($ussd_text)
    {
        $ussd_text =    "This is a sample registration application";
        ussd_stop($ussd_text);
    }

    function register($details,$phone, $dbh)
    {
        if(count($details) == 2)
        {
            $ussd_text = "Please enter your Full Name and Email, each seperated by commas:";
            ussd_proceed($ussd_text); // ask user to enter registration details // demande à l'utilisateur de saisir les détails d'inscription // demande à l'utilisateur de saisir les détails d'inscription
        }
        if(count($details)== 3)
        {
            if (empty($details[1])){
                $ussd_text = "Sorry we do not accept blank values";
                ussd_proceed($ussd_text);
            } 
            else {

                $input = explode(",",$details[1]); //store input values in an array // stocker les valeurs d'entrée dans un tableau
                $full_name = $input[0]; //store full name // stocker le nom complet
                $email = $input[1]; //store email // stocker l'email
                $phone_number =$phone; //store phone number // stocker le numéro de téléphone

                $ussd_text = $full_name." your registration was successful. Your email is ".$email." and phone number is ".$phone_number;
                ussd_proceed($ussd_text);
            }
        }
    }
     
    $dbh = null;
?>