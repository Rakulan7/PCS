<?php

require_once __DIR__ . "/../../entities/Voyageur/getVoyageurs.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $voyageurs = getVoyageurs();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "voyageurs" => $voyageurs
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
