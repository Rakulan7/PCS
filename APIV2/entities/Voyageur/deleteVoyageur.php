<?php

function deleteVoyageur(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getVoyageurQuery = $databaseConnection->prepare("SELECT * FROM Voyageur WHERE id = :id;");

    $getVoyageurQuery->execute([
        "id" => $id
    ]);

    $Voyageur = $getVoyageurQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Voyageur) {
        return false;
    }

    $deleteVoyageurQuery = $databaseConnection->prepare("DELETE FROM Voyageur WHERE id = :id;");

    $success = $deleteVoyageurQuery->execute([
        "id" => $id
    ]);

    return $success;
}
