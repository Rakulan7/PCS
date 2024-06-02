<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Bailleur/deleteBailleur.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

try {
    $parameters = getParametersForRoute("/bailleurs/:id");
    $bailleur = deleteBailleur($parameters["id"]);

    if (!$bailleur) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully deleted one bailleur"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
