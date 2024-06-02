<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Prestation/updatePrestation.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/prestations/:id");
    $body = getBody();
    
    $prestation = updatePrestation(
        $parameters["id"],
        $body["evaluation"],
        $body["url_fiche"],
        $body["montant"],
        $body["debut_prestation"],
        $body["duree_jour"],
        $body["fin_prestation"],
        $body["id_prestataire"],
        $body["id_voyageur"]
    );

    if (!$prestation) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the prestation"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
