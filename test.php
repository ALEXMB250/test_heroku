<?php

    function getConnexion()
    {
        $dsn = 'mysql:host=localhost;dbname=securite'; //database name
        $user = 'root'; // your mysql user 
        $password = ''; // your mysql password

        return new PDO($dsn, $user, $password);
    }

    function insertUser($data)
    {
        $connexion = getConnexion();

        $requete = sprintf("INSERT INTO user(nom, postnom, prenom, genre, rue_avenue, numero, quartier, commune, ville, province, pays, num_tel) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
                        $data["nom"], $data["postnom"], $data["prenom"], $data["genre"], $data["rue_avenue"], $data["numero"], $data["quartier"], $data["commune"], $data["ville"], $data["province"], $data["pays"], $data["num_tel"]);
        $result = $connexion-> prepare($requete);
        $result->execute();
    }

    function sendAlert($user_id, $message)
    {
        $connexion = getConnexion();
        $now = (new DateTime())->format('Y-m-d H:i:s');
        $requete = sprintf("INSERT INTO alerte(`message`, `date`, `user_id`) VALUES('%s', '%s', '%s')", $message, $now, $user_id);
        $result = $connexion-> prepare($requete);
        $result->execute();
    }

    function getUser($numPhone) {
        $connexion = getConnexion();
        $reponse = $connexion->prepare('SELECT * FROM user WHERE num_tel= ?');
        $reponse->execute(array($numPhone));
        $data = $reponse -> fetch(PDO::FETCH_ASSOC);
        $reponse->closeCursor();
        return $data;
    }

    $phoneNumber = "0971834060";

    $data = getUser($phoneNumber);

    // $message  = "ALERTE INSECURITE : Monsieur ".$data["nom"]." ".$data["postnom"]." ".$data["prenom"]. " vient de lancer une alerte depuis l\'avenue ou rue ".$data["rue_avenue"]." Numero ".$data["numero"]." au quartier ".$data["quartier"]." dans la commune de ".$data["commune"]." dans la ville de ".$data["ville"]." dans la province ".$data["province"]." #Au secour police.";

    $message  = "ALERTE INSECURITE : Monsieur ".$data["nom"]." ".$data["postnom"]." ".$data["prenom"]." ";
    $message .= "vient de lancer une alerte depuis l\'avenue/rue ".$data["rue_avenue"]." N°".$data["numero"]." ";
    $message .= "au quartier ".$data["quartier"]." dans la commune de ".$data["commune"]." ";
    $message .= "dans la ville de ".$data["ville"]." dans la province ".$data["province"]." \n";
    $message .= "#Au secour police.";

    sendAlert($data["id_user"], $message);

    echo "OK ".$data["id_user"]. " ".$message;

?>