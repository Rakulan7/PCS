<?php

require_once __DIR__ . "/../../entities/Prestataire/createPrestataire.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createPrestataire(
        $body["refuse_par_admin"],
        $body["raison_refuse"],
        $body["nom"],
        $body["prenom"],
        $body["email"],
        $body["mot_passe"],
        $body["id_administrateur"]
    )) {
        throw new Exception("Unable to create the prestataire");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created a prestataire"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
