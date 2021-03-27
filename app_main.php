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
    }
    else if ($text == "1") 
    {    
    }
    else if ($text == "2") 
    {        
    }
    if(isset($level[0]) && $level[0]!="" && !isset($level[1]))
    {
    }
    else if(isset($level[1]) && $level[1]!="" && !isset($level[2]))
    {
    }
    else if(isset($level[2]) && $level[2]!="" && !isset($level[3]))
    {
    }
    else if(isset($level[3]) && $level[3]!="" && !isset($level[4]))
    {
    }else if(isset($level[4]) && $level[4]!="" && !isset($level[5]))
    {
    }
    else if(isset($level[5]) && $level[5]!="" && !isset($level[6]))
    {
    }
    else if(isset($level[6]) && $level[6]!="" && !isset($level[7]))
    {
    }else if(isset($level[7]) && $level[7]!="" && !isset($level[8]))
    {
    }else if(isset($level[8]) && $level[8]!="" && !isset($level[9]))
    {
    }

    header('Content-type: text/plain');
    echo $response;

?>