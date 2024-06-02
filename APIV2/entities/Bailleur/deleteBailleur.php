<?php

function deleteBailleur(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBailleurQuery = $databaseConnection->prepare("SELECT * FROM Bailleur WHERE id = :id;");

    $getBailleurQuery->execute([
        "id" => $id
    ]);

    $Bailleur = $getBailleurQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Bailleur) {
        return false;
    }

    $deleteBailleurQuery = $databaseConnection->prepare("DELETE FROM Bailleur WHERE id = :id;");

    $success = $deleteBailleurQuery->execute([
        "id" => $id
    ]);

    return $success;
}
