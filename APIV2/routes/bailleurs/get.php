<?php

require_once __DIR__ . "/../../entities/Bailleur/getBailleurs.php";
require_once __DIR__ . "/../../libraries/response.php";

try {
    $bailleurs = getBailleurs();

    echo jsonResponse(200, ["X-ESGI" => "2ESGI"], [
        "success" => true,
        "bailleurs" => $bailleurs
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, ["X-ESGI" => "2ESGI"], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
