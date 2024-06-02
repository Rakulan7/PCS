<?php

require_once __DIR__ . "/../../entities/Voyageurs/createVoyageur.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createVoyageur(
        $body["nom"],
        $body["prenom"],
        $body["email"],
        $body["mot_passe"],
        $body["date_inscription"],
        $body["date_naissance"],
        $body["numero_telephone"],
        $body["pays_telephone"],
        $body["bloque"],
        $body["supprime"]
    )) {
        throw new Exception("Unable to create the voyageur");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created a voyageur"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
