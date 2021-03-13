<?php

    /* Exemple d'application d'enregistrement USSD simple
    * La passerelle USSD utilisée est la passerelle USSD parlante de l'Afrique
    * /

    /* Simple sample USSD registration application
    * USSD gateway that is being used is Africa's Talking USSD gateway
    */


    // Affiche la réponse en texte brut pour que la passerelle puisse la lire

    // Print the response as plain text so that the gateway can read it
    header('Content-type: text/plain');

    /* configuration de la base de données locale */

    /* local db configuration */
    $dsn = 'mysql:dbname=dbname;host=127.0.0.1;'; //database name
    $user = 'your user'; // your mysql user 
    $password = 'your password'; // your mysql password

    // Créer une instance PDO qui vous permettra d'accéder à votre base de données

    //  Create a PDO instance that will allow you to access your database
    try {
        $dbh = new PDO($dsn, $user, $password);
    }
    catch(PDOException $e) {
        //var_dump($e);
        echo("PDO error occurred");
    }
    catch(Exception $e) {
        //var_dump($e);
        echo("Error occurred");
    }

    // Récupère les paramètres fournis par la passerelle Talking USSD de l'Afrique

    // Get the parameters provided by Africa's Talking USSD gateway
    $phone = $_GET['phoneNumber'];
    $session_id = $_GET['sessionId'];
    $service_code = $_GET['serviceCode'];
    $ussd_string= $_GET['text'];

    // définit le niveau par défaut à zéro

    //set default level to zero
    $level = 0;

    /* Saisie de texte fractionnée basée sur des astériks (*)
    * Africa's Talking ajoute des astériks après chaque niveau de menu ou entrée
    * Il faut séparer la réponse de Africa's Talking afin de déterminer
    * le niveau de menu et l'entrée pour chaque niveau
    * */

    /* Split text input based on asteriks(*)
    * Africa's talking appends asteriks for after every menu level or input
    * One needs to split the response from Africa's Talking in order to determine
    * the menu level and input for each level
    * */
    $ussd_string_exploded = explode ("*",$ussd_string);

    // Récupère le niveau de menu à partir de la réponse ussd_string

    // Get menu level from ussd_string reply
    $level = count($ussd_string_exploded);

    if($level == 1 or $level == 0){
        
        display_menu(); // show the home/first menu
    }

    if ($level > 1)
    {

        if ($ussd_string_exploded[0] == "1")
        {
            // Si l'utilisateur a sélectionné 1, envoyez-les au menu d'enregistrement
            // If user selected 1 send them to the registration menu
            register($ussd_string_exploded,$phone, $dbh);
        }

    else if ($ussd_string_exploded[0] == "2"){
        // Si l'utilisateur a sélectionné 2, envoyez-les au menu à propos
            //If user selected 2, send them to the about menu
            about($ussd_string_exploded);
        }
    }

    /* La fonction ussd_proceed ajoute CON à la réponse USSD fournie par votre application.
    * Cela informe la passerelle Africa's Talking USSD et, par conséquent, celle de Safaricom
    * Passerelle USSD que la session USSD est en cours de session ou devrait continuer
    * Utilisez cette option lorsque vous souhaitez que la session USSD de l'application se poursuive
    */

    /* The ussd_proceed function appends CON to the USSD response your application gives.
    * This informs Africa's Talking USSD gateway and consecuently Safaricom's
    * USSD gateway that the USSD session is till in session or should still continue
    * Use this when you want the application USSD session to continue
    */
    function ussd_proceed($ussd_text){
        echo "CON $ussd_text";
    }

    /* Cette fonction ussd_stop ajoute END à la réponse USSD fournie par votre application.
    * Cela informe la passerelle USSD parlante de l'Afrique et, par conséquent, celle de Safaricom
    * Passerelle USSD sur laquelle la session USSD doit se terminer.
    * Utilisez cette option lorsque vous souhaitez que la session d'application termine / termine l'application
    */

    /* This ussd_stop function appends END to the USSD response your application gives.
    * This informs Africa's Talking USSD gateway and consecuently Safaricom's
    * USSD gateway that the USSD session should end.
    * Use this when you to want the application session to terminate/end the application
    */
    function ussd_stop($ussd_text){
        echo "END $ussd_text";
    }

    // Ceci est la fonction du menu d'accueil

    //This is the home menu function
    function display_menu()
    {
        // "1. Inscrivez-vous \ n 2. À propos de \ n"
        $ussd_text =    "1. Register \n 2. About \n"; // add \n so that the menu has new lines // ajouter \ n pour que le menu ait de nouvelles lignes
        ussd_proceed($ussd_text);
    }


    // Fonction qui gère le menu À propos
    // Function that hanldles About menu
    function about($ussd_text)
    {
        // "Ceci est un exemple d'application d'enregistrement" ;
        $ussd_text =    "This is a sample registration application";
        ussd_stop($ussd_text);
    }

    // Fonction qui gère le menu d'enregistrement
    // Function that handles Registration menu
    function register($details,$phone, $dbh)
    {
        if(count($details) == 2)
        {
            // $ ussd_text = "Veuillez saisir votre nom complet et votre adresse e-mail, chacun séparé par des virgules:" ;
            $ussd_text = "Please enter your Full Name and Email, each seperated by commas:";
            ussd_proceed($ussd_text); // ask user to enter registration details // demande à l'utilisateur de saisir les détails d'inscription // demande à l'utilisateur de saisir les détails d'inscription
        }
        if(count($details)== 3)
        {
            if (empty($details[1])){
                // $ ussd_text = "Désolé, nous n'acceptons pas les valeurs vides" ;
                    $ussd_text = "Sorry we do not accept blank values";
                    ussd_proceed($ussd_text);
            } 
            else {

                $input = explode(",",$details[1]); //store input values in an array // stocker les valeurs d'entrée dans un tableau
                $full_name = $input[0]; //store full name // stocker le nom complet
                $email = $input[1]; //store email // stocker l'email
                $phone_number =$phone; //store phone number // stocker le numéro de téléphone

                // build sql statement // construction d'une instruction SQL
                $sth = $dbh->prepare("INSERT INTO customer (full_name, email, phone) VALUES('$full_name','$email','$phone_number')");
                //execute insert query  // exécute la requête d'insertion 
                $sth->execute();
                if($sth->errorCode() == 0) {
                    // $ ussd_text = $ full_name . "votre inscription a réussi. Votre adresse e-mail est" . $ email . "et le numéro de téléphone est" . $ numéro_téléphone ;
                    $ussd_text = $full_name." your registration was successful. Your email is ".$email." and phone number is ".$phone_number;
                    ussd_proceed($ussd_text);
                } else {
                    $errors = $sth->errorInfo();
                }
            }
        }
    }

    # ferme la connexion pdo 
    # close the pdo connection  
    $dbh = null;
?>