<?php

require_once __DIR__ . "/../../entities/Bien/createBien.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";

try {
    $body = getBody();

    if (!createBien(
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
    )) {
        throw new Exception("Unable to create the bien");
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully created a bien"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
