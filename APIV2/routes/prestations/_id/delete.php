<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/Prestation/deletePrestation.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

try {
    $parameters = getParametersForRoute("/prestations/:id");
    $prestation = deletePrestation($parameters["id"]);

    if (!$prestation) {
        echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
            "success" => false,
            "error" => "Not found"
        ]);

        die();
    }

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "message" => "Successfully deleted one prestation"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
