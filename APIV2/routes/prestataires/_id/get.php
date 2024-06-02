<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Prestataire/getPrestataire.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

try {
    $parameters = getParametersForRoute("/prestataires/:id");
    $prestataire = getPrestataire($parameters["id"]);

    if (!$prestataire) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "prestataire" => $prestataire
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
