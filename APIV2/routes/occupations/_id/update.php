<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Occupation/updateOccupation.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/occupations/:id");
    $body = getBody();
    
    $occupation = updateOccupation(
        $parameters["id"],
        $body["date_debut"],
        $body["date_fin"],
        $body["raison_indispo"],
        $body["montant"],
        $body["nombre_personne"],
        $body["id_bailleur"],
        $body["id_voyageur"],
        $body["id_bien"]
    );

    if (!$occupation) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the occupation"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
