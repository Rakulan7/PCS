<?php

require_once __DIR__ . "/../../entities/Bailleur/createBailleur.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createBailleur(
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
    )) {
        throw new Exception("Unable to create the bailleur");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created a bailleur"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
