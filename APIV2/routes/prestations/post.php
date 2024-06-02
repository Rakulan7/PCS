<?php

require_once __DIR__ . "/../../entities/Prestation/createPrestation.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createPrestation(
        $body["evaluation"],
        $body["url_fiche"],
        $body["montant"],
        $body["debut_prestation"],
        $body["duree_jour"],
        $body["fin_prestation"],
        $body["id_prestataire"],
        $body["id_voyageur"]
    )) {
        throw new Exception("Unable to create the prestation");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created a prestation"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
