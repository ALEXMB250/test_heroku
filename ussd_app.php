<?php

    header('Content-type: text/plain');
    include("function.php");

    $phone = $_GET['phoneNumber'];
    // $session_id = $_GET['sessionId'];
    // $service_code = $_GET['serviceCode'];
    $text= $_GET['text'];

    $data = explode("*", $text);

    $level = 0;
    $level = count($data);

    echo $level;

    if ($level == 0 || $level == 1) {
        main_menu();
    }

    if ($level > 1) {
        switch ($data[1]) {
            case 1:
                customer_register();
                break;

            case 2:
                transfert_point();
                break;

            case 3:
                purchase_item();
                break;

            case 4:
                check_point();
                break;

            default:
                $text = "Invalid text input\nPlease insert a valid menu option";
                ussd_stop($text);
                break;
        }
    }

?>