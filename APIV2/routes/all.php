<?php

require_once __DIR__ . "/../libraries/response.php";

echo jsonResponse(404, ["X-ESGI" => "2ESGI"], [
    "success" => false,
    "error" => "Not found"
]);
