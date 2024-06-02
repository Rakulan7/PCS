<?php

require_once __DIR__ . "/../../entities/Occupation/getOccupations.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $occupations = getOccupations();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "occupations" => $occupations
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
