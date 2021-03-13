<!-- Licence MIT
Droits d'auteur (c) 2016 Derrick Rono
L'autorisation est par la présente accordée, gratuitement, à toute personne obtenant une copie
de ce logiciel et des fichiers de documentation associés (le «Logiciel»), pour traiter
dans le Logiciel sans restriction, y compris sans limitation les droits
pour utiliser, copier, modifier, fusionner, publier, distribuer, sous-licencier et / ou vendre
copies du Logiciel, et pour permettre aux personnes à qui le Logiciel est
fourni à cet effet, sous réserve des conditions suivantes:
L'avis de droit d'auteur ci-dessus et cet avis d'autorisation doivent être inclus dans tous
copies ou parties substantielles du logiciel.
LE LOGICIEL EST FOURNI "EN L'ÉTAT", SANS GARANTIE D'AUCUNE SORTE, EXPRESSE OU
IMPLICITE, Y COMPRIS MAIS SANS S'Y LIMITER LES GARANTIES DE QUALITÉ MARCHANDE,
ADAPTATION À UN USAGE PARTICULIER ET NON-CONTREFAÇON. EN AUCUN CAS LE
LES AUTEURS OU LES TITULAIRES DE COPYRIGHT SONT RESPONSABLES DE TOUTE RÉCLAMATION, DOMMAGES OU AUTRES
RESPONSABILITÉ, QUE CE SOIT DANS UNE ACTION DE CONTRAT, DE TORT OU AUTRE, DÉCOULANT DE,
HORS OU EN LIEN AVEC LE LOGICIEL OU L'UTILISATION OU D'AUTRES ACTIONS DANS LE
LOGICIEL. -->

<?php
    #Nous obtenons les données contenues dans l'url de l'article sur notre serveur.

    $text=$_GET['USSD_STRING'];
    $phonenumber=$_GET['MSISDN'];
    $serviceCode=$_GET['serviceCode'];


    $level = explode("*", $text);
    if (isset($text)) 
    {
        if ($text == "") {
            $response = "CON Bienvenue sur le portail d'inscription. \n Veuillez entrer votre nom complet" ;
        }
        if(isset($level[0]) && $level[0]!="" && !isset($level[1])){
            $response = "CON Salut".$level[ 0 ].", entrez le nom de votre paroisse" ;                
        }
        else if(isset($level[1]) && $level[1]!="" && !isset($level[2])){
            $response = "CON Veuillez entrer votre numéro d'identification national \n" ;
        }
        else if(isset($level[2]) && $level[2]!="" && !isset($level[3])){
            // Enregistrer les données dans la base de données
            $data=array(
                'phonenumber'=>$phonenumber,
                'fullname' =>$level[0],
                'electoral_ward' => $level[1],
                'national_id'=>$level[2]
                );
            $response = "END Merci" .$level[0]. "pour vous inscrire. \n Nous vous tiendrons au courant" ;
        }
        header('Content-type: text/plain');
        echo $response;
    }
?>