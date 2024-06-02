<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/voyageurs/getVoyageur.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

try {
    $parameters = getParametersForRoute("/voyageurs/:id");
    $voyageur = getVoyageur($parameters["id"]);

    if (!$voyageur) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "voyageur" => $voyageur
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
