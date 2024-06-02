<?php

require_once __DIR__ . "/../../entities/Prestataire/getPrestataires.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $prestataires = getPrestataires();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "prestataires" => $prestataires
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
