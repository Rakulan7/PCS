<?php

require_once __DIR__ . "/../../entities/Bien/getBiens.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $biens = getBiens();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "biens" => $biens
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
