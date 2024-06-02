<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Prestataire/updatePrestataire.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/prestataires/:id");
    $body = getBody();
    
    $prestataire = updatePrestataire(
        $parameters["id"],
        $body["refuse_par_admin"],
        $body["raison_refuse"],
        $body["nom"],
        $body["prenom"],
        $body["email"],
        $body["mot_passe"],
        $body["id_administrateur"]
    );

    if (!$prestataire) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the prestataire"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
