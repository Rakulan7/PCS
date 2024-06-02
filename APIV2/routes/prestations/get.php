<?php

require_once __DIR__ . "/../../entities/Prestation/getPrestations.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $prestations = getPrestations();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "prestations" => $prestations
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
