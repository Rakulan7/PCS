<?php

function deleteBien(string $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBienQuery = $databaseConnection->prepare("SELECT * FROM Bien WHERE id = :id;");

    $getBienQuery->execute([
        "id" => $id
    ]);

    $Bien = $getBienQuery->fetch(PDO::FETCH_ASSOC);

    if (!$Bien) {
        return false;
    }

    $deleteBienQuery = $databaseConnection->prepare("DELETE FROM Bien WHERE id = :id;");

    $success = $deleteBienQuery->execute([
        "id" => $id
    ]);

    return $success;
}
