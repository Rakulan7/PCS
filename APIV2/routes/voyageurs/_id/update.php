<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Voyageur/updateVoyageur.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/voyageurs/:id");
    $body = getBody();
    
    $voyageur = updateVoyageur(
        $parameters["id"],
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
    );

    if (!$voyageur) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the voyageur"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
