<?php

require_once __DIR__ . "/../../entities/Occupation/createOccupation.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createOccupation(
        $body["date_debut"],
        $body["date_fin"],
        $body["raison_indispo"],
        $body["montant"],
        $body["nombre_personne"],
        $body["id_bailleur"],
        $body["id_voyageur"],
        $body["id_bien"]
    )) {
        throw new Exception("Unable to create the occupation");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created an occupation"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
