<?php

function main_menu()
{
    $text = "Welcome to Loyalty\nPlease Reply with\n1. Register\n2. Transfert points\n3. Purchase Item with Points\n4. Check Points Balance";
    ussd_proceed($text);
}

function ussd_proceed($text)
{
    echo "CON".$text;
}

function ussd_stop($text)
{
    echo "END".$text;
}

function customer_register()
{
    $text = "You can now register";
    ussd_proceed($text);
}

function transfert_point()
{
    $text = "You have transfered 10 points to 90000000000";
    ussd_proceed($text);
}

function purchase_item()
{
    $text = "You have purchase items for 5 point";
    ussd_proceed($text);
}


function check_point()
{
    $text = "Your points balance is 100";
    ussd_proceed($text);
}





?>