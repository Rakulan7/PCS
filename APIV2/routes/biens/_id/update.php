<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Bien/updateBien.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";

try {
    $parameters = getParametersForRoute("/biens/:id");
    $body = getBody();
    
    $bien = updateBien(
        $parameters["id"],
        $body["refuse_par_admin"],
        $body["raison_refuse"],
        $body["numero_rue"],
        $body["type_rue"],
        $body["rue"],
        $body["ville"],
        $body["code_postal"],
        $body["pays"],
        $body["titre"],
        $body["description"],
        $body["nombre_chambre"],
        $body["nombre_salle_de_bain"],
        $body["nombre_toilette"],
        $body["prix"],
        $body["taille"],
        $body["id_administrateur"],
        $body["id_bailleur"]
    );

    if (!$bien) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully updated the bien"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
