<?php

function getBailleur(string $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $getBailleurQuery = $databaseConnection->prepare("SELECT * FROM Bailleur WHERE id = :id;");

    $getBailleurQuery->execute([
        "id" => $id
    ]);

    $Bailleur = $getBailleurQuery->fetch(PDO::FETCH_ASSOC);

    return $Bailleur;
}
