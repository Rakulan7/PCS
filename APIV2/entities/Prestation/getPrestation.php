<?php

function getService(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getServiceQuery = $databaseConnection->prepare("SELECT * FROM Service WHERE id = :id;");

    $getServiceQuery->execute([
        "id" => $id
    ]);

    $Service = $getServiceQuery->fetch(PDO::FETCH_ASSOC);

    return $Service;
}
