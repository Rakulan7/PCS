<?php

function deleteService(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getServiceQuery = $databaseConnection->prepare("SELECT * FROM Service WHERE id = :id;");

    $getServiceQuery->execute([
        "id" => $id
    ]);

    $Service = $getServiceQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Service) {
        return false;
    }

    $deleteServiceQuery = $databaseConnection->prepare("DELETE FROM Service WHERE id = :id;");

    $success = $deleteServiceQuery->execute([
        "id" => $id
    ]);

    return $success;
}
