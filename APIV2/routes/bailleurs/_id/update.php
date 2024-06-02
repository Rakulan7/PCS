<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Bailleur/updateBailleur.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/bailleurs/:id");
    $body = getBody();
    
    $bailleur = updateBailleur(
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
        $body["supprime"],
        $body["code_banque"],
        $body["code_guichet"],
        $body["numero_compte"],
        $body["cle_rib"],
        $body["iban"],
        $body["bic_swift"],
        $body["url_rib"]
    );

    if (!$bailleur) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the bailleur"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
